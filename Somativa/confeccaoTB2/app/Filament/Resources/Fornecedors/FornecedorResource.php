<?php

namespace App\Filament\Resources\Fornecedors;

use App\Filament\Resources\Fornecedors\Pages\CreateFornecedor;
use App\Filament\Resources\Fornecedors\Pages\EditFornecedor;
use App\Filament\Resources\Fornecedors\Pages\ListFornecedors;
use App\Filament\Resources\Fornecedors\Pages\ViewFornecedor;
use App\Filament\Resources\Fornecedors\Schemas\FornecedorForm;
use App\Filament\Resources\Fornecedors\Schemas\FornecedorInfolist;
use App\Filament\Resources\Fornecedors\Tables\FornecedorsTable;
use App\Models\Fornecedor;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FornecedorResource extends Resource
{
    protected static ?string $model = Fornecedor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Fornecedores';

    protected static ?string $modelLabel = 'Fornecedor';

    protected static ?string $pluralModelLabel = 'Fornecedores';

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Schema $schema): Schema
    {
         return FornecedorForm::configure($schema);
        return $schema
        ->schema([
            TextInput::make('nome')->required()->label('Nome'),
            TextInput::make('email')->email()->label('E-mail'),
            TextInput::make('telefone')->tel()->label('Telefone/ZAP')->mask('(99) 99999-9999'),
            TextInput::make('cnpj')->label('CNPJ')->mask('99.999.999/9999-99'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FornecedorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
         return FornecedorsTable::configure($table);
        return $table
        ->columns([
            TextColumn::make('nome')->searchable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('telefone'),
            TextColumn::make('cnpj')
        ]);
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
            'index' => ListFornecedors::route('/'),
            'create' => CreateFornecedor::route('/create'),
            'view' => ViewFornecedor::route('/{record}'),
            'edit' => EditFornecedor::route('/{record}/edit'),
        ];
    }
}
