<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Usuarios;

// Exemplo 1: GET
Route::get('users/{id}', function ($id) { 
     $response = Http::get("http://dummyjson.com/users/{$id}");

     if ($response->successful()) {
        $dados = $response->json();
        return response()->json([
            'status' => 'Conectado com sucesso!',
            'resultado' => [
                'identificador' => $dados['id'],
                'nome_do_usuario' => ucfirst($dados['firstName'] . ' ' . $dados['lastName']),
                'imagem' => $dados['image'],
                'email' => $dados['email'],
                'idade' => $dados['age'],
                'telefone' => $dados['phone']
            ]
        ], 200);
     }
     return response()->json(['erro' => 'Usuário não encontrado'], 404);
});

// Exemplo 2: POST
Route::post('users/novo', function (Request $request) {
    $dados = $request->validate([
        'firstName' => 'required|string|min:3',
        'email' => 'required|string',
        'age' => 'required|integer',
    ]);     

    $usuario = Usuarios::create($dados);

    return response()->json([
        'mensagem' => 'Usuário cadastrado com sucesso!',
        'id_gerado' => rand(1000,9999),
        'dados_recebidos' => $dados
    ], 201);
});

Route::get('/', function () {
    return view('welcome');
});
