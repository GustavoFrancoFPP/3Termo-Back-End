<?php

namespace App\Http\Controllers;

use App\Models\NewMon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewMonController extends Controller
{
    public function index(Request $request){
        $search = $request->query('search');
        
        if ($search) {
            $pokemons = NewMon::where('name', 'like', "%{$search}%")->get();
        } else {
            $pokemons = NewMon::all();
        }
        
        return view('new_mons_list', compact('pokemons', 'search'));
    }

    public function search($nome)
    {
        $pokemon = NewMon::where('name', 'like', "%{$nome}%")->first();

        if ($pokemon) {
            return view('new_mon_detail', compact('pokemon'));
        }
        return "Pokemon não encontrado no banco de dados!";
    }

    public function create()
    {
        // Total de pokemons na PokeAPI
        $pokeAPITotal = 1025;
        
        // Pegar o maior ID customizado no banco
        $maxCustomId = NewMon::max('pokemon_id') ?? 0;
        
        // Se não houver customizados, começar depois dos 1025 da API
        // Se houver, continuar a sequência
        $nextId = $maxCustomId < $pokeAPITotal ? $pokeAPITotal + 1 : $maxCustomId + 1;

        // Tipos de pokemon disponíveis
        $types = [
            'Normal', 'Fogo', 'Água', 'Grama', 'Elétrico', 'Gelo', 
            'Lutador', 'Veneno', 'Terra', 'Voador', 'Psíquico', 'Inseto',
            'Rocha', 'Fantasma', 'Dragão', 'Sombrio', 'Aço', 'Fada'
        ];

        return view('new_mon_create', compact('nextId', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:new_mons',
            'pokemon_id' => 'required|integer|unique:new_mons',
            'types' => 'required|array|min:1',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'abilities' => 'nullable|array',
            'abilities.*' => 'nullable|string',
            'stats' => 'nullable|array',
            'stats.hp' => 'nullable|integer|min:0|max:255',
            'stats.attack' => 'nullable|integer|min:0|max:255',
            'stats.defense' => 'nullable|integer|min:0|max:255',
            'stats.special-attack' => 'nullable|integer|min:0|max:255',
            'stats.special-defense' => 'nullable|integer|min:0|max:255',
            'stats.speed' => 'nullable|integer|min:0|max:255',
        ]);

        // Concatenar tipos com vírgula
        $validated['type'] = implode(', ', $validated['types']);
        unset($validated['types']);

        // Processar habilidades - filtrar vazias
        if (!empty($validated['abilities'])) {
            $validated['abilities'] = array_filter($validated['abilities'], function($ability) {
                return !empty(trim($ability));
            });
            $validated['abilities'] = array_values($validated['abilities']); // Reindecar array
        } else {
            $validated['abilities'] = [];
        }

        // Processar stats - manter apenas valores preenchidos
        if (!empty($validated['stats'])) {
            $validated['stats'] = array_filter($validated['stats'], function($value) {
                return !is_null($value) && $value !== '';
            });
        } else {
            $validated['stats'] = [];
        }

        // Processar upload de imagem
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pokemons', 'public');
            $validated['image_path'] = $imagePath;
        }

        NewMon::create($validated);

        return redirect('/pokemons')->with('success', 'Pokemon criado com sucesso!');
    }
}
