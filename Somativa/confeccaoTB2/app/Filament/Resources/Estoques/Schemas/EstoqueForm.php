<?php

namespace App\Filament\Resources\Estoques\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class EstoqueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Movimentação de Estoque')
                    ->icon('heroicon-m-inbox-stack')
                    ->columns(2)
                    ->schema([
                        Select::make('produto_id')
                            ->label('Produto')
                            ->relationship('produto', 'nome')
                            ->searchable()
                            ->preload()
                            ->helperText('Selecione o produto que terá o estoque atualizado.')
                            ->required(),

                        TextInput::make('quantidade')
                            ->label('Quantidade')
                            ->numeric()
                            ->step(1)
                            ->inputMode('numeric')
                            ->default(1)
                            ->minValue(1)
                            ->rule('integer')
                            ->helperText('Somente números inteiros, sem casas decimais.')
                            ->required(),

                        Select::make('tipo_movimento')
                            ->label('Tipo de Movimento')
                            ->options([
                                'entrada' => 'Entrada',
                                'saida' => 'Saída',
                            ])
                            ->helperText('Entrada soma ao estoque do produto e saída subtrai.')
                            ->default('entrada')
                            ->live()
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('tipo', $state ?? 'entrada'))
                            ->required(),

                        Hidden::make('tipo')
                            ->default('entrada'),
                    ]),
            ]);
    }
}
