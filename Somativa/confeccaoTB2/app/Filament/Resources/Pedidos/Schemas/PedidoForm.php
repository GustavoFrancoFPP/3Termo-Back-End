<?php

namespace App\Filament\Resources\Pedidos\Schemas;

use App\Support\CurrencyFormatter;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class PedidoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('cliente_id')
                    ->label('Cliente')
                    ->required()
                    ->numeric(),

                TextInput::make('status')
                    ->label('Status')
                    ->required()
                    ->default('Pendente'),

                TextInput::make('valor_total')
                    ->label('Valor Total')
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
            ]);
    }
}
