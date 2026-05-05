<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pokemons</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    @include('components.navbar')
    
    <div class="min-h-screen p-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold">Meu Pokedex 🔴</h1>
                <a href="{{ route('pokemon.create') }}" class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded-lg font-semibold">
                    + Criar Pokemon
                </a>
            </div>

            <form method="GET" class="mb-8">
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Buscar por nome..." 
                        value="{{ $search ?? '' }}"
                        class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-red-500"
                    >
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-lg font-semibold">
                        🔍 Buscar
                    </button>
                    @if($search)
                        <a href="{{ route('pokemons.index') }}" class="bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-lg font-semibold">
                            ✕ Limpar
                        </a>
                    @endif
                </div>
            </form>

            @if($pokemons->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pokemons as $pokemon)
                        <a href="{{ route('pokemon.search', $pokemon->name) }}" class="block">
                            <div class="bg-gray-800 hover:bg-gray-700 rounded-lg p-6 transition transform hover:scale-105 cursor-pointer">
                                @if($pokemon->image_path)
                                    <div class="h-40 flex items-center justify-center mb-4 bg-gray-900 rounded">
                                        <img src="{{ asset('storage/' . $pokemon->image_path) }}" alt="{{ $pokemon->name }}" class="h-32">
                                    </div>
                                @else
                                    <div class="h-40 flex items-center justify-center mb-4 bg-gray-900 rounded text-4xl">
                                        🔴
                                    </div>
                                @endif
                                <h2 class="text-2xl font-bold capitalize mb-2">{{ $pokemon->name }}</h2>
                                <p class="text-gray-400 mb-2"><span class="font-semibold">Tipo:</span> {{ $pokemon->type }}</p>
                                <p class="text-gray-400 mb-2"><span class="font-semibold">ID:</span> #{{ $pokemon->pokemon_id }}</p>
                                <p class="text-sm text-gray-500">Clique para ver detalhes →</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    @if($search)
                        <p class="text-2xl text-gray-400 mb-4">Nenhum pokemon encontrado para "{{ $search }}"!</p>
                        <div class="space-y-4">
                            <a href="{{ route('pokemons.index') }}" class="bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-lg font-semibold inline-block">
                                ← Voltar à lista
                            </a>
                            <p class="text-gray-500">ou</p>
                            <a href="{{ route('pokemon.create') }}" class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-lg font-semibold inline-block">
                                + Criar novo Pokemon
                            </a>
                        </div>
                    @else
                        <p class="text-2xl text-gray-400 mb-4">Nenhum pokemon encontrado!</p>
                        <a href="{{ route('pokemon.create') }}" class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-lg font-semibold inline-block">
                            Criar o Primeiro Pokemon
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</body>
</html>
