<?php

namespace App\Filament\Resources\Produtos;

use App\Filament\Resources\Produtos\Pages\CreateProduto;
use App\Filament\Resources\Produtos\Pages\EditProduto;
use App\Filament\Resources\Produtos\Pages\ListProdutos;
use App\Filament\Resources\Produtos\Pages\ViewProduto;
use App\Filament\Resources\Produtos\Schemas\ProdutoForm;
use App\Filament\Resources\Produtos\Schemas\ProdutoInfolist;
use App\Filament\Resources\Produtos\Tables\ProdutosTable;
use App\Models\Produto;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;

class ProdutoResource extends Resource
{
    protected static ?string $model = Produto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Produtos';

    protected static ?string $modelLabel = 'Criar Produto';

    protected static ?string $pluralModelLabel = 'Produtos';

    protected static string|UnitEnum|null $navigationGroup = 'Vendas';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'Produto';

    public static function form(Schema $schema): Schema
    {
        // return ProdutoForm::configure($schema);
        return $schema
        ->schema([
            TextInput::make('nome')->required()->label('Nome'),
            TextInput::make('referencia')->required()->label('Referência'),
            TextInput::make('preco_venda')->numeric()->prefix('R$')->label('Preço de Venda'),
            TextInput::make('estoque')->numeric()->default(0)->label('Estoque Atual'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProdutoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // return ProdutosTable::configure($table);
        return $table
        ->columns([
            TextColumn::make('nome')->searchable(),
            TextColumn::make('referencia')->searchable(),
            TextColumn::make('preco_venda'),
            TextColumn::make('estoque'),
        ])
        ->recordActions([
            ViewAction::make()->label('Visualizar'),
            EditAction::make()->label('Editar'),
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
            'index' => ListProdutos::route('/'),
            'create' => CreateProduto::route('/create'),
            'view' => ViewProduto::route('/{record}'),
            'edit' => EditProduto::route('/{record}/edit'),
        ];
    }
}
