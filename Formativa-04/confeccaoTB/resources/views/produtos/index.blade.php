@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                Nossa Confecção - Produtos
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($produtos as $produto)
                <div class="border p-4 rounded shadow-sm">
                    <h3 class="font-bold text-lg">{{ $produto->nome }}</h3>
                    <p class="text-sm text-gray-600">Descrição: {{ $produto->descricao }}</p>
                    <p class="text-sm text-gray-600">Preço: R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                    <p class="text-sm text-gray-600">Quantidade: {{ $produto->quantidade }}</p>
                </div>
                @empty
                <div class="col-span-3 text-center text-gray-500">Nenhum produto cadastrado.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
