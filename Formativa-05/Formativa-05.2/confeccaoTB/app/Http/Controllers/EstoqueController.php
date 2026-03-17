<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Estoque;
use App\Models\Produto;


class EstoqueController extends Controller
{
    public function index() {
        // traz os estoques ordenados pelo nome do produto (se houver relação), depois pelo ID
        $estoques = \App\Models\Estoque::with('produto')
            ->get()
            ->sortBy(function($item) {
                return $item->produto->nome ?? '';
            });
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

        Estoque::create($request->all());
        return redirect()->route('estoques.index')->with('success', 'Estoque cadastrado com sucesso!');
    }

    public function edit(Estoque $estoque)
    {
        $produtos = \App\Models\Produto::all();
        return view('estoques.edit', compact('estoque', 'produtos'));
    }

    public function update(Request $request, Estoque $estoque)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:0',
            'localizacao' => 'required|string|max:255',
            'data_entrada' => 'required|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
        ]);

        $estoque->update($request->all());

        return redirect()->route('estoques.index')->with('success', 'Estoque atualizado com sucesso!');
    }
public function destroy(Estoque $estoque)
    {
        $estoque->delete();
        return redirect()->route('estoques.index')->with('success', 'Estoque excluído com sucesso!');
    }
}