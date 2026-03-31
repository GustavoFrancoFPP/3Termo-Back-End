<?php

namespace App\Filament\Resources\Insumos\Schemas;

use App\Support\CurrencyFormatter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class InsumoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nome')
                    ->label('Nome do Insumo')
                    ->required(),

                Select::make('unidade_medida')
                    ->label('Unidade de Medida')
                    ->options([
                        'kg' => 'Kg',
                        'm' => 'Metros',
                        'l' => 'Litro',
                        'un' => 'Unidade',
                    ])
                    ->native(false)
                    ->required(),

                TextInput::make('preco_custo')
                    ->label('Preço de Custo')
                    ->prefix('R$')
                    ->placeholder('0,00')
                    ->helperText('Ex.: ao digitar 1234, o campo vira 12,34 automaticamente.')
                    ->mask(RawJs::make(<<<'JS'
$money((($input ?? '').replace(/\D/g, '').replace(/^0+(?=\d)/, '').padStart(3, '0')).replace(/(\d+)(\d{2})$/, '$1,$2'), ',', '.', 2)
JS))
                    ->dehydrateStateUsing(fn ($state) => CurrencyFormatter::fromInput($state))
                    ->formatStateUsing(fn ($state) => CurrencyFormatter::formatForInput($state))
                    ->default('0,00')
                    ->inputMode('decimal'),

                TextInput::make('estoque')
                    ->label('Quantidade em Estoque')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
            ]);
    }
}
