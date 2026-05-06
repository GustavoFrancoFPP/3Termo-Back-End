<?php

namespace App\Http\Controllers;

use App\Models\NewMon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PokemonController extends Controller
{
    public function index(Request $request)
    {
        // Aceitar parâmetros de busca
        $searchId = $request->query('id');
        $searchName = $request->query('name') ?? $request->query('search');
        $isCustom = false;
        
        // Se houver parâmetro de busca, procurar primeiro no banco customizado
        if ($searchId || $searchName) {
            $customPokemon = null;
            
            if ($searchId) {
                // Procura por ID exato
                $customPokemon = NewMon::where('pokemon_id', $searchId)->first();
                if (!$customPokemon) {
                    // Procura por ID como número inteiro
                    $customPokemon = NewMon::where('pokemon_id', (int)$searchId)->first();
                }
            } elseif ($searchName) {
                // Procura por nome (case-insensitive)
                $customPokemon = NewMon::where('name', 'LIKE', "%{$searchName}%")
                    ->orWhere('pokemon_id', $searchName)
                    ->first();
            }
            
            // Se encontrou no banco customizado, retornar com dados customizados
            if ($customPokemon) {
                $isCustom = true;
                
                // Formatar stats no padrão PokeAPI
                $stats = [];
                if ($customPokemon->stats) {
                    $statNames = ['hp', 'attack', 'defense', 'special-attack', 'special-defense', 'speed'];
                    $customStats = is_array($customPokemon->stats) ? $customPokemon->stats : json_decode($customPokemon->stats, true) ?? [];
                    
                    foreach ($statNames as $index => $statName) {
                        $value = $customStats[$index] ?? $customStats[$statName] ?? 0;
                        $stats[] = [
                            'stat' => ['name' => $statName],
                            'base_stat' => (int)$value
                        ];
                    }
                }
                
                // Formatar abilities no padrão PokeAPI
                $abilities = [];
                if ($customPokemon->abilities) {
                    $customAbilities = is_array($customPokemon->abilities) ? $customPokemon->abilities : json_decode($customPokemon->abilities, true) ?? [];
                    foreach ($customAbilities as $ability) {
                        $abilities[] = [
                            'ability' => ['name' => is_array($ability) ? ($ability['name'] ?? $ability) : $ability],
                            'is_hidden' => false,
                            'slot' => count($abilities) + 1
                        ];
                    }
                }
                
                $pokemon = [
                    'id' => $customPokemon->pokemon_id,
                    'name' => $customPokemon->name,
                    'types' => array_map(function($type) {
                        return ['type' => ['name' => trim($type)]];
                    }, explode(',', $customPokemon->type)),
                    'height' => $customPokemon->height * 10,
                    'weight' => $customPokemon->weight * 10,
                    'sprites' => [
                        'front_default' => $customPokemon->image_path ? asset('storage/' . $customPokemon->image_path) : null,
                        'other' => ['official-artwork' => ['front_default' => $customPokemon->image_path ? asset('storage/' . $customPokemon->image_path) : null]]
                    ],
                    'abilities' => $abilities,
                    'stats' => $stats,
                    'is_custom' => true
                ];
                
                return view('pokemon', compact('pokemon', 'isCustom'));
            }
            
            // Se não encontrou no banco, buscar na PokeAPI
            $searchTerm = $searchId ?? $searchName;
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$searchTerm}");
            
            if ($response->successful()) {
                $pokemon = $response->json();
                $pokemon['is_custom'] = false;
                return view('pokemon', compact('pokemon', 'isCustom'));
            }
            
            return "Pokemon não encontrado";
        }
        
        // Se não houver busca, retornar um Pokémon aleatório da PokeAPI
        $id = rand(1, 1025);
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$id}");

        if ($response->successful()) {
            $pokemon = $response->json();
            $pokemon['is_custom'] = false;
            return view('pokemon', compact('pokemon', 'isCustom'));
        }
        
        return "Erro ao buscar dados API";
    }
}
