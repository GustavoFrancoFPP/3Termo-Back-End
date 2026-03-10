@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de Pedidos') }}
                </h2>
                <a href="{{ route('pedidos.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    + Novo Pedido
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($pedidos as $pedido)
                <div class="border p-4 rounded shadow-sm">
                    <h3 class="font-bold text-lg">Pedido #{{ $pedido->id }}</h3>
                    <p class="text-sm text-gray-600">Cliente: {{ $pedido->cliente->nome ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">Data: {{ $pedido->data }}</p>
                    <p class="text-sm text-gray-600">Status: {{ $pedido->status }}</p>
                    <p class="text-sm text-gray-600">Valor Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</p>
                </div>
                @empty
                <div class="col-span-3 text-center text-gray-500">Nenhum pedido cadastrado.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nossa Confecção - Pedidos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($pedidos as $pedido)
                    <div class="border p-4 rounded shadow-sm">
                        <h3 class="font-bold text-lg">Pedido #{{ $pedido->id }}</h3>
                        <p class="text-sm text-gray-600">Cliente: {{ $pedido->cliente->nome ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Data: {{ $pedido->data }}</p>
                        <p class="text-sm text-gray-600">Status: {{ $pedido->status }}</p>
                        <p class="text-sm text-gray-600">Valor Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
