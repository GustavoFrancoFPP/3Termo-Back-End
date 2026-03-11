<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Clientes;    

class PedidoController extends Controller
{
    public function index() {
        $pedidos = \App\Models\Pedido::with('cliente')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create() 
    {
        $clientes = \App\Models\Clientes::all();
        return view('pedidos.create', compact('clientes'));
    }

    // Recebe os dados do formulário e salva no banco de dados
    public function store(Request $request) 
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data' => 'required|date',
            'status' => 'required|string|max:255',
            'valor_total' => 'required|numeric|min:0',
        ]);

        \App\Models\Pedido::create($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Pedido cadastrado com sucesso!');
    }
    public function edit(Pedido $pedido)
    {
        $clientes = \App\Models\Clientes::all();
        return view('pedidos.edit', compact('pedido', 'clientes'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data' => 'required|date',
            'status' => 'required|string|max:255',
            'valor_total' => 'required|numeric|min:0',
        ]);

        $pedido->update($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso!');
    }
}