<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index() {
        $produtos = \App\Models\Produto::all(); // Busca todos os produtos
        return view('produtos.index', compact('produtos'));
    }

    public function create() {
        return view('produtos.create');
    }

    public function store(Request $request) {
        \App\Models\Produto::create($request->all());
        return redirect()->route('produtos.index');

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
        ]);

        \App\Models\Produto::create($request->all());
        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

}
