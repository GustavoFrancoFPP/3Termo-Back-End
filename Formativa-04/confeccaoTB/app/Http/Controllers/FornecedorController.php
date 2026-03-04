<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index() {
        $fornecedores = \App\Models\Fornecedor::all();
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function show(\App\Models\Fornecedor $fornecedor) {
        return view('fornecedores.show', compact('fornecedor'));
    }

    public function create() {
        return view('fornecedores.create');
    }

    public function store(Request $request) {
        \App\Models\Fornecedor::create($request->all());
        return redirect()->route('fornecedores.index');
    }

    public function edit(\App\Models\Fornecedor $fornecedor) {
        return view('fornecedores.edit', compact('fornecedor'));
    }

    public function update(Request $request, \App\Models\Fornecedor $fornecedor) {
        $fornecedor->update($request->all());
        return redirect()->route('fornecedores.index');
    }

    public function destroy(\App\Models\Fornecedor $fornecedor) {
        $fornecedor->delete();
        return redirect()->route('fornecedores.index');
    }
}
