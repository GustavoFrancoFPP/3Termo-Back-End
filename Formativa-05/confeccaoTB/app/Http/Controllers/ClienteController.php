<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Clientes;

class ClienteController extends Controller
{
    // Lista todos os clientes
    public function index() 
    {
        $clientes = Clientes::all(); 
        return view('clientes.index', compact('clientes'));
    }

    // Exibe o formulário de cadastro
    public function create() 
    {
        return view('clientes.create');
    }

    // Recebe os dados do formulário e salva no banco de dados
    public function store(Request $request) 
    {
        $request->validate([
            'nome'     => 'required|string|max:255',
            'cpf'      => 'required|string|unique:clientes',
            'email'    => 'required|email|unique:clientes',
            'telefone' => 'required|string',
            'endereco' => 'nullable|string',
        ]);

        Clientes::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
    }
}