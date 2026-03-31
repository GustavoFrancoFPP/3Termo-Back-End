<?php

namespace Tests\Feature;

use App\Filament\Resources\Pedidos\Pages\CreatePedido;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PedidoWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_selecting_a_product_prefills_its_price_in_the_order_form(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::create(['nome' => 'Cliente Teste']);
        $produto = Produto::create([
            'nome' => 'Vestido Floral',
            'referencia' => 'VES-001',
            'preco_venda' => 129.90,
            'estoque' => 12,
        ]);

        Livewire::actingAs($user)
            ->test(CreatePedido::class)
            ->set('data.cliente_id', $cliente->id)
            ->set('data.itens', [[
                'produto_id' => null,
                'quantidade' => 1,
                'preco_unitario' => '0,00',
            ]])
            ->set('data.itens.0.produto_id', $produto->id)
            ->assertSet('data.itens.0.preco_unitario', '129,90');
    }

    public function test_finalizing_an_order_updates_the_product_stock(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::create(['nome' => 'Cliente Teste']);
        $produto = Produto::create([
            'nome' => 'Blazer Slim',
            'referencia' => 'BLZ-001',
            'preco_venda' => 199.90,
            'estoque' => 10,
        ]);

        Livewire::actingAs($user)
            ->test(CreatePedido::class)
            ->set('data.cliente_id', $cliente->id)
            ->set('data.status', 'Concluído')
            ->set('data.itens', [[
                'produto_id' => $produto->id,
                'quantidade' => 3,
                'preco_unitario' => '199,90',
            ]])
            ->call('create');

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'estoque' => 7,
        ]);
    }
}
