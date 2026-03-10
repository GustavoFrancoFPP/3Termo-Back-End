@extends('layouts.app')

@section('content')
<div class="py-12">
	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
			<h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
				{{ __('Cadastrar Novo Estoque') }}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
			</h2>
			<form action="{{ route('estoques.store') }}" method="POST" class="space-y-4">
				@csrf

				<div>
					<label class="block font-medium text-sm text-gray-700">Produto</label>
					<select name="produto_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
						<option value="">Selecione o produto</option>
						@foreach($produtos as $produto)
							<option value="{{ $produto->id }}">{{ $produto->nome }}</option>
						@endforeach
					</select>
					@error('produto_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
				</div>

				<div>
					<label class="block font-medium text-sm text-gray-700">Quantidade</label>
					<input type="number" name="quantidade" value="{{ old('quantidade') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
					@error('quantidade') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
				</div>

				<div>
					<label class="block font-medium text-sm text-gray-700">Localização</label>
					<input type="text" name="localizacao" value="{{ old('localizacao') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
				</div>

				<div>
					<label class="block font-medium text-sm text-gray-700">Data Entrada</label>
					<input type="date" name="data_entrada" value="{{ old('data_entrada') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
				</div>

				<div>
					<label class="block font-medium text-sm text-gray-700">Data Saída</label>
					<input type="date" name="data_saida" value="{{ old('data_saida') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
				</div>

				<div class="flex items-center justify-end mt-4">
					<a href="{{ route('estoques.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
					<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
						Salvar Estoque
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
