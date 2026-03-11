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

    // Salva a alteração no banco
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

    //abre a tela de edição
public function edit(Clientes $cliente)
{
    return view('clientes.edit', compact('cliente'));
}

//Salva a alteração no banco
public function update(Request $request, Clientes $cliente)
{
    $request->validate([
        'nome'     => 'required|string|max:255',
        'cpf'      => 'required|string|unique:clientes,cpf,'.$cliente->id,
        'email'    => 'required|email|unique:clientes,email,'.$cliente->id,
        'telefone' => 'required|string',
        'endereco' => 'nullable|string',
    ]);

    $cliente->update($request->all());
    return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
}

    // Exclui o cliente
    public function destroy(Clientes $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente removido!');
    }
}