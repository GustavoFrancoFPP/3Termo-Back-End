<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->text,
            'descricao' => fake()->text(),
            'preco' => fake()->randomFloat(2, 1, 100), // Preço entre 1 e 100
            'quantidade' => fake()->numberBetween(1, 50), // Quantidade entre 1 e 50
        ];
    }
}
