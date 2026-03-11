<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Cadastrar Novo Produto</h2></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('produtos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Nome</label>
                            <input type="text" name="nome" value="{{ old('nome') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Descrição</label>
                            <textarea name="descricao" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="2">{{ old('descricao') }}</textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Preço</label>
                            <input type="number" step="0.01" name="preco" value="{{ old('preco') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            @error('preco') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Quantidade</label>
                            <input type="number" name="quantidade" value="{{ old('quantidade') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            @error('quantidade') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('produtos.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg">
                            Salvar Produto
                        </button>
                    </div>
            </form>
        </div>
    </div>
</x-app-layout>