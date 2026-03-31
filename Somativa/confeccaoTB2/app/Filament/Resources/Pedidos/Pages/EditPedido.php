<?php

namespace App\Filament\Resources\Pedidos\Pages;

use App\Filament\Resources\Pedidos\PedidoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPedido extends EditRecord
{
    protected static string $resource = PedidoResource::class;

    protected ?string $previousStatus = null;

    protected array $previousItems = [];

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $this->previousStatus = $this->record->status;
        $this->previousItems = $this->record->currentItemQuantities();
    }

    protected function afterSave(): void
    {
        $pedido = $this->record->fresh('itens');

        $total = $pedido->itens->sum(fn ($item) => $item->quantidade * $item->preco_unitario);

        $pedido->update(['valor_total' => $total]);
        $pedido->syncProductStock($this->previousStatus, $this->previousItems);
    }
}
