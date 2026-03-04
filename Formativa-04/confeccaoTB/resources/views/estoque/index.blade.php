<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Controle de Estoque') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localização</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Entrada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Saída</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($estoques as $estoque)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $estoque->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $estoque->produto->nome ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $estoque->quantidade }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $estoque->localizacao }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $estoque->data_entrada }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $estoque->data_saida }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>