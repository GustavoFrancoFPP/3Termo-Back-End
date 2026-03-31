<?php

namespace App\Filament\Resources\Pedidos;

use App\Filament\Resources\Pedidos\Pages\CreatePedido;
use App\Filament\Resources\Pedidos\Pages\EditPedido;
use App\Filament\Resources\Pedidos\Pages\ListPedidos;
use App\Filament\Resources\Pedidos\Pages\ViewPedido;
use App\Filament\Resources\Pedidos\Schemas\PedidoForm;
use App\Filament\Resources\Pedidos\Schemas\PedidoInfolist;
use App\Filament\Resources\Pedidos\Tables\PedidosTable;
use App\Models\Pedido;
use App\Models\Produto;
use App\Support\CurrencyFormatter;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\RawJs;

class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'status';

    public static function form(Schema $schema): Schema
    {
        // return PedidoForm::configure($schema);
        return $schema
        ->schema([
            Select::make('cliente_id')
            ->relationship('cliente', 'nome')
            ->searchable()
            ->preload()
            ->required()
            ->label('Selecione o Cliente'),

            Select::make('status')
            ->options([
                'Pendente' => 'Pendente',
                'Em Andamento' => 'Em Andamento',
                'Concluído' => 'Concluído',
            ])
            ->default('Pendente')
            ->required(),
            

            TextInput::make('valor_total')
            ->readOnly()
            ->label('Valor Total')
            ->prefix('R$')
            ->placeholder('0,00')
            ->mask(RawJs::make(<<<'JS'
$money((($input ?? '').replace(/\D/g, '').replace(/^0+(?=\d)/, '').padStart(3, '0')).replace(/(\d+)(\d{2})$/, '$1,$2'), ',', '.', 2)
JS))
            ->dehydrateStateUsing(fn ($state) => CurrencyFormatter::fromInput($state))
            ->formatStateUsing(fn ($state) => CurrencyFormatter::formatForInput($state))
            ->default('0,00')
            ->inputMode('decimal'),

            Repeater::make('itens')
            ->relationship('itens')
            ->schema([
                Select::make('produto_id')
                ->relationship('produto', 'nome')
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function ($state, Get $get, Set $set): void {
                    if (! filled($state)) {
                        $set('preco_unitario', '0,00');
                        self::calcularTotal($get, $set);

                        return;
                    }

                    $produto = Produto::find($state);

                    $set('preco_unitario', CurrencyFormatter::formatForInput($produto?->preco_venda ?? 0));
                    self::calcularTotal($get, $set);
                })
                ->required()
                ->label('Produto')
                ->columnSpan(2),

                TextInput::make('quantidade')
                ->numeric()
                ->default(1)
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Get $get, Set $set) => self::calcularTotal($get, $set))
                ->columnSpan(1),
                
                TextInput::make('preco_unitario')
                ->label('Valor Unitário')
                ->prefix('R$')
                ->placeholder('0,00')
                ->helperText('O valor é puxado automaticamente ao selecionar o produto.')
                ->mask(RawJs::make(<<<'JS'
$money((($input ?? '').replace(/\D/g, '').replace(/^0+(?=\d)/, '').padStart(3, '0')).replace(/(\d+)(\d{2})$/, '$1,$2'), ',', '.', 2)
JS))
                ->dehydrateStateUsing(fn ($state) => CurrencyFormatter::fromInput($state))
                ->formatStateUsing(fn ($state) => CurrencyFormatter::formatForInput($state))
                ->default('0,00')
                ->readOnly()
                ->inputMode('decimal')
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Get $get, Set $set) => self::calcularTotal($get, $set))
                ->columnSpan(1),
            ])
            ->columnSpan(4)
            ->columnSpanFull()
            ->label('Produtos do Pedido')
            ->live(onBlur: true)
            ->afterStateUpdated(fn (Get $get, Set $set) => self::calcularTotal($get, $set)),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PedidoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
         return PedidosTable::configure($table);
        return $table
        ->columns([
            TextColumn::make('cliente.nome')
            ->label('Cliente')
            ->searchable()
            ->sortable(),

            TextColumn::make('status')
            ->badge()
            ->color(fn (string $state): string => match ($state) {
                'Pendente' => 'warning',
                'Em Produção' => 'info',
                'Finalizado' => 'success',
                default => 'blue',
            }),

            TextColumn::make('valor_total')
            ->label('Valor Total')
            ->money('BRL')
            ->sortable(),

            TextColumn::make('created_at')
            ->label('Data do Pedido')
            ->dateTime('d/m/Y H:i')
            ->sortable(),
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
            'index' => ListPedidos::route('/'),
            'create' => CreatePedido::route('/create'),
            'view' => ViewPedido::route('/{record}'),
            'edit' => EditPedido::route('/{record}/edit'),
        ];
    }
    public static function normalizePedidoData(array $data): array
    {
        $itens = $data['itens'] ?? [];
        $total = 0;

        foreach ($itens as $key => $item) {
            $produto = filled($item['produto_id'] ?? null)
                ? Produto::find($item['produto_id'])
                : null;

            $quantidade = max(1, (int) ($item['quantidade'] ?? 1));
            $preco = CurrencyFormatter::toFloat($item['preco_unitario'] ?? null);

            if ($preco <= 0 && $produto) {
                $preco = CurrencyFormatter::toFloat($produto->preco_venda);
            }

            $itens[$key]['quantidade'] = $quantidade;
            $itens[$key]['preco_unitario'] = number_format($preco, 2, '.', '');

            $total += $quantidade * $preco;
        }

        $data['itens'] = $itens;
        $data['valor_total'] = number_format($total, 2, '.', '');

        return $data;
    }

    public static function calcularTotal(Get $get, Set $set): void
    {
        $itens = $get('itens') ?? [];
        $total = 0;

        foreach ($itens as $item) {
            $quantidade = (float) ($item['quantidade'] ?? 0);
            $preco = CurrencyFormatter::toFloat($item['preco_unitario'] ?? 0);

            if ($preco <= 0 && filled($item['produto_id'] ?? null)) {
                $preco = CurrencyFormatter::toFloat(Produto::find($item['produto_id'])?->preco_venda ?? 0);
            }

            $total += $quantidade * $preco;
        }

        $set('valor_total', CurrencyFormatter::formatForInput($total));
    }
}
