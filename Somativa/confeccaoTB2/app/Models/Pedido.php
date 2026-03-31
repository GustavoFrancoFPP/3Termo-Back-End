<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    public const STATUS_CONCLUIDO = 'Concluído';

    protected $guarded = [];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function itens(): HasMany
    {
        return $this->hasMany(ItemPedido::class);
    }

    public function syncProductStock(?string $previousStatus = null, array $previousItems = []): void
    {
        if ($this->isFinalized($previousStatus)) {
            $this->applyStockAdjustment($previousItems, restore: true);
        }

        if ($this->isFinalized()) {
            $this->applyStockAdjustment($this->currentItemQuantities());
        }
    }

    public function currentItemQuantities(): array
    {
        return $this->itens()
            ->get()
            ->groupBy('produto_id')
            ->map(fn ($items) => (int) $items->sum('quantidade'))
            ->all();
    }

    public function isFinalized(?string $status = null): bool
    {
        return ($status ?? $this->status) === self::STATUS_CONCLUIDO;
    }

    protected function applyStockAdjustment(array $itemQuantities, bool $restore = false): void
    {
        foreach ($itemQuantities as $produtoId => $quantidade) {
            $quantidade = max(0, (int) $quantidade);

            if (! $produtoId || $quantidade <= 0 || ! Produto::whereKey($produtoId)->exists()) {
                continue;
            }

            $tipoMovimento = $restore ? 'entrada' : 'saida';

            Estoque::create([
                'produto_id' => $produtoId,
                'quantidade' => $quantidade,
                'tipo_movimento' => $tipoMovimento,
                'tipo' => $tipoMovimento,
                'observacao' => $restore
                    ? "Reposição automática do pedido #{$this->id}"
                    : "Baixa automática do pedido #{$this->id}",
            ]);
        }
    }
}
