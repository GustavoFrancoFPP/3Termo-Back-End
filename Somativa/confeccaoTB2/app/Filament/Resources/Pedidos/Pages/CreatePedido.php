<?php

namespace App\Filament\Resources\Pedidos\Pages;

use App\Filament\Resources\Pedidos\PedidoResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePedido extends CreateRecord
{
    protected static string $resource = PedidoResource::class;

    protected function afterCreate(): void
    {
        $pedido = $this->record->fresh('itens');

        $total = $pedido->itens->sum(fn ($item) => $item->quantidade * $item->preco_unitario);

        $pedido->update(['valor_total' => $total]);
        $pedido->syncProductStock();
    }
}
