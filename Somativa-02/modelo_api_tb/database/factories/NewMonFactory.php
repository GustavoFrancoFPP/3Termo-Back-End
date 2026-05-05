<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewMonFactory extends Factory
{
    private static int $index = 0;

    private static array $mons = [
        [
            'name'               => '',
            'pokemon_id'         => 0,
            'type'               => '',
            'height'             => 0.00,
            'weight'             => 0.00,
            'abilities'          => [],
            'stats'              => [],
            'sprite_official'    => null,
            'sprite_front'       => null,
            'sprite_back'        => null,
            'sprite_front_shiny' => null,
            'sprite_back_shiny'  => null,
        ],
        [
            'name'               => '',
            'pokemon_id'         => 0,
            'type'               => '',
            'height'             => 0.00,
            'weight'             => 0.00,
            'abilities'          => [],
            'stats'              => [],
            'sprite_official'    => null,
            'sprite_front'       => null,
            'sprite_back'        => null,
            'sprite_front_shiny' => null,
            'sprite_back_shiny'  => null,
        ],
        [
            'name'               => '',
            'pokemon_id'         => 0,
            'type'               => '',
            'height'             => 0.00,
            'weight'             => 0.00,
            'abilities'          => [],
            'stats'              => [],
            'sprite_official'    => null,
            'sprite_front'       => null,
            'sprite_back'        => null,
            'sprite_front_shiny' => null,
            'sprite_back_shiny'  => null,
        ],
    ];

    public function definition(): array
    {
        $data = self::$mons[self::$index % count(self::$mons)];
        self::$index++;

        return $data;
    }
}
