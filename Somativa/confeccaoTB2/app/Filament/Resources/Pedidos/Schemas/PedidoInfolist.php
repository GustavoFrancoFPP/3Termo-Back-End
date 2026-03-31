<?php

namespace App\Filament\Resources\Pedidos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PedidoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextEntry::make('cliente.nome')
                    ->label('Cliente')
                    ->placeholder('-'),

                TextEntry::make('status')
                    ->label('Status'),

                TextEntry::make('valor_total')
                    ->label('Valor Total')
                    ->money('BRL')
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
            ]);
    }
}
