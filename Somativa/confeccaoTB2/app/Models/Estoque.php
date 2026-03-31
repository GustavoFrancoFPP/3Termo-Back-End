<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estoque extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::created(fn (Estoque $estoque) => $estoque->applyMovement());
        static::updated(fn (Estoque $estoque) => $estoque->syncMovementChanges());
        static::deleted(fn (Estoque $estoque) => $estoque->revertMovement());
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }

    public function applyMovement(): void
    {
        $this->adjustProductStock($this->produto_id, $this->movementDelta());
    }

    public function revertMovement(): void
    {
        $this->adjustProductStock($this->produto_id, -1 * $this->movementDelta());
    }

    public function syncMovementChanges(): void
    {
        $originalProdutoId = $this->getOriginal('produto_id') ?: $this->produto_id;
        $originalQuantidade = (int) ($this->getOriginal('quantidade') ?? 0);
        $originalTipo = $this->getOriginal('tipo_movimento') ?: 'entrada';

        $this->adjustProductStock($originalProdutoId, -1 * $this->movementDelta($originalQuantidade, $originalTipo));
        $this->adjustProductStock($this->produto_id, $this->movementDelta());
    }

    protected function movementDelta(?int $quantidade = null, ?string $tipoMovimento = null): int
    {
        $quantidade = max(0, (int) ($quantidade ?? $this->quantidade ?? 0));
        $tipoMovimento = $tipoMovimento ?? $this->tipo_movimento ?? 'entrada';

        return $tipoMovimento === 'saida' ? -$quantidade : $quantidade;
    }

    protected function adjustProductStock(?int $produtoId, int $delta): void
    {
        if (! $produtoId || $delta === 0) {
            return;
        }

        $produto = Produto::find($produtoId);

        if (! $produto) {
            return;
        }

        $produto->update([
            'estoque' => max(0, ((int) $produto->estoque) + $delta),
        ]);
    }
}
