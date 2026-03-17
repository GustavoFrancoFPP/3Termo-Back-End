<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => \App\Models\Clientes::factory(),
            'data' => $this->faker->date(),
            'status' => $this->faker->randomElement(['aberto', 'processando', 'finalizado']),
            'valor_total' => $this->faker->randomFloat(2, 50, 1000),
        ];
    }
}
