<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clientes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\Estoque;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        \App\Models\Clientes::factory(10)->create();
        \App\Models\Produto::factory(10)->create();
        \App\Models\Pedido::factory(50)->create();
        \App\Models\Fornecedor::factory(10)->create();
        \App\Models\Estoque::factory(50)->create();
        // User fixo removido para evitar erro de email duplicado
    }
}
