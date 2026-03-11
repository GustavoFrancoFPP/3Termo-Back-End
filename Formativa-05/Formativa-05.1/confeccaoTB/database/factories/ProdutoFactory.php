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
        $produtos = [
            'Camiseta Básica Branca',
            'Camiseta Preta Premium',
            'Calça Jeans Skinny',
            'Calça Cargo Preta',
            'Jaqueta Jeans',
            'Jaqueta de Couro',
            'Vestido Floral',
            'Short Jeans',
            'Bermuda Cargo',
            'Regata Masculina',
            'Polo Piquet',
            'Moletom Cinza',
            'Moletom com Capuz',
            'Blusa de Tricô',
            'Legging Fitness',
        ];
        
        return [
            'nome' => fake()->randomElement($produtos),
            'descricao' => fake()->sentence(8),
            'preco' => fake()->randomFloat(2, 29.90, 199.90),
            'quantidade' => fake()->numberBetween(5, 100),
        ];
    }
}
