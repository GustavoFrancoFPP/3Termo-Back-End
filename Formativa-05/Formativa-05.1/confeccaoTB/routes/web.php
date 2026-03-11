<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\EstoqueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// ROTAS PARA CLIENTES

Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit')->middleware('auth');
Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update')->middleware('auth');
Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy')->middleware('auth');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index')->middleware('auth');


// ROTAS PARA FORNECEDORES

Route::get('/fornecedores/create', [FornecedorController::class, 'create'])->name('fornecedores.create')->middleware('auth');
Route::get('/fornecedores/{fornecedor}/edit', [FornecedorController::class, 'edit'])->name('fornecedores.edit')->middleware('auth');
Route::put('/fornecedores/{fornecedor}', [FornecedorController::class, 'update'])->name('fornecedores.update')->middleware('auth');
Route::delete('/fornecedores/{fornecedor}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy')->middleware('auth');
Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store')->middleware('auth');
Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores.index')->middleware('auth');


// ROTAS PARA PRODUTOS

Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create')->middleware('auth');
Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit')->middleware('auth');
Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update')->middleware('auth');
Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy')->middleware('auth');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store')->middleware('auth');
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index')->middleware('auth');


// ROTAS PARA ESTOQUE

Route::get('/estoques/create', [EstoqueController::class, 'create'])->name('estoques.create')->middleware('auth');
Route::get('/estoques/{estoque}/edit', [EstoqueController::class, 'edit'])->name('estoques.edit')->middleware('auth');
Route::put('/estoques/{estoque}', [EstoqueController::class, 'update'])->name('estoques.update')->middleware('auth');
Route::delete('/estoques/{estoque}', [EstoqueController::class, 'destroy'])->name('estoques.destroy')->middleware('auth');
Route::post('/estoques', [EstoqueController::class, 'store'])->name('estoques.store')->middleware('auth');
Route::get('/estoques', [EstoqueController::class, 'index'])->name('estoques.index')->middleware('auth');


// ROTAS PARA PEDIDOS

Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create')->middleware('auth');
Route::get('/pedidos/{pedido}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit')->middleware('auth');
Route::put('/pedidos/{pedido}', [PedidoController::class, 'update'])->name('pedidos.update')->middleware('auth');
Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy')->middleware('auth');
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store')->middleware('auth');
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index')->middleware('auth');


// ROTAS DE DASHBOARD E PROFILE

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
