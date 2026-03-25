<?php

namespace App\Filament\Resources\Insumos\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InsumoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informações do Insumo')
                    ->icon('heroicon-m-cube')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nome')
                            ->label('Nome')
                            ->columnSpanFull(),
                        
                        TextEntry::make('unidade_medida')
                            ->label('Unidade'),
                        
                        TextEntry::make('preco_custo')
                            ->label('Preço de Custo')
                            ->money('BRL'),
                    ]),
                
                Section::make('Estoque')
                    ->icon('heroicon-m-inbox-stack')
                    ->schema([
                        TextEntry::make('estoque')
                            ->label('Quantidade em Estoque')
                            ->numeric(),
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
