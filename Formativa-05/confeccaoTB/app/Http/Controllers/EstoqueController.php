<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Estoque;
use App\Models\Produto;


class EstoqueController extends Controller
{
    public function index() {
        $estoques = \App\Models\Estoque::with('produto')->get(); // Busca todos os estoques com os produtos relacionados
        return view('estoques.index', compact('estoques'));
    }

    public function create()
    {
        $produtos = \App\Models\Produto::all();
        return view('estoques.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:0',
            'localizacao' => 'required|string|max:255',
            'data_entrada' => 'required|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
        ]);

        \App\Models\Estoque::create($request->all());
        return redirect()->route('estoques.index')->with('success', 'Estoque cadastrado com sucesso!');
    }

}