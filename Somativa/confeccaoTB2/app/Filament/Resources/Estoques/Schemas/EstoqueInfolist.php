<?php

namespace App\Filament\Resources\Estoques\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EstoqueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detalhes do Estoque')
                    ->icon('heroicon-m-inbox-stack')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('produto.nome')
                            ->label('Produto')
                            ->columnSpanFull(),

                        TextEntry::make('quantidade')
                            ->label('Qtd. Movimentada')
                            ->numeric(),

                        TextEntry::make('produto.estoque')
                            ->label('Estoque Atual')
                            ->numeric(),

                        TextEntry::make('tipo_movimento')
                            ->label('Tipo de Movimento')
                            ->formatStateUsing(fn (string $state): string => $state === 'saida' ? 'Saída (subtrai)' : 'Entrada (soma)'),

                        TextEntry::make('observacao')
                            ->label('Observação')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Auditoria')
                    ->icon('heroicon-m-information-circle')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
