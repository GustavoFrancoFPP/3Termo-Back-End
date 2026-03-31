<?php

namespace App\Filament\Resources\Produtos\Schemas;

use App\Support\CurrencyFormatter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class ProdutoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nome')
                    ->label('Nome')
                    ->required(),

                TextInput::make('referencia')
                    ->label('Referência'),

                Textarea::make('descricao')
                    ->label('Descrição do Produto')
                    ->rows(4)
                    ->placeholder('Descreva o produto aqui.')
                    ->columnSpanFull(),

                TextInput::make('preco_venda')
                    ->label('Preço de Venda')
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
                    ->numeric()
                    ->default(0)
                    ->readOnly()
                    ->helperText('Atualizado automaticamente pelas movimentações em Estoques.'),
            ]);
    }
}
