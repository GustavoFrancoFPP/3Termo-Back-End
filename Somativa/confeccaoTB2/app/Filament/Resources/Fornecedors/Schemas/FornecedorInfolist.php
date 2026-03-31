<?php

namespace App\Filament\Resources\Fornecedors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FornecedorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informações do Fornecedor')
                    ->icon('heroicon-m-building-storefront')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nome')
                            ->label('Nome')
                            ->columnSpanFull(),
                        
                        TextEntry::make('email')
                            ->label('E-mail')
                            ->copyable(),
                        
                        TextEntry::make('telefone')
                            ->label('Telefone')
                            ->copyable(),
                        
                        TextEntry::make('cnpj')
                            ->label('CNPJ'),
                    ]),
                
                Section::make('Auditoria')
                    ->icon('heroicon-m-information-circle')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),
                        
                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
