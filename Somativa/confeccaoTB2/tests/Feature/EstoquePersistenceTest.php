<?php

namespace Tests\Feature;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstoquePersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_estoque_can_be_created_for_a_produto(): void
    {
        $produto = Produto::create([
            'nome' => 'Camiseta Básica',
            'referencia' => 'CAM-001',
            'preco_venda' => 49.90,
            'estoque' => 10,
        ]);

        $estoque = Estoque::create([
            'produto_id' => $produto->id,
            'quantidade' => 5,
            'tipo_movimento' => 'entrada',
            'tipo' => 'entrada',
            'observacao' => 'Reposição inicial',
        ]);

        $this->assertNotNull($estoque->id);

        $this->assertDatabaseHas('estoques', [
            'produto_id' => $produto->id,
            'quantidade' => 5,
            'tipo_movimento' => 'entrada',
            'tipo' => 'entrada',
            'observacao' => 'Reposição inicial',
        ]);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'estoque' => 15,
        ]);
    }

    public function test_saida_subtracts_from_produto_stock(): void
    {
        $produto = Produto::create([
            'nome' => 'Calça Social',
            'referencia' => 'CAL-001',
            'preco_venda' => 99.90,
            'estoque' => 10,
        ]);

        Estoque::create([
            'produto_id' => $produto->id,
            'quantidade' => 4,
            'tipo_movimento' => 'saida',
            'tipo' => 'saida',
        ]);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'estoque' => 6,
        ]);
    }
}
