<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    private static $produtoIndex = 0;
    private static $produtos = [
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
        'Saia Executiva',
        'Shorts Linho',
        'Blazer Preto',
        'Cardigan Cream',
        'Jaqueta Couro Genuína',
        'Dress Social',
        'Camiseta Estampada',
        'Calça Alfaiataria',
        'Bermuda Social',
        'Blusa Floral',
    ];
    
    public function definition(): array
    {
        $descricoes = [
            'Camiseta de algodão 100% premium com acabamento profissional e costuras reforçadas para durabilidade máxima.',
            'Calça jeans clássica com corte reto, cintura confortável e bolsos funcionais para uso diário elegante.',
            'Blusa social em tecido gorgurão com mangas 3/4 e botões decorativos, ideal para ambientes corporativos.',
            'Bermuda de moletom com elastano, perfeita para atividades esportivas e conforto casual amplificado.',
            'Casaco em lã nobiliada com forro interno acolchoado e fechamento em botões de madrepérola genuína.',
            'Vestido festa em seda pura com acabamento em renda, comprimento midi, para ocasiões especiais memoráveis.',
            'Jaqueta esportivo em material microfiber com tecnologia respirável e proteção UV 50+ avançada.',
            'Saia lápis em tricoline pura com zíper invisível, comprimento executivo, uniforme corporativo profissional.',
            'Jaqueta de couro genuíno com alinhamento perfeito, forro em seda natural e tachas de design exclusivo.',
            'Legging em suplex com cintura alta, ajuste anatômico perfeito e bolsos laterais funcionais para atividades.',
        ];
        
        $produto = self::$produtos[self::$produtoIndex % count(self::$produtos)];
        self::$produtoIndex++;
        
        return [
            'nome' => $produto,
            'descricao' => fake()->randomElement($descricoes),
            'preco' => fake()->randomFloat(2, 49.90, 299.90),
            'quantidade' => fake()->numberBetween(10, 150),
        ];
    }
}
