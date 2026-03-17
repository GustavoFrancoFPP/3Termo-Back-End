<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estoque>
 */
class EstoqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locais = ['Prateleira A1', 'Prateleira A2', 'Prateleira B1', 'Prateleira B2', 'Prateleira C1', 'Armário 01', 'Armário 02', 'Armário 03', 'Freezer 01', 'Gaveta 01'];
        
        return [
            'produto_id' => \App\Models\Produto::inRandomOrder()->first()?->id ?? \App\Models\Produto::factory(),
            'quantidade' => fake()->numberBetween(5, 150),
            'localizacao' => fake()->randomElement($locais),
            'data_entrada' => fake()->dateTimeBetween('-6 months')->format('Y-m-d'),
            'data_saida' => fake()->boolean(30) ? fake()->dateTimeBetween('-3 months')->format('Y-m-d') : null,
        ];
    }
}
