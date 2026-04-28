<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PokemonController extends Controller
{
    public function index()
    {
        $id = rand(1,1025);
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$id}");

        if ($response->successful()) {
            $pokemon = $response->json();
        

            return view('pokemon', compact('pokemon'));
        }
        return "Erro ao buscar dados API";

    }
}
