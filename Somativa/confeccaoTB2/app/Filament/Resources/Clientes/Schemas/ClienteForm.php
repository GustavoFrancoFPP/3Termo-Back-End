<?php

namespace App\Filament\Resources\Clientes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class ClienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informações Pessoais')
                    ->description('Dados do cliente')
                    ->icon('heroicon-m-user')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->label('Nome Completo')
                            ->placeholder('Ex: João Silva')
                            ->columnSpanFull(),
                        
                        TextInput::make('email')
                            ->email()
                            ->label('E-mail')
                            ->placeholder('exemplo@email.com'),
                        
                        TextInput::make('telefone')
                            ->tel()
                            ->label('Telefone')
                            ->placeholder('(11) 99999-9999')
                            ->mask('(99) 99999-9999'),
                        
                        TextInput::make('documento')
                            ->label('CPF ou CNPJ')
                            ->placeholder('000.000.000-00')
                            ->mask(RawJs::make(<<<'JS'
$input.length > 14 ? '99.999.999/9999-99' : '999.999.999-99'
JS)),
                    ]),
            ]);
    }
}
