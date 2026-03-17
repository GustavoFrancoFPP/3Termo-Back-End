<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Clientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('dashboard.total_clientes') }}</dt>
                                <dd class="text-2xl font-semibold text-gray-900">{{ $totalClientes }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Produtos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('dashboard.total_produtos') }}</dt>
                                <dd class="text-2xl font-semibold text-gray-900">{{ $totalProdutos }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pedidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('dashboard.total_pedidos') }}</dt>
                                <dd class="text-2xl font-semibold text-gray-900">{{ $totalPedidos }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Fornecedores -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('dashboard.total_fornecedores') }}</dt>
                                <dd class="text-2xl font-semibold text-gray-900">{{ $totalFornecedores }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Total Valor Pedidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('dashboard.valor_total_pedidos') }}</dt>
                                <dd class="text-2xl font-semibold text-gray-900">R$ {{ number_format($totalValorPedidos, 2, ',', '.') }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Valor Estoque -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('dashboard.valor_total_estoque') }}</dt>
                                <dd class="text-2xl font-semibold text-gray-900">R$ {{ number_format($totalValorEstoque, 2, ',', '.') }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders and Low Stock -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pedidos Recentes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('dashboard.pedidos_recentes') }}</h3>
                        @if($pedidosRecentes->count() > 0)
                            <div class="space-y-3">
                                @foreach($pedidosRecentes as $pedido)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ __('dashboard.pedido_numero', ['numero' => $pedido->id]) }}</p>
                                            <p class="text-sm text-gray-500">{{ $pedido->cliente->nome ?? __('dashboard.cliente_nao_encontrado') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($pedido->status == 'pendente') bg-yellow-100 text-yellow-800
                                                @elseif($pedido->status == 'aprovado') bg-green-100 text-green-800
                                                @elseif($pedido->status == 'cancelado') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($pedido->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">{{ __('dashboard.nenhum_pedido_recente') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Estoques Baixos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('dashboard.alertas_estoque_baixo') }}</h3>
                        @if($estoquesBaixos->count() > 0)
                            <div class="space-y-3">
                                @foreach($estoquesBaixos as $estoque)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $estoque->produto->nome ?? __('dashboard.produto_nao_encontrado') }}</p>
                                            <p class="text-sm text-gray-500">{{ __('dashboard.localizacao') }}: {{ $estoque->localizacao ?? __('dashboard.nao_informado') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-red-600">{{ $estoque->quantidade }} {{ __('dashboard.unidades') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('dashboard.estoque_baixo') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">{{ __('dashboard.nenhum_alerta_estoque') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pedidos por Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('dashboard.pedidos_por_status') }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($pedidosPorStatus as $status => $count)
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full
                                    @if($status == 'pendente') bg-yellow-100
                                    @elseif($status == 'aprovado') bg-green-100
                                    @elseif($status == 'cancelado') bg-red-100
                                    @else bg-gray-100 @endif">
                                    <span class="text-lg font-semibold
                                        @if($status == 'pendente') text-yellow-800
                                        @elseif($status == 'aprovado') text-green-800
                                        @elseif($status == 'cancelado') text-red-800
                                        @else text-gray-800 @endif">
                                        {{ $count }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm font-medium text-gray-900">{{ ucfirst($status) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
