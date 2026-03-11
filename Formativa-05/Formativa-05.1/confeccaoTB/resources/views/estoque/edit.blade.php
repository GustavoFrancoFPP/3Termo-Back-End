<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Editar Estoque</h2></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('estoques.update', $estoque->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Produto</label>
                        <select name="produto_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach($produtos as $produto)
                                <option value="{{ $produto->id }}" {{ $estoque->produto_id == $produto->id ? 'selected' : '' }}>{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantidade</label>
                            <input type="number" name="quantidade" value="{{ $estoque->quantidade }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Localização</label>
                            <input type="text" name="localizacao" value="{{ $estoque->localizacao }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data Entrada</label>
                            <input type="date" name="data_entrada" value="{{ $estoque->data_entrada }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data Saída</label>
                            <input type="date" name="data_saida" value="{{ $estoque->data_saida }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md uppercase text-xs font-bold">Atualizar Estoque</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
