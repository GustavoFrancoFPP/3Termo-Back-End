<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nossa Confecção - Produtos
            </h2>
            <a href="{{ route('produtos.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Novo Produto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Mensagem de Sucesso -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($produtos as $produto)
                <div class="flex flex-col justify-between border border-gray-200 p-4 rounded-lg hover:shadow-lg transition bg-gray-50">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $produto->nome }}</h3>
                        <p class="text-sm text-gray-600 mb-1">Descrição: {{ $produto->descricao }}</p>
                        <p class="text-sm text-gray-600 mb-1">Preço: <span class="font-medium text-indigo-600">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span></p>
                        <p class="text-sm text-gray-600">Quantidade: {{ $produto->quantidade }}</p>
                    </div>

                    <!-- Botões de Ação no Rodapé do Card -->
                    <div class="flex items-center justify-end mt-6 pt-4 border-t border-gray-200 space-x-4">
                        <a href="{{ route('produtos.edit', $produto->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold flex items-center">
                            Editar
                        </a>

                        <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center text-gray-500">Nenhum produto cadastrado.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
