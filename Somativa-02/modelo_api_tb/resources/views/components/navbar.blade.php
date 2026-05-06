<!-- Menu de Navegação - Estética Pokémon -->
<nav class="bg-gradient-to-r from-red-600 to-red-700 border-4 border-black sticky top-0 z-50 shadow-lg" style="font-family: 'Righteous', cursive;">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('IMAGES/POKEBOLA.png') }}" class="h-12 w-12 drop-shadow-lg" alt="Pokédex Icon">
            <h1 class="text-3xl font-black text-white drop-shadow-lg">POKéDEX</h1>
        </div>
        
        <div class="hidden md:flex gap-4">
            <a href="/" class="text-white font-bold hover:bg-red-800 px-4 py-2 rounded-lg transition transform hover:scale-105 drop-shadow">Início</a>
            <a href="/pokedex" class="text-white font-bold hover:bg-red-800 px-4 py-2 rounded-lg transition transform hover:scale-105 drop-shadow">Buscar</a>
            <a href="{{ route('pokemons.all') }}" class="text-white font-bold hover:bg-red-800 px-4 py-2 rounded-lg transition transform hover:scale-105 drop-shadow">Todos</a>
            <a href="{{ route('pokemon.create') }}" class="text-white font-bold hover:bg-red-800 px-4 py-2 rounded-lg transition transform hover:scale-105 drop-shadow">Criar</a>
            <a href="{{ route('pokemons.index') }}" class="text-white font-bold hover:bg-red-800 px-4 py-2 rounded-lg transition transform hover:scale-105 drop-shadow">Meus</a>

        <!-- Menu Mobile -->
        <button class="md:hidden text-white font-bold text-2xl" id="mobileMenuBtn">☰</button>
    </div>

    <!-- Menu Mobile Expandido -->
    <div id="mobileMenu" class="hidden md:hidden bg-red-700 border-t-4 border-black">
        <a href="/" class="block px-4 py-3 text-white font-bold hover:bg-red-800">Início</a>
        <a href="/pokedex" class="block px-4 py-3 text-white font-bold hover:bg-red-800">Buscar</a>
        <a href="{{ route('pokemons.all') }}" class="block px-4 py-3 text-white font-bold hover:bg-red-800">Todos</a>
        <a href="{{ route('pokemon.create') }}" class="block px-4 py-3 text-white font-bold hover:bg-red-800">Criar</a>
        <a href="{{ route('pokemons.index') }}" class="block px-4 py-3 text-white font-bold hover:bg-red-800">Meus</a>
    </div>
</nav>

<script>
    if (document.getElementById('mobileMenuBtn')) {
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    }
</script>
