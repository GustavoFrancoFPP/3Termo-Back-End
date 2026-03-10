<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nossa Confecção - Fornecedores
            </h2>
            <a href="{{ route('fornecedores.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                + Novo Fornecedor
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse ($fornecedores as $fornecedor)
                            <div class="border p-4 rounded shadow-sm">
                                <h3 class="font-bold text-lg">{{ $fornecedor->nome }}</h3>
                                <p class="text-sm text-gray-600">CNPJ: {{ $fornecedor->cnpj }}</p>
                                <p class="text-sm text-gray-600">Email: {{ $fornecedor->email }}</p>
                                <p class="text-sm text-gray-600">Telefone: {{ $fornecedor->telefone }}</p>
                                <p class="text-sm text-gray-600">Endereço: {{ $fornecedor->endereco }}</p>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12 text-gray-500 text-lg">
                                Nenhum fornecedor cadastrado.
                            </div>
                        @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>