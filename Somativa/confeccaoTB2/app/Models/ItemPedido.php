<?php

namespace App\Models;

use App\Support\CurrencyFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemPedido extends Model
{
    protected $guarded = [];

    protected $casts = [
        'quantidade' => 'integer',
        'preco_unitario' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (ItemPedido $item): void {
            $preco = CurrencyFormatter::toFloat($item->preco_unitario);

            if ($preco <= 0 && filled($item->produto_id)) {
                $preco = CurrencyFormatter::toFloat(
                    Produto::find($item->produto_id)?->preco_venda ?? 0
                );
            }

            $item->quantidade = max(1, (int) ($item->quantidade ?? 1));
            $item->preco_unitario = number_format($preco, 2, '.', '');
        });
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
}
