
<?php

use App\Models\NewMon;
use App\Http\Controllers\NewMonController;
use App\Http\Controllers\PokemonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('pokedex', [PokemonController::class, 'index'])->name('pokedex');

// Rotas para Pokemons customizados
Route::get('pokemons', [NewMonController::class, 'index'])->name('pokemons.index');
Route::get('pokemon/search/{nome}', [NewMonController::class, 'search'])->name('pokemon.search');
Route::get('pokemon/criar', [NewMonController::class, 'create'])->name('pokemon.create');
Route::post('pokemon/salvar', [NewMonController::class, 'store'])->name('pokemon.store');

Route::get('pokemons-all', function () {
    $customPokemons = NewMon::all();
    $totalCustom = $customPokemons->count();
    
    return view('pokemon_all', compact('customPokemons', 'totalCustom'));
})->name('pokemons.all');

// Rota de pesquisa de pokémon
Route::get('pokemon/search', function() {
    return view('pokemon_search');
})->name('pokemon.search.page');

// Rota unificada - procura no banco primeiro, depois na PokeAPI
Route::get('pokemon/{identifier}', function ($identifier) {
     // Procurar no banco de dados primeiro
     // Tenta buscar por ID exato primeiro
     $customPokemon = NewMon::where('pokemon_id', $identifier)->first();
     
     // Se não encontrar por ID, busca por nome (case-insensitive)
     if (!$customPokemon) {
         $customPokemon = NewMon::where('name', 'LIKE', "%{$identifier}%")->first();
     }
     
     if ($customPokemon) {
        // Retornar pokemon customizado
        return view('pokemon_api', [
            'pokemon' => [
                'id' => $customPokemon->pokemon_id,
                'name' => $customPokemon->name,
                'types' => array_map(function($type) {
                    return ['type' => ['name' => trim($type)]];
                }, explode(',', $customPokemon->type)),
                'height' => $customPokemon->height * 10, // converter de volta
                'weight' => $customPokemon->weight * 10, // converter de volta
                'sprites' => [
                    'front_default' => $customPokemon->image_path ? asset('storage/' . $customPokemon->image_path) : null,
                    'other' => ['official-artwork' => ['front_default' => $customPokemon->image_path ? asset('storage/' . $customPokemon->image_path) : null]]
                ],
                'abilities' => $customPokemon->abilities ?? [],
                'stats' => $customPokemon->stats ?? [],
                'is_custom' => true
            ]
        ]);
     }
     
     // Se não encontrar no banco, buscar na PokeAPI
     $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$identifier}");

     if ($response->successful()) {
        $pokemon = $response->json();
        return view('pokemon_api', compact('pokemon'));
     }
     
     return response()->json(['erro' => 'Pokemon não encontrado'], 404);
});

// Exemplo 2: POST
Route::post('pokemon/novo', function (Request $request) {
    $dados = $request->validate([
        'nome' => 'required|string|min:3',
        'tipo' => 'required|string',
        'ataque' => 'required|integer'
    ]); 

    return response()->json([
        'mensagem' => 'Pokemon cadastrado com sucesso!',
        'id_gerado' => rand(1000,9999),
        'dados_recebidos' => $dados
    ], 201);
});

Route::get('/', function () {
    return view('welcome');
});
