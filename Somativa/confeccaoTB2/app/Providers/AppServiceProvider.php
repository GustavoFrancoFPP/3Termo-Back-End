<?php

namespace App\Providers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        App::setLocale(config('app.locale'));

        CreateAction::configureUsing(fn (CreateAction $action) => $action->label('Novo'));
        ViewAction::configureUsing(fn (ViewAction $action) => $action->label('Visualizar'));
        EditAction::configureUsing(fn (EditAction $action) => $action->label('Editar'));
        DeleteAction::configureUsing(fn (DeleteAction $action) => $action->label('Excluir'));
        DeleteBulkAction::configureUsing(fn (DeleteBulkAction $action) => $action->label('Excluir selecionados'));
    }
}
