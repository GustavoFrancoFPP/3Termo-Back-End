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


Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index')->middleware('auth');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index')->middleware('auth');
Route::get('/pedidos', [\App\Http\Controllers\PedidoController::class, 'index'])->name('pedidos.index')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('fornecedores', FornecedorController::class);
Route::resource('estoques', EstoqueController::class);


require __DIR__.'/auth.php';
