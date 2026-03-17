@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                {{ __('Cadastrar Novo Cliente') }}
            </h2>
            <!-- Formulário apontando para a rota de salvar -->
            <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4">
                    @csrf <!-- Obrigatório para segurança no Laravel -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('Nome Completo') }}</label>
                            <input type="text" name="nome" value="{{ old('nome') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('CPF') }}</label>
                            <input type="text" name="cpf" value="{{ old('cpf') }}" id="cpf" placeholder="000.000.000-00" maxlength="14" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            <span class="text-xs text-gray-500 mt-1 block">{{ __('11 dígitos | Formato: 000.000.000-00') }}</span>
                            @error('cpf') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('Telefone') }}</label>
                            <input type="text" name="telefone" value="{{ old('telefone') }}" id="telefone" placeholder="(00) 00000-0000" maxlength="15" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            <span class="text-xs text-gray-500 mt-1 block">{{ __('11 dígitos | Formato: (00) 00000-0000') }}</span>
                            @error('telefone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('E-mail') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('Endereço') }}</label>
                        <textarea name="endereco" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="2">{{ old('endereco') }}</textarea>
                    </div>
                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('clientes.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg">
                            {{ __('Salvar Cliente') }}
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Máscara para CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length <= 3) {
                e.target.value = value;
            } else if (value.length <= 6) {
                e.target.value = value.slice(0, 3) + '.' + value.slice(3);
            } else {
                e.target.value = value.slice(0, 3) + '.' + value.slice(3, 6) + '.' + value.slice(6, 9) + '-' + value.slice(9);
            }
        });
    }

    // Máscara para Telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length <= 2) {
                e.target.value = value;
            } else if (value.length <= 7) {
                e.target.value = '(' + value.slice(0, 2) + ') ' + value.slice(2);
            } else {
                e.target.value = '(' + value.slice(0, 2) + ') ' + value.slice(2, 7) + '-' + value.slice(7);
            }
        });
    }
</script>
@endsection