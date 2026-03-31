<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoDescriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_produto_can_be_persisted_with_descricao(): void
    {
        $produto = Produto::create([
            'nome' => 'Jaqueta Jeans',
            'referencia' => 'JQ-001',
            'preco_venda' => 149.90,
            'descricao' => 'Jaqueta jeans azul com modelagem reta.',
            'estoque' => 8,
        ]);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'descricao' => 'Jaqueta jeans azul com modelagem reta.',
        ]);
    }
}
