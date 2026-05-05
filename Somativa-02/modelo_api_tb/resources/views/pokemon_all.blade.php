<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Pokémons - Pokédex</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    @include('components.navbar')
    
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Cabeçalho -->
            <div class="mb-12">
                <h1 class="text-4xl font-bold mb-4">Pokédex Completa</h1>
                <p class="text-gray-400 text-lg">
                    Total: <span class="text-red-500 font-semibold">{{ $totalCustom + 1025 }}</span> Pokémons 
                    <span class="text-gray-600">({{ $totalCustom }} customizados + 1025 da PokeAPI)</span>
                </p>
            </div>

            <!-- Barra de Busca -->
            <div class="mb-8">
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="🔍 Buscar Pokémon por nome ou ID..."
                    class="w-full px-6 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition"
                    onkeyup="filterPokemons()"
                >
            </div>

            <!-- Grid de Pokémons Customizados -->
            @if($customPokemons->count() > 0)
                <div class="mb-16">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="text-2xl">✨</span>
                        <h2 class="text-2xl font-bold">Meus Pokémons Customizados</h2>
                        <span class="bg-blue-600 px-3 py-1 rounded-full text-sm font-semibold">{{ $customPokemons->count() }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                        @foreach($customPokemons as $pokemon)
                            <a href="/pokemon/{{ $pokemon->name }}" class="pokemon-card bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 rounded-lg p-4 transition transform hover:scale-105 cursor-pointer group">
                                <div class="text-center">
                                    @if($pokemon->image_path)
                                        <div class="mb-2 h-20 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $pokemon->image_path) }}" alt="{{ $pokemon->name }}" class="max-h-20 max-w-full">
                                        </div>
                                    @else
                                        <div class="text-4xl mb-2">🔴</div>
                                    @endif
                                    <p class="font-semibold text-sm capitalize truncate">{{ $pokemon->name }}</p>
                                    <p class="text-gray-200 text-xs">#{{ $pokemon->pokemon_id }}</p>
                                    <div class="flex justify-center gap-1 mt-2">
                                        @foreach(explode(', ', $pokemon->type) as $type)
                                            <span class="text-xs bg-blue-800 px-2 py-1 rounded">{{ trim($type) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Grid de Pokémons da PokeAPI -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-2xl">📚</span>
                    <h2 class="text-2xl font-bold">Pokémons da PokeAPI</h2>
                    <span class="bg-purple-600 px-3 py-1 rounded-full text-sm font-semibold">1025</span>
                </div>

                <div id="pokemonGrid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!-- Carregado via JavaScript -->
                </div>

                <div id="loadingMessage" class="text-center py-12 text-gray-400">
                    Carregando Pokémons da PokeAPI...
                </div>

                <div id="errorMessage" class="text-center py-12 text-red-400 hidden">
                    Erro ao carregar Pokémons. Tente recarregar a página.
                </div>
            </div>
        </div>
    </div>

    <script>
        let pokemons = [];
        let filteredPokemons = [];
        const itemsPerPage = 1025;

        // Carregar Pokémons da PokeAPI
        async function loadPokemons() {
            try {
                const response = await fetch('https://pokeapi.co/api/v2/pokemon?limit=1025');
                const data = await response.json();
                
                pokemons = data.results.map((p, index) => ({
                    name: p.name,
                    id: index + 1,
                    url: p.url,
                    imageUrl: `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${index + 1}.png`
                }));

                filteredPokemons = [...pokemons];
                displayPokemons();
                document.getElementById('loadingMessage').classList.add('hidden');
            } catch (error) {
                console.error('Erro ao carregar Pokémons:', error);
                document.getElementById('loadingMessage').classList.add('hidden');
                document.getElementById('errorMessage').classList.remove('hidden');
            }
        }

        function displayPokemons() {
            const grid = document.getElementById('pokemonGrid');
            grid.innerHTML = filteredPokemons.map(p => `
                <a href="/pokemon/${p.name}" class="pokemon-card bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 rounded-lg p-4 transition transform hover:scale-105">
                    <div class="text-center">
                        <div class="mb-2 h-20 flex items-center justify-center">
                            <img src="${p.imageUrl}" alt="${p.name}" class="max-h-20 max-w-full" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22%3E%3Crect fill=%22%23333%22 width=%2280%22 height=%2280%22/%3E%3C/svg%3E'">
                        </div>
                        <p class="font-semibold text-sm capitalize truncate">${p.name}</p>
                        <p class="text-gray-200 text-xs">#${p.id}</p>
                    </div>
                </a>
            `).join('');
        }

        function filterPokemons() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            if (!searchTerm) {
                filteredPokemons = [...pokemons];
            } else {
                filteredPokemons = pokemons.filter(p => 
                    p.name.toLowerCase().includes(searchTerm) || 
                    p.id.toString().includes(searchTerm)
                );
            }

            if (filteredPokemons.length === 0) {
                document.getElementById('pokemonGrid').innerHTML = '<div class="col-span-full text-center py-12 text-gray-400">Nenhum Pokémon encontrado</div>';
            } else {
                displayPokemons();
            }
        }

        // Carregar Pokémons ao iniciar
        loadPokemons();

        // Infinite scroll
        window.addEventListener('scroll', () => {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
                // Pode adicionar carregamento de mais Pokémons aqui se necessário
            }
        });
    </script>
</body>
</html>
