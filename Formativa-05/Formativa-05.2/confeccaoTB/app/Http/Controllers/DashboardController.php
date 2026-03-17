<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\Fornecedor;
use App\Models\Estoque;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas principais
        $totalClientes = Clientes::count();
        $totalProdutos = Produto::count();
        $totalPedidos = Pedido::count();
        $totalFornecedores = Fornecedor::count();
        $totalEstoques = Estoque::count();

        // Valores totais
        $totalValorPedidos = Pedido::sum('valor_total');
        $totalValorEstoque = Produto::sum(DB::raw('preco * quantidade'));

        // Pedidos recentes
        $pedidosRecentes = Pedido::with('cliente')->latest()->take(5)->get();

        // Estoques baixos (quantidade <= 10)
        $estoquesBaixos = Estoque::with('produto')->where('quantidade', '<=', 10)->take(5)->get();

        // Pedidos por status
        $pedidosPorStatus = Pedido::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('dashboard', compact(
            'totalClientes',
            'totalProdutos',
            'totalPedidos',
            'totalFornecedores',
            'totalEstoques',
            'totalValorPedidos',
            'totalValorEstoque',
            'pedidosRecentes',
            'estoquesBaixos',
            'pedidosPorStatus'
        ));
    }
}