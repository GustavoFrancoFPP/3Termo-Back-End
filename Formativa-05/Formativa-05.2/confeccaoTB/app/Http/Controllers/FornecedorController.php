<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    public function index() {
        $fornecedores = \App\Models\Fornecedor::all();
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function create() {
        return view('fornecedores.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:fornecedores',
            'email' => 'required|email|unique:fornecedores',
            'telefone' => 'required|string',
            'endereco' => 'nullable|string',
        ]);

        \App\Models\Fornecedor::create($request->all());
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    public function edit(Fornecedor $fornecedor) {
        return view('fornecedores.edit', compact('fornecedor'));
    }
    public function update(Request $request, Fornecedor $fornecedor) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:fornecedores,cnpj,'.$fornecedor->id,
            'email' => 'required|email|unique:fornecedores,email,'.$fornecedor->id,
            'telefone' => 'required|string',
            'endereco' => 'nullable|string',
        ]);

        $fornecedor->update($request->all());
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }
    public function destroy(Fornecedor $fornecedor) {
        $fornecedor->delete();
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluído com sucesso!');
    }
}
