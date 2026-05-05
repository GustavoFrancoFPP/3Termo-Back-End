<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $id = rand(1, 100);
        $response = Http::get("https://dummyjson.com/users/{$id}");

        if ($response->successful()) {
            $user = $response->json();
            return view('user', compact('user'));
        }

        return view('user')->with('error', 'Erro ao buscar usuário');
    }

    public function show($id)
    {
        $response = Http::get("https://dummyjson.com/users/{$id}");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Usuário não encontrado'], 404);
    }

    public function search(Request $request)
    {
        $query = trim($request->query('q', ''));
        if ($query === '') {
            return response()->json(['error' => 'Termo de busca não informado'], 400);
        }

        $response = Http::get("https://dummyjson.com/users/search", ['q' => $query]);

        if ($response->successful()) {
            $data = $response->json();
            if (!empty($data['users'])) {
                return response()->json($data['users'][0]);
            }
        }

        return response()->json(['error' => 'Usuário não encontrado'], 404);
    }
}
