<?php

namespace App\Filament\Resources\Estoques\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EstoquesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('produto.nome')
                    ->label('Produto')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quantidade')
                    ->label('Qtd. Movimentada')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('produto.estoque')
                    ->label('Estoque Atual')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('tipo_movimento')
                    ->label('Movimento')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'saida' ? 'danger' : 'success'),

                TextColumn::make('observacao')
                    ->label('Observação')
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
