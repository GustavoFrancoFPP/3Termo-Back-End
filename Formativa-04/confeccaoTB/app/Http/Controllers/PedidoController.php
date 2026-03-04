<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index() {
        $pedidos = \App\Models\Pedido::with('cliente')->get();
        return view('pedidos.index', compact('pedidos'));
    }
}
