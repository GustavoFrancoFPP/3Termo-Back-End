<?php

namespace Database\Seeders;

use App\Models\NewMon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar 10 pokemons aleatórios da API
        for ($i = 1; $i <= 10; $i++) {
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$i}");

            if ($response->successful()) {
                $data = $response->json();

                $types = array_map(fn($type) => $type['type']['name'], $data['types']);

                NewMon::create([
                    'name' => $data['name'],
                    'pokemon_id' => $data['id'],
                    'type' => implode(', ', $types),
                    'height' => $data['height'] / 10, // converter para metros
                    'weight' => $data['weight'] / 10, // converter para kg
                    'abilities' => $data['abilities'],
                    'stats' => $data['stats'],
                    'sprite_official' => $data['sprites']['other']['official-artwork']['front_default'] ?? null,
                    'sprite_front' => $data['sprites']['front_default'] ?? null,
                    'sprite_back' => $data['sprites']['back_default'] ?? null,
                    'sprite_front_shiny' => $data['sprites']['front_shiny'] ?? null,
                    'sprite_back_shiny' => $data['sprites']['back_shiny'] ?? null,
                ]);
            }
        }

        echo "10 Pokemons inseridos com sucesso!";
    }
}
