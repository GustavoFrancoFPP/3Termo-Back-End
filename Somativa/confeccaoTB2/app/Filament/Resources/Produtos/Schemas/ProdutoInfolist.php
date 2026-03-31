<?php

namespace App\Filament\Resources\Produtos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProdutoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextEntry::make('nome')
                    ->label('Nome'),

                TextEntry::make('referencia')
                    ->label('Referência')
                    ->placeholder('-'),

                TextEntry::make('descricao')
                    ->label('Descrição do Produto')
                    ->placeholder('-')
                    ->columnSpanFull(),

                TextEntry::make('preco_venda')
                    ->label('Preço de Venda')
                    ->money('BRL')
                    ->placeholder('-'),

                TextEntry::make('estoque')
                    ->label('Quantidade em Estoque')
                    ->numeric(),

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
