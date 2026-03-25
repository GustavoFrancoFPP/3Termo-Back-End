<?php

namespace App\Filament\Resources\Insumos;

use App\Filament\Resources\Insumos\Pages\CreateInsumo;
use App\Filament\Resources\Insumos\Pages\EditInsumo;
use App\Filament\Resources\Insumos\Pages\ListInsumos;
use App\Filament\Resources\Insumos\Pages\ViewInsumo;
use App\Filament\Resources\Insumos\Schemas\InsumoForm;
use App\Filament\Resources\Insumos\Schemas\InsumoInfolist;
use App\Filament\Resources\Insumos\Tables\InsumosTable;
use App\Models\Insumo;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;


class InsumoResource extends Resource
{
    protected static ?string $model = Insumo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Insumo';

    public static function form(Schema $schema): Schema
    {
         return InsumoForm::configure($schema);
        return $schema
        ->schema([
            TextInput::make('nome')->required()->label('Nome'),
            TextInput::make('unidade_medida')->label('Unidade de Medida'),
            Select::make('unidade_medida')->options(['kg' => 'Kg','m' => 'Metros','L' => 'Litro',])->native(false),
            TextInput::make('preco_custo')->numeric()->prefix('R$')->label('Preço de Custo'),
            TextInput::make('estoque')->numeric()->default(0)->mask('999.999,00'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InsumoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InsumosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInsumos::route('/'),
            'create' => CreateInsumo::route('/create'),
            'view' => ViewInsumo::route('/{record}'),
            'edit' => EditInsumo::route('/{record}/edit'),
        ];
    }
}
