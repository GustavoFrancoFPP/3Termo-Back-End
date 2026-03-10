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


// Rotas para estrutura de clientes para cadastro , edição e exclusão
// Rota para mostrar o formulário
Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');

// Rota para editar cliente
Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit')->middleware('auth');
// Rota para atualizar cliente
Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update')->middleware('auth');
// Rota para excluir cliente
Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy')->middleware('auth');

// Rota para receber os dados e salvar(POST)
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index')->middleware('auth');


// Rotas para produtos
Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create')->middleware('auth');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store')->middleware('auth');
// Rotas para estoque
// Rotas para estoque
Route::get('/estoques', [EstoqueController::class, 'index'])->name('estoques.index')->middleware('auth');
Route::get('/estoques/create', [EstoqueController::class, 'create'])->name('estoques.create')->middleware('auth');
Route::post('/estoques', [EstoqueController::class, 'store'])->name('estoques.store')->middleware('auth');
Route::get('/estoques/create', [EstoqueController::class, 'create'])->name('estoques.create')->middleware('auth');
Route::post('/estoques', [EstoqueController::class, 'store'])->name('estoques.store')->middleware('auth');
Route::get('/estoques', [EstoqueController::class, 'index'])->name('estoques.index')->middleware('auth');
Route::get('/estoques/{estoque}/edit', [EstoqueController::class, 'edit'])->name('estoques.edit')->middleware('auth');
Route::put('/estoques/{estoque}', [EstoqueController::class, 'update'])->name('estoques.update')->middleware('auth');
Route::delete('/estoques/{estoque}', [EstoqueController::class, 'destroy'])->name('estoques.destroy')->middleware('auth');
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index')->middleware('auth');

// Rotas para pedidos
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index')->middleware('auth');
Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create')->middleware('auth');
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas para fornecedores
Route::get('/fornecedores/create', [FornecedorController::class, 'create'])->name('fornecedores.create')->middleware('auth');
Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store')->middleware('auth');
Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores.index')->middleware('auth');
Route::resource('fornecedores', FornecedorController::class);
// Rotas para estoques
Route::get('/estoques/create', [EstoqueController::class, 'create'])->name('estoques.create')->middleware('auth');
Route::post('/estoques', [EstoqueController::class, 'store'])->name('estoques.store')->middleware('auth');
Route::get('/estoques', [EstoqueController::class, 'index'])->name('estoques.index')->middleware('auth');
Route::resource('estoques', EstoqueController::class);


require __DIR__.'/auth.php';
