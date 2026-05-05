<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($pokemon['name']) }} - Pokedex</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    @include('components.navbar')
    
    <div class="min-h-screen p-8">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('pokemons.index') }}" class="text-red-500 hover:text-red-400 mb-6 inline-block">← Voltar</a>
            
            <div class="bg-gray-800 rounded-lg p-8">
                <div class="mb-4">
                    @if(isset($pokemon['is_custom']) && $pokemon['is_custom'])
                        <span class="inline-block bg-blue-600 px-3 py-1 rounded-full text-sm font-semibold mb-4">✨ Pokemon Customizado</span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Imagem -->
                    <div class="flex items-center justify-center">
                        <div class="bg-gray-900 rounded-lg p-8 w-full h-96 flex items-center justify-center" id="imageContainer">
                            @php
                                $imageUrl = $pokemon['sprites']['other']['official-artwork']['front_default'] ?? $pokemon['sprites']['front_default'] ?? null;
                            @endphp
                            @if($imageUrl)
                                <img 
                                    src="{{ $imageUrl }}" 
                                    alt="{{ $pokemon['name'] }}" 
                                    class="max-h-80 max-w-full rounded"
                                    onerror="document.getElementById('imageContainer').innerHTML = '<span class=\'text-6xl\'>🔴</span>'"
                                >
                            @else
                                <span class="text-6xl">🔴</span>
                            @endif
                        </div>
                    </div>

                    <!-- Informações -->
                    <div>
                        <h1 class="text-4xl font-bold capitalize mb-4">{{ $pokemon['name'] }}</h1>
                        
                        <div class="space-y-4 mb-6">
                            <div class="bg-gray-900 p-4 rounded">
                                <p class="text-gray-400">ID do Pokemon</p>
                                <p class="text-2xl font-bold">#{{ $pokemon['id'] }}</p>
                            </div>

                            <div class="bg-gray-900 p-4 rounded">
                                <p class="text-gray-400">Tipo</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($pokemon['types'] as $type)
                                        <span class="bg-red-600 px-3 py-1 rounded-full text-sm font-semibold capitalize">
                                            {{ $type['type']['name'] ?? $type['name'] ?? 'Desconhecido' }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-900 p-4 rounded">
                                    <p class="text-gray-400">Altura</p>
                                    <p class="text-2xl font-bold">{{ ($pokemon['height'] / 10) }}m</p>
                                </div>
                                <div class="bg-gray-900 p-4 rounded">
                                    <p class="text-gray-400">Peso</p>
                                    <p class="text-2xl font-bold">{{ ($pokemon['weight'] / 10) }}kg</p>
                                </div>
                            </div>
                        </div>

                        @if($pokemon['abilities'] && count($pokemon['abilities']) > 0)
                            <div class="bg-gray-900 p-4 rounded mb-6">
                                <p class="text-gray-400 font-semibold mb-2">Habilidades</p>
                                <ul class="space-y-1">
                                    @foreach($pokemon['abilities'] as $ability)
                                        <li class="text-gray-200 capitalize">
                                            @if(is_array($ability) && isset($ability['ability']))
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
                @if($pokemon['stats'] && count($pokemon['stats']) > 0)
                    <div class="mt-8 border-t border-gray-700 pt-8">
                        <h2 class="text-2xl font-bold mb-6">Status</h2>
                        <div class="space-y-4">
                            @foreach($pokemon['stats'] as $statKey => $stat)
                                @php
                                    // Lidar com PokeAPI (array com 'stat' e 'base_stat')
                                    if (is_array($stat) && isset($stat['stat'])) {
                                        $statName = $stat['stat']['name'];
                                        $statValue = $stat['base_stat'];
                                    } else {
                                        // Lidar com customizado (key-value direto)
                                        $statName = is_string($statKey) ? $statKey : (is_string($stat) ? $stat : 'Desconhecido');
                                        $statValue = is_numeric($stat) ? $stat : 0;
                                    }
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="font-semibold capitalize">{{ str_replace('-', ' ', $statName) }}</span>
                                        <span class="font-bold text-red-500">{{ $statValue }}</span>
                                    </div>
                                    <div class="w-full bg-gray-900 rounded-full h-2">
                                        <div 
                                            class="bg-red-600 h-2 rounded-full" 
                                            style="width: {{ min($statValue / 150 * 100, 100) }}%"
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
