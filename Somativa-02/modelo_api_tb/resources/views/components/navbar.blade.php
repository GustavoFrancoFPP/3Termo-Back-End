<!-- Menu de Navegação -->
<nav class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="text-3xl">⚡</span>
            <h1 class="text-2xl font-bold text-red-500">Pokédex</h1>
        </div>
        
        <div class="hidden md:flex gap-6">
            <a href="/" class="text-gray-300 hover:text-red-500 transition">Início</a>
            <a href="/pokedex" class="text-gray-300 hover:text-red-500 transition">Pokédex PokeAPI</a>
            <a href="{{ route('pokemons.all') }}" class="text-gray-300 hover:text-red-500 transition">Pokédex Completa</a>
            <a href="{{ route('pokemon.create') }}" class="text-gray-300 hover:text-red-500 transition">Criar</a>
            <a href="{{ route('pokemons.index') }}" class="text-gray-300 hover:text-red-500 transition">Meus Pokémons</a>
            <a href="/pokemon/search" class="text-gray-300 hover:text-red-500 transition">Procurar</a>

        <!-- Menu Mobile -->
        <button class="md:hidden text-gray-400 hover:text-white" id="mobileMenuBtn">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Menu Mobile Expandido -->
    <div id="mobileMenu" class="hidden md:hidden bg-gray-700 border-t border-gray-600">
        <a href="/" class="block px-4 py-3 text-gray-300 hover:bg-gray-600">Início</a>
        <a href="/pokedex" class="block px-4 py-3 text-gray-300 hover:bg-gray-600">Pokédex PokeAPI</a>
        <a href="{{ route('pokemons.all') }}" class="block px-4 py-3 text-gray-300 hover:bg-gray-600">Pokédex Completa</a>
        <a href="{{ route('pokemon.create') }}" class="block px-4 py-3 text-gray-300 hover:bg-gray-600">Criar Pokémon</a>
        <a href="{{ route('pokemons.index') }}" class="block px-4 py-3 text-gray-300 hover:bg-gray-600">Meus Pokémons</a>
        <a href="/pokemon/search" class="block px-4 py-3 text-gray-300 hover:bg-gray-600">Procurar</a>
    </div>
</nav>

<script>
    if (document.getElementById('mobileMenuBtn')) {
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    }
</script>
