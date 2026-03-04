<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nossa Confecção - Pedidos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($pedidos as $pedido)
                    <div class="border p-4 rounded shadow-sm">
                        <h3 class="font-bold text-lg">Pedido #{{ $pedido->id }}</h3>
                        <p class="text-sm text-gray-600">Cliente: {{ $pedido->cliente->nome ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Data: {{ $pedido->data }}</p>
                        <p class="text-sm text-gray-600">Status: {{ $pedido->status }}</p>
                        <p class="text-sm text-gray-600">Valor Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
