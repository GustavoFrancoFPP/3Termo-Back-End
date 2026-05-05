<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex - Bem-vindo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { text-shadow: 0 0 10px rgba(239, 68, 68, 0.5); }
            50% { text-shadow: 0 0 30px rgba(239, 68, 68, 0.8); }
        }
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .pokemon-bounce { animation: float 3s ease-in-out infinite; }
        .pokemon-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .pokemon-spin { animation: spin-slow 8s linear infinite; }
        
        .btn-pokemon {
            position: relative;
            overflow: hidden;
        }
        
        .btn-pokemon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 0.5s;
        }
        
        .btn-pokemon:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-950 via-red-900 to-black text-white min-h-screen">
    @include('components.navbar')
    
    <div class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16 max-w-3xl">
            <!-- Pokémon Float Animation -->
            <div class="mb-8">
                <div class="text-8xl pokemon-bounce pokemon-glow inline-block">🔴</div>
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-red-400 to-yellow-400">
                Pokédex
            </h1>
            
            <p class="text-xl text-gray-300 mb-2">Bem-vindo ao mundo dos Pokémons</p>
            <p class="text-gray-400">Explore, busque ou crie seus próprios Pokémons</p>
        </div>

        <!-- Botões Principais (Grid 2x2 simplificado) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl w-full mb-16">
            <!-- Pokédex Completa (Principal) -->
            <a href="{{ route('pokemons.all') }}" class="btn-pokemon group bg-gradient-to-br from-purple-600 to-purple-800 hover:from-purple-500 hover:to-purple-700 rounded-2xl p-8 transition-all duration-300 transform hover:scale-110 shadow-2xl">
                <div class="text-6xl mb-4 group-hover:scale-125 transition-transform">📚</div>
                <h2 class="text-3xl font-bold mb-3">Pokédex</h2>
                <p class="text-gray-100 text-lg">Todos os 1025+ Pokémons</p>
                <div class="mt-4 text-sm text-purple-200">Customizados + PokeAPI</div>
            </a>

            <!-- Buscar Pokémon (Principal) -->
            <a href="/pokemon/search" class="btn-pokemon group bg-gradient-to-br from-red-600 to-red-800 hover:from-red-500 hover:to-red-700 rounded-2xl p-8 transition-all duration-300 transform hover:scale-110 shadow-2xl">
                <div class="text-6xl mb-4 group-hover:scale-125 transition-transform">🔍</div>
                <h2 class="text-3xl font-bold mb-3">Buscar</h2>
                <p class="text-gray-100 text-lg">Procure por ID ou Nome</p>
                <div class="mt-4 text-sm text-red-200">Rápido e Fácil</div>
            </a>

            <!-- Meus Pokémons -->
            <a href="{{ route('pokemons.index') }}" class="btn-pokemon group bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 rounded-2xl p-8 transition-all duration-300 transform hover:scale-105 shadow-xl">
                <div class="text-5xl mb-4 group-hover:scale-125 transition-transform">✨</div>
                <h2 class="text-2xl font-bold mb-2">Meus Pokémons</h2>
                <p class="text-gray-100">Pokémons Criados</p>
            </a>

            <!-- Criar Pokémon -->
            <a href="{{ route('pokemon.create') }}" class="btn-pokemon group bg-gradient-to-br from-green-600 to-green-800 hover:from-green-500 hover:to-green-700 rounded-2xl p-8 transition-all duration-300 transform hover:scale-105 shadow-xl">
                <div class="text-5xl mb-4 group-hover:scale-125 transition-transform">➕</div>
                <h2 class="text-2xl font-bold mb-2">Criar</h2>
                <p class="text-gray-100">Novo Pokémon</p>
            </a>
        </div>

        <!-- Pokémons em Destaque -->
        <div class="w-full max-w-4xl">
            <h3 class="text-2xl font-bold text-center mb-8 text-gray-200">Pokémons Populares</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="/pokemon/pikachu" class="group bg-gray-800 hover:bg-gray-700 border-2 border-gray-700 hover:border-yellow-500 rounded-lg p-4 transition-all text-center transform hover:scale-105">
                    <div class="text-5xl mb-3 group-hover:pokemon-bounce">⚡</div>
                    <p class="font-bold text-lg">Pikachu</p>
                    <p class="text-gray-400 text-sm">#25</p>
                </a>
                <a href="/pokemon/1" class="group bg-gray-800 hover:bg-gray-700 border-2 border-gray-700 hover:border-green-500 rounded-lg p-4 transition-all text-center transform hover:scale-105">
                    <div class="text-5xl mb-3 group-hover:pokemon-bounce">🌱</div>
                    <p class="font-bold text-lg">Bulbassauro</p>
                    <p class="text-gray-400 text-sm">#1</p>
                </a>
                <a href="/pokemon/charizard" class="group bg-gray-800 hover:bg-gray-700 border-2 border-gray-700 hover:border-orange-500 rounded-lg p-4 transition-all text-center transform hover:scale-105">
                    <div class="text-5xl mb-3 group-hover:pokemon-bounce">🔥</div>
                    <p class="font-bold text-lg">Charizard</p>
                    <p class="text-gray-400 text-sm">#6</p>
                </a>
                <a href="/pokemon/dragonite" class="group bg-gray-800 hover:bg-gray-700 border-2 border-gray-700 hover:border-indigo-500 rounded-lg p-4 transition-all text-center transform hover:scale-105">
                    <div class="text-5xl mb-3 group-hover:pokemon-bounce">🐉</div>
                    <p class="font-bold text-lg">Dragonite</p>
                    <p class="text-gray-400 text-sm">#149</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 bg-opacity-80 border-t border-gray-800 mt-20 py-6 text-center text-gray-500">
        <p>🎮 Pokédex - Desenvolvido com ❤️ usando Laravel</p>
    </footer>

    <script>
        // Efeito hover adicional nos botões
        document.querySelectorAll('.btn-pokemon').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
