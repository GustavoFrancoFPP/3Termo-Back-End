<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pokemon->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    @include('components.navbar')
    
    <div class="min-h-screen p-8">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('pokemons.index') }}" class="text-red-500 hover:text-red-400 mb-6 inline-block">← Voltar</a>
            
            <div class="bg-gray-800 rounded-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Imagem -->
                    <div class="flex items-center justify-center">
                        @if($pokemon->image_path)
                            <div class="bg-gray-900 rounded-lg p-8 w-full h-96 flex items-center justify-center">
                                <img src="{{ asset('storage/' . $pokemon->image_path) }}" alt="{{ $pokemon->name }}" class="max-h-80 max-w-full rounded">
                            </div>
                        @else
                            <div class="bg-gray-900 rounded-lg p-8 w-full h-96 flex items-center justify-center text-6xl">
                                🔴
                            </div>
                        @endif
                    </div>

                    <!-- Informações -->
                    <div>
                        <h1 class="text-4xl font-bold capitalize mb-4">{{ $pokemon->name }}</h1>
                        
                        <div class="space-y-4 mb-6">
                            <div class="bg-gray-900 p-4 rounded">
                                <p class="text-gray-400">ID do Pokemon</p>
                                <p class="text-2xl font-bold">#{{ $pokemon->pokemon_id }}</p>
                            </div>

                            <div class="bg-gray-900 p-4 rounded">
                                <p class="text-gray-400">Tipo</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach(explode(', ', $pokemon->type) as $type)
                                        <span class="bg-red-600 px-3 py-1 rounded-full text-sm font-semibold capitalize">
                                            {{ $type }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-900 p-4 rounded">
                                    <p class="text-gray-400">Altura</p>
                                    <p class="text-2xl font-bold">{{ $pokemon->height }}m</p>
                                </div>
                                <div class="bg-gray-900 p-4 rounded">
                                    <p class="text-gray-400">Peso</p>
                                    <p class="text-2xl font-bold">{{ $pokemon->weight }}kg</p>
                                </div>
                            </div>
                        </div>

                        @if($pokemon->abilities && count($pokemon->abilities) > 0)
                            <div class="bg-gray-900 p-4 rounded mb-6">
                                <p class="text-gray-400 font-semibold mb-2">Habilidades</p>
                                <ul class="space-y-1">
                                    @foreach($pokemon->abilities as $ability)
                                        <li class="text-gray-200 capitalize">
                                            @if(is_array($ability) && isset($ability['ability']['name']))
                                                • {{ $ability['ability']['name'] }}
                                            @else
                                                • {{ $ability }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stats -->
                @if($pokemon->stats && count($pokemon->stats) > 0)
                    <div class="mt-8 border-t border-gray-700 pt-8">
                        <h2 class="text-2xl font-bold mb-6">Status</h2>
                        <div class="space-y-4">
                            @foreach($pokemon->stats as $statName => $statValue)
                                @php
                                    // Lidar com ambos os formatos: PokeAPI e customizado
                                    $name = is_array($statValue) ? ($statValue['stat']['name'] ?? $statName) : $statName;
                                    $value = is_array($statValue) ? ($statValue['base_stat'] ?? 0) : $statValue;
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="font-semibold capitalize">{{ str_replace('-', ' ', $name) }}</span>
                                        <span class="font-bold text-red-500">{{ $value }}</span>
                                    </div>
                                    <div class="w-full bg-gray-900 rounded-full h-2">
                                        <div 
                                            class="bg-red-600 h-2 rounded-full" 
                                            style="width: {{ min($value / 150 * 100, 100) }}%"
                                        ></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
