<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Editar Pedido</h2></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select name="cliente_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $pedido->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data</label>
                            <input type="date" name="data" value="{{ $pedido->data }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="aberto" {{ $pedido->status == 'aberto' ? 'selected' : '' }}>Aberto</option>
                                <option value="processando" {{ $pedido->status == 'processando' ? 'selected' : '' }}>Processando</option>
                                <option value="finalizado" {{ $pedido->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Valor Total</label>
                            <input type="number" step="0.01" name="valor_total" value="{{ $pedido->valor_total }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md uppercase text-xs font-bold">Atualizar Pedido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
