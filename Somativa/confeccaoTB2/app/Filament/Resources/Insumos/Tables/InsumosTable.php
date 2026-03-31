<?php

namespace App\Filament\Resources\Insumos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InsumosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->label('Nome do Insumo')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-cube'),
                
                TextColumn::make('unidade_medida')
                    ->label('Unidade')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('preco_custo')
                    ->label('Preço de Custo')
                    ->money('BRL')
                    ->sortable(),
                
                TextColumn::make('estoque')
                    ->label('Estoque')
                    ->numeric()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('unidade_medida')
                    ->label('Filtrar por Unidade')
                    ->options([
                        'kg' => 'Quilograma (kg)',
                        'g' => 'Grama (g)',
                        'm' => 'Metro (m)',
                        'm2' => 'Metro Quadrado (m²)',
                        'un' => 'Unidade (un)',
                        'l' => 'Litro (l)',
                        'ml' => 'Mililitro (ml)',
                    ])
                    ->native(false),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped();
    }
}
