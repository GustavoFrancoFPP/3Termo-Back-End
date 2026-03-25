<?php

namespace App\Filament\Resources\Insumos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InsumoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nome')->required(),
                TextInput::make('unidade_medida')->required(),
                Select::make('unidade_medida')->options(['kg' => 'Kg', 'm' => 'Metros', 'L' => 'Litro'])->native(false),
                TextInput::make('preco_custo')->numeric(),
                TextInput::make('estoque')->required()->numeric(),
            ]);
    }
}
