<?php

namespace App\Filament\Resources\Fornecedors\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FornecedorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->label('Nome do Fornecedor')
                            ->placeholder('Ex: Fornecedor ABC')
                            ->columnSpanFull(),
                        
                        TextInput::make('email')
                            ->email()
                            ->label('E-mail')
                            ->placeholder('contato@fornecedor.com'),
                        
                        TextInput::make('telefone')
                            ->tel()
                            ->label('Telefone')
                            ->placeholder('(11) 99999-9999')
                            ->mask('(99) 99999-9999'),
                        
                        TextInput::make('cnpj')
                            ->label('CNPJ')
                            ->placeholder('00.000.000/0000-00')
                            ->mask('99.999.999/9999-99'),
                    ]);
    }
}
