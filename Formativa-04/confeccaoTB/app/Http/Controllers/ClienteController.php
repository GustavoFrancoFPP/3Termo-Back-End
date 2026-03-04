<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index() {
        $clientes = \App\Models\Clientes::all(); // Busca todos os clientes
        return view('clientes.index', compact('clientes'));
    }
}
