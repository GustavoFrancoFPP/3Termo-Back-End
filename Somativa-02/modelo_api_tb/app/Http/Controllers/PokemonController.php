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
        
        // Se houver parâmetro de busca, procurar primeiro no banco customizado
        if ($searchId || $searchName) {
            $customPokemon = null;
            
            if ($searchId) {
                $customPokemon = NewMon::where('pokemon_id', $searchId)->first();
            } elseif ($searchName) {
                $customPokemon = NewMon::where('name', 'LIKE', "%{$searchName}%")->first();
            }
            
            // Se encontrou no banco customizado, retornar com dados customizados
            if ($customPokemon) {
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
                    'abilities' => $customPokemon->abilities ?? [],
                    'stats' => $customPokemon->stats ?? [],
                    'is_custom' => true
                ];
                
                return view('pokemon', compact('pokemon'));
            }
            
            // Se não encontrou no banco, buscar na PokeAPI
            $searchTerm = $searchId ?? $searchName;
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$searchTerm}");
            
            if ($response->successful()) {
                $pokemon = $response->json();
                return view('pokemon', compact('pokemon'));
            }
            
            return "Pokemon não encontrado";
        }
        
        // Se não houver busca, retornar um Pokémon aleatório da PokeAPI
        $id = rand(1, 1025);
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$id}");

        if ($response->successful()) {
            $pokemon = $response->json();
            return view('pokemon', compact('pokemon'));
        }
        
        return "Erro ao buscar dados API";
    }
}
