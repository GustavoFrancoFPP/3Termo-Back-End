<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Cadastrar Novo Pedido</h2></x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
				<form action="{{ route('pedidos.store') }}" method="POST" class="space-y-4">
				@csrf

				<div>
					<label class="block font-medium text-sm text-gray-700">Cliente</label>
					<select name="cliente_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
						<option value="">Selecione o cliente</option>
						@foreach($clientes as $cliente)
							<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
						@endforeach
					</select>
					@error('cliente_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
				</div>

				<div>
					<label class="block font-medium text-sm text-gray-700">Data</label>
					<input type="date" name="data" value="{{ old('data') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
					@error('data') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
				</div>

				<div>
					<label class="block font-medium text-sm text-gray-700">Status</label>
					<input type="text" name="status" value="{{ old('status') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
					@error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
				</div>

				<div>
					<label class="block font-medium text-sm text-gray-700">Valor Total</label>
					<input type="number" step="0.01" name="valor_total" value="{{ old('valor_total') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
					@error('valor_total') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
				</div>

				<div class="flex items-center justify-end mt-4">
					<a href="{{ route('pedidos.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
					<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
						Salvar Pedido
					</button>
				</div>
			</form>
		</div>
	</div>
</x-app-layout>
