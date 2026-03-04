@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Estoque</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Localização</th>
                <th>Data Entrada</th>
                <th>Data Saída</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estoques as $estoque)
            <tr>
                <td>{{ $estoque->id }}</td>
                <td>{{ $estoque->produto->nome ?? 'N/A' }}</td>
                <td>{{ $estoque->quantidade }}</td>
                <td>{{ $estoque->localizacao }}</td>
                <td>{{ $estoque->data_entrada }}</td>
                <td>{{ $estoque->data_saida }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
