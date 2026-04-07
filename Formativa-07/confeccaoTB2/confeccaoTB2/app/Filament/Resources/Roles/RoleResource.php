<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Pages\ViewRole;
use App\Filament\Resources\Roles\Schemas\RoleForm;
use App\Filament\Resources\Roles\Schemas\RoleInfolist;
use App\Filament\Resources\Roles\Tables\RolesTable;
// use App\Models\Role;
use Spatie\Permission\Models\Role;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('Admin') ?? false;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Painel Cargos';

    protected static ?string $modelLabel = 'Criar Cargo';

    protected static ?string $pluralModelLabel = 'Cargos';

    protected static string|UnitEnum|null $navigationGroup = 'Administração';
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'Role';

    public static function form(Schema $schema): Schema
    {
        // return RoleForm::configure($schema);
        return $schema
        ->schema([
            \Filament\Forms\Components\TextInput::make('name')
                ->label('Cargo')
                ->required()
                ->unique(ignoreRecord:true)
                ->maxLength(255),

            \Filament\Forms\Components\Select::make('permissions')
                ->label('Permissões de Acesso')
                ->multiple()
                ->relationship('permissions', 'name')
                ->preload()
                ->columnSpanFull(),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RoleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // return RolesTable::configure($table);
        return $table
        ->columns([
            \Filament\Tables\Columns\TextColumn::make('name')
            ->label('Cargo')
            ->searchable()
            ->sortable(),

            \Filament\Tables\Columns\TextColumn::make('guard_name')
            ->label('Permissões de Acesso')
            ->searchable(),

            \Filament\Tables\Columns\TextColumn::make('created_at')
            ->label('Criado em')
            ->dateTime('d/m/Y')
            ->sortable(),
        ]);

        // ->actions([
        //     \Filament\Tables\Actions\EditAction::make(),
        //     \Filament\Tables\Actions\DeleteAction::make(),
        // ]);
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
