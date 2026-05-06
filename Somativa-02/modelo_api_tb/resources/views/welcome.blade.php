<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Righteous', cursive;
        }
        .pokemon-card {
            border: 4px solid black;
            box-shadow: 6px 6px 0px rgba(0, 0, 0, 0.3);
            transform: perspective(1000px) rotateX(0deg);
            transition: all 0.3s ease;
        }
        .pokemon-card:hover {
            transform: perspective(1000px) rotateX(-5deg) translateY(-5px);
            box-shadow: 8px 8px 0px rgba(0, 0, 0, 0.5);
        }
        .glow-text {
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.5);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-bounce {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-blue-300 to-blue-200 text-black min-h-screen">
    @include('components.navbar')
    
    <div class="flex items-center justify-center min-h-[calc(100vh-80px)] px-4 py-8">
        <div class="text-center max-w-3xl">
            <!-- Poké Ball Animada -->
            <div class="text-8xl mb-6 drop-shadow-lg float-bounce">🔴</div>
            
            <!-- Título Pokémon -->
            <h1 class="text-6xl font-black mb-4 glow-text" style="color: #FFCC00; text-shadow: 4px 4px 0px #0033CC, -2px -2px 0px #FF3333;">POKéDEX</h1>
            
            <p class="text-xl font-bold text-black mb-4 drop-shadow">Bem-vindo ao mundo dos Pokémons!</p>
            <p class="text-lg text-gray-800 mb-12 drop-shadow">Busque, capture e crie seus próprios Pokémons</p>

            <!-- Botões Principais - Estilo Pokémon -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
                <!-- Buscar -->
                <a href="/pokedex" class="pokemon-card bg-gradient-to-br from-red-600 to-red-700 px-8 py-6 font-black text-2xl text-white border-4 border-black hover:scale-110 transition-all">
                    🔍<br/>BUSCAR
                </a>

                <!-- Ver Todos -->
                <a href="{{ route('pokemons.all') }}" class="pokemon-card bg-gradient-to-br from-yellow-400 to-yellow-500 px-8 py-6 font-black text-2xl text-black border-4 border-black hover:scale-110 transition-all">
                    📚<br/>TODOS
                </a>

                <!-- Criar -->
                <a href="{{ route('pokemon.create') }}" class="pokemon-card bg-gradient-to-br from-green-600 to-green-700 px-8 py-6 font-black text-2xl text-white border-4 border-black hover:scale-110 transition-all">
                    ➕<br/>CRIAR
                </a>

                <!-- Meus Pokémons -->
                <a href="{{ route('pokemons.index') }}" class="pokemon-card bg-gradient-to-br from-purple-600 to-purple-700 px-8 py-6 font-black text-2xl text-white border-4 border-black hover:scale-110 transition-all">
                    ✨<br/>MEUS
                </a>
            </div>

            <!-- Pokémons Iniciais -->
            <div class="mt-16 pt-8 border-t-4 border-black">
                <p class="text-2xl font-black mb-6 glow-text">POKÉMONS INICIAIS</p>
                <div class="flex justify-center gap-8 flex-wrap">
                    <div class="pokemon-card bg-white p-4 w-24">
                        <div class="text-4xl mb-2">🌱</div>
                        <p class="font-black text-sm">Bulbassauro</p>
                        <p class="text-xs text-gray-600">#001</p>
                    </div>
                    <div class="pokemon-card bg-white p-4 w-24">
                        <div class="text-4xl mb-2">🔥</div>
                        <p class="font-black text-sm">Charmander</p>
                        <p class="text-xs text-gray-600">#004</p>
                    </div>
                    <div class="pokemon-card bg-white p-4 w-24">
                        <div class="text-4xl mb-2">💧</div>
                        <p class="font-black text-sm">Squirtle</p>
                        <p class="text-xs text-gray-600">#007</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
