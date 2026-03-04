<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nossa Confecção - Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($clientes as $cliente)
                    <div class="border p-4 rounded shadow-sm">
                        <h3 class="font-bold text-lg">{{ $cliente->nome }}</h3>
                        <p class="text-sm text-gray-600">CPF: {{ $cliente->cpf }}</p>
                        <p class="text-sm text-gray-600">Email: {{ $cliente->email }}</p>
                        <p class="text-sm text-gray-600">Telefone: {{ $cliente->telefone }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
