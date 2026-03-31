<?php

namespace Tests\Feature;

use App\Filament\Resources\Pedidos\Pages\CreatePedido;
use App\Models\Cliente;
use App\Models\Estoque;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePedidoTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_fills_the_unit_price_and_updates_stock_when_creating_a_finalized_order(): void
    {
        $this->actingAs(User::factory()->create());

        $cliente = Cliente::create([
            'nome' => 'Cliente Teste',
            'email' => 'cliente@example.com',
        ]);

        $produto = Produto::create([
            'nome' => 'Camiseta Básica',
            'preco_venda' => 59.90,
            'estoque' => 10,
        ]);

        Livewire::test(CreatePedido::class)
            ->fillForm([
                'cliente_id' => $cliente->id,
                'status' => Pedido::STATUS_CONCLUIDO,
                'itens' => [
                    [
                        'produto_id' => $produto->id,
                        'quantidade' => 2,
                        'preco_unitario' => null,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $pedido = Pedido::query()->with('itens')->first();

        $this->assertNotNull($pedido);
        $this->assertCount(1, $pedido->itens);
        $this->assertSame('59.90', number_format((float) $pedido->itens->first()->preco_unitario, 2, '.', ''));
        $this->assertSame('119.80', number_format((float) $pedido->valor_total, 2, '.', ''));
        $this->assertSame(8, $produto->fresh()->estoque);

        $movimento = Estoque::query()->latest('id')->first();

        $this->assertNotNull($movimento);
        $this->assertSame($produto->id, $movimento->produto_id);
        $this->assertSame(2, $movimento->quantidade);
        $this->assertSame('saida', $movimento->tipo_movimento);
    }
}
