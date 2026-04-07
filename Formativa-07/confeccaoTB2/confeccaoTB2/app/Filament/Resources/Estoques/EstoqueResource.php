<?php

namespace App\Filament\Resources\Estoques;

use App\Filament\Resources\Estoques\Pages\CreateEstoque;
use App\Filament\Resources\Estoques\Pages\EditEstoque;
use App\Filament\Resources\Estoques\Pages\ListEstoques;
use App\Filament\Resources\Estoques\Pages\ViewEstoque;
use App\Filament\Resources\Estoques\Schemas\EstoqueInfolist;
use App\Models\Estoque;
use App\Models\Produto;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;

class EstoqueResource extends Resource
{
    protected static ?string $model = Estoque::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Estoques';

    protected static ?string $modelLabel = 'Criar Estoque';

    protected static ?string $pluralModelLabel = 'Estoques';

    protected static string|UnitEnum|null $navigationGroup = 'Estoque';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'Estoque';

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->schema([
            Select::make('produto_id')
                ->relationship('produto', 'nome')
                ->label('Produto')
                ->searchable()
                ->preload()
                ->required(),
            Select::make('tipo')
                ->options([
                    'entrada' => 'Entrada',
                    'saída' => 'Saída',
                ])
                ->default('entrada')
                ->label('Tipo')
                ->required(),
            TextInput::make('quantidade')
                ->required()
                ->numeric()
                ->step(0.01)
                ->label('Quantidade'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EstoqueInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('produto.nome')->label('Produto')->searchable(),
            TextColumn::make('tipo')->label('Tipo')->badge(),
            TextColumn::make('quantidade')->label('Quantidade'),
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
            'index' => ListEstoques::route('/'),
            'create' => CreateEstoque::route('/create'),
            'view' => ViewEstoque::route('/{record}'),
            'edit' => EditEstoque::route('/{record}/edit'),
        ];
    }
}
