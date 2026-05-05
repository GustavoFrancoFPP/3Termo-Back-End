<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurar Pokémon - Pokedex</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    @include('components.navbar')
    
    <div class="flex-1 flex flex-col p-8">
            <div class="max-w-2xl mx-auto">
                <!-- Cabeçalho -->
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold mb-4">Procurar Pokémon</h2>
                    <p class="text-gray-400">Busque um Pokémon existente por nome ou ID</p>
                </div>

                <!-- Formulário de Busca -->
                <div class="bg-gray-800 rounded-lg p-8 border border-gray-700">
                    <form id="searchForm" class="space-y-6">
                        <!-- Busca por Nome -->
                        <div>
                            <label for="search_name" class="block text-sm font-semibold mb-3">Buscar por Nome</label>
                            <input 
                                type="text" 
                                id="search_name" 
                                placeholder="Ex: pikachu, charizard, gholdengo"
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500 transition"
                                onkeyup="updateSearch(this.value, 'name')"
                            >
                        </div>

                        <!-- Divisor -->
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-700"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-gray-800 text-gray-400">ou</span>
                            </div>
                        </div>

                        <!-- Busca por ID -->
                        <div>
                            <label for="search_id" class="block text-sm font-semibold mb-3">Buscar por ID</label>
                            <input 
                                type="number" 
                                id="search_id" 
                                placeholder="Ex: 1, 25, 1000"
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500 transition"
                                onkeyup="updateSearch(this.value, 'id')"
                            >
                        </div>

                        <!-- Informação -->
                        <div class="bg-gray-900 p-4 rounded-lg border border-gray-700">
                            <p class="text-gray-400 text-sm">
                                <strong>💡 Dica:</strong> Você pode buscar Pokémons customizados (ID > 1025) ou da PokeAPI (ID 1-1025)
                            </p>
                        </div>

                        <!-- Botão -->
                        <button 
                            type="submit"
                            id="searchBtn"
                            class="w-full bg-red-600 hover:bg-red-700 px-6 py-3 rounded-lg font-semibold text-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            🔍 Procurar Pokémon
                        </button>
                    </form>

                    <div id="searchError" class="mt-4 text-red-400 text-sm hidden"></div>
                    <div id="searchMessage" class="mt-4 text-gray-400 text-sm hidden"></div>
                </div>

                <!-- Exemplos Rápidos -->
                <div class="mt-12">
                    <h3 class="text-lg font-semibold mb-4">Exemplos Rápidos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="/pokemon/pikachu" class="bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg p-4 transition">
                            <p class="font-semibold mb-1">⚡ Pikachu</p>
                            <p class="text-gray-400 text-sm">ID: 25 - Elétrico</p>
                        </a>
                        <a href="/pokemon/1" class="bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg p-4 transition">
                            <p class="font-semibold mb-1">🌱 Bulbassauro</p>
                            <p class="text-gray-400 text-sm">ID: 1 - Grama/Veneno</p>
                        </a>
                        <a href="/pokemon/charizard" class="bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg p-4 transition">
                            <p class="font-semibold mb-1">🔥 Charizard</p>
                            <p class="text-gray-400 text-sm">ID: 6 - Fogo/Voador</p>
                        </a>
                        <a href="/pokemon/dragonite" class="bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg p-4 transition">
                            <p class="font-semibold mb-1">🐉 Dragonite</p>
                            <p class="text-gray-400 text-sm">ID: 149 - Dragão/Voador</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
            const searchBtn = document.getElementById('searchBtn');
            const error = document.getElementById('searchError');
            const message = document.getElementById('searchMessage');
            
            error.classList.add('hidden');
            message.classList.add('hidden');
            
            if (type === 'name') {
                document.getElementById('search_id').value = '';
                if (value.trim().length < 2) {
                    searchBtn.disabled = true;
                    return;
                }
            } else if (type === 'id') {
                document.getElementById('search_name').value = '';
                if (value.trim().length === 0 || isNaN(value)) {
                    searchBtn.disabled = true;
                    return;
                }
            }
            
            searchBtn.disabled = false;
        }

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('search_name').value.trim();
            const id = document.getElementById('search_id').value.trim();
            const error = document.getElementById('searchError');
            const message = document.getElementById('searchMessage');
            
            if (!name && !id) {
                error.textContent = 'Por favor, preencha o campo de busca';
                error.classList.remove('hidden');
                return;
            }
            
            const searchTerm = name || id;
            window.location.href = `/pokemon/${searchTerm}`;
        });
    </script>
</body>
</html>
