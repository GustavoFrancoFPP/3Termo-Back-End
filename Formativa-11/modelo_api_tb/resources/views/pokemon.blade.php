<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex API - Aula Pratica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .info-scroll {
            overflow-y: auto;
            max-height: 420px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #334155 #0f172a;
        }
        .info-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .info-scroll::-webkit-scrollbar-track {
            background: #0f172a;
            border-radius: 9999px;
        }
        .info-scroll::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }
        .info-scroll::-webkit-scrollbar-thumb:hover {
            background: #1e293b;
        }

        .pokemon-img {
            animation: float 4s ease-in-out infinite;
            transition: transform 0.25s ease, filter 0.25s ease;
            height: 100%;
            width: auto;
            max-width: none;
            max-height: none;
            object-fit: contain;
        }

        .pokemon-img:hover {
            transform: translateY(-6px) scale(1.05) rotate(-1deg);
            filter: drop-shadow(0 10px 20px rgba(255,255,255,0.18));
        }

        .pokemon-panel { min-width: 0; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-950 via-red-900 to-black text-white flex items-center justify-center p-6">
    @php
        $tiposPT = [
            'normal' => 'normal',
            'fire' => 'fogo',
            'water' => 'água',
            'electric' => 'elétrico',
            'grass' => 'grama',
            'ice' => 'gelo',
            'fighting' => 'lutador',
            'poison' => 'veneno',
            'ground' => 'terra',
            'flying' => 'voador',
            'psychic' => 'psíquico',
            'bug' => 'inseto',
            'rock' => 'pedra',
            'ghost' => 'fantasma',
            'dragon' => 'dragão',
            'dark' => 'noturno',
            'steel' => 'aço',
            'fairy' => 'fada',
            'unknown' => 'desconhecido',
            'shadow' => 'sombra',
        ];
    @endphp

    <div class="relative w-full max-w-6xl min-h-[680px] rounded-[3rem] bg-red-700 border-8 border-black shadow-[0_30px_90px_rgba(0,0,0,0.8)] overflow-hidden pb-6">
        <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.18),_transparent_26%)]"></div>

        <div class="absolute top-8 left-8 flex items-center gap-4">
            <div class="h-14 w-14 rounded-full bg-blue-500 border-4 border-black shadow-xl"></div>
            <div class="space-y-2">
                <div class="h-2 w-10 rounded-full bg-yellow-300"></div>
                <div class="h-2 w-8 rounded-full bg-green-300"></div>
                <div class="h-2 w-6 rounded-full bg-white"></div>
            </div>
        </div>

        <div class="absolute top-8 right-10 flex items-center gap-4">
            <div class="h-4 w-24 rounded-full bg-black"></div>
            <div class="h-9 w-9 rounded-full bg-black"></div>
        </div>

        <div class="flex h-full relative z-10 flex-wrap">
            <div class="pokemon-panel w-full lg:w-[48%] bg-red-800 border-r-8 border-black p-8 flex flex-col justify-between min-w-0">
                <div>
                    <div class="relative rounded-[2rem] border-8 border-black bg-black p-5 shadow-[inset_0_0_0_8px_rgba(255,255,255,0.06)]">
                        <div class="absolute top-4 left-4 h-6 w-20 rounded-full bg-red-600"></div>
                        <div class="h-[320px] max-w-full w-full bg-slate-950 rounded-[2rem] overflow-hidden flex items-center justify-center mt-6">
                            <img id="pokemon-image" src="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] }}" alt="{{ $pokemon['name'] }}" class="pokemon-img" />
                        </div>
                    </div>

                    <div class="mt-8 rounded-[1.75rem] bg-black/80 border border-black p-4">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-slate-400 mb-4">Variações</p>
                        <div id="variation-gallery" class="flex gap-3 overflow-x-auto pb-2"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-[1.75rem] bg-black/80 border border-black p-4">
                        <div class="h-12 rounded-2xl bg-slate-900"></div>
                    </div>
                    <div class="rounded-[1.75rem] bg-black/80 border border-black p-4">
                        <div class="h-12 rounded-2xl bg-slate-900"></div>
                    </div>
                </div>
            </div>

            <div class="pokemon-panel w-full lg:w-[52%] p-8 flex flex-col justify-between gap-6 h-full min-w-0">
                <div class="rounded-[2rem] bg-black border-8 border-black/80 p-6 shadow-[inset_0_0_0_6px_rgba(255,255,255,0.06)] flex-1 overflow-hidden">
                    <div id="info-container" class="rounded-[1.5rem] bg-slate-950 p-6 text-slate-200 info-scroll pr-3">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-red-400">pokedex</p>
                        <div class="mt-4 space-y-3 text-sm leading-6">
                            <p class="whitespace-nowrap"><span class="text-green-400">Nº:</span> <span class="text-white">{{ $pokemon['id'] }}</span></p>
                            <p class="whitespace-nowrap"><span class="text-green-400">NOME:</span> <span class="text-white uppercase">{{ $pokemon['name'] }}</span></p>
                            <p class="whitespace-nowrap"><span class="text-green-400">TIPO:</span>
                                <span class="text-white uppercase">
                                    @foreach ($pokemon['types'] as $tipo)
                                        @php
                                            $tipoPT = $tiposPT[$tipo['type']['name']] ?? $tipo['type']['name'];
                                        @endphp
                                        {{ $tipoPT }}@if (! $loop->last)/@endif
                                    @endforeach
                                </span>
                            </p>
                            <p class="whitespace-nowrap"><span class="text-green-400">ALTURA:</span> <span class="text-white">{{ $pokemon['height'] / 10 }} m</span></p>
                            <p class="whitespace-nowrap"><span class="text-green-400">PESO:</span> <span class="text-white">{{ $pokemon['weight'] / 10 }} kg</span></p>
                            <div class="rounded-[1.5rem] bg-black/80 border border-black p-4 mt-4">
                                <p class="text-[10px] uppercase tracking-[0.35em] text-red-400">habilidades</p>
                                <ul class="mt-3 space-y-2 text-sm text-white uppercase whitespace-nowrap">
                                    @foreach ($pokemon['abilities'] as $habilidade)
                                        <li>{{ $habilidade['ability']['name'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="rounded-[1.5rem] bg-black/80 border border-black p-4 mt-4">
                                <p class="text-[10px] uppercase tracking-[0.35em] text-red-400">estatísticas</p>
                                <div class="mt-3 space-y-2 text-sm text-white whitespace-nowrap">
                                    @foreach ($pokemon['stats'] as $stat)
                                        <p><span class="text-green-400 uppercase">{{ $stat['stat']['name'] }}:</span> {{ $stat['base_stat'] }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    @foreach (range(1, 6) as $i)
                        <div class="h-20 rounded-3xl bg-blue-600 border-4 border-black shadow-[0_10px_0_rgba(0,0,0,0.2)]"></div>
                    @endforeach
                </div>

                <div class="grid grid-cols-4 gap-3">
                    <div class="col-span-2 h-16 rounded-[1.5rem] bg-white"></div>
                    <div class="h-16 rounded-[1.5rem] bg-black"></div>
                    <div class="h-16 rounded-[1.5rem] bg-black"></div>
                </div>

                <div class="rounded-[1.75rem] bg-black/70 border border-black p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <input id="pokemon-search" type="text" placeholder="Buscar Pokémon por nome ou ID" class="flex-1 rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20" />
                        <button id="pokemon-search-btn" type="button" class="rounded-3xl bg-red-500 px-6 py-3 text-sm font-bold uppercase tracking-[0.15em] text-white transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Buscar
                        </button>
                    </div>
                    <div class="mt-4 text-center">
                        <button id="next-btn" type="button" class="w-full rounded-3xl bg-red-500 px-6 py-3 text-sm font-bold uppercase tracking-[0.15em] text-white transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Buscar próximo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const tiposPT = {
            normal: 'normal', fire: 'fogo', water: 'água', electric: 'elétrico',
            grass: 'grama', ice: 'gelo', fighting: 'lutador', poison: 'veneno',
            ground: 'terra', flying: 'voador', psychic: 'psíquico', bug: 'inseto',
            rock: 'pedra', ghost: 'fantasma', dragon: 'dragão', dark: 'noturno',
            steel: 'aço', fairy: 'fada', unknown: 'desconhecido', shadow: 'sombra'
        };

        const nextBtn = document.getElementById('next-btn');
        const searchInput = document.getElementById('pokemon-search');
        const searchBtn = document.getElementById('pokemon-search-btn');
        const infoContainer = document.getElementById('info-container');
        const pokemonImage = document.getElementById('pokemon-image');
        const initialPokemon = @json($pokemon);
        let currentPokemonId = {{ $pokemon['id'] }};

        function formatName(name) {
            return name.replace('-', ' ').toUpperCase();
        }

        function getSpriteVariations(pokemon) {
            const sprites = [];
            const artwork = pokemon.sprites.other?.['official-artwork']?.front_default;
            const defaultFront = pokemon.sprites.front_default;
            const defaultBack = pokemon.sprites.back_default;
            const shinyFront = pokemon.sprites.front_shiny;
            const shinyBack = pokemon.sprites.back_shiny;

            if (artwork) sprites.push({ src: artwork, label: 'Oficial' });
            if (defaultFront) sprites.push({ src: defaultFront, label: 'Frente' });
            if (defaultBack) sprites.push({ src: defaultBack, label: 'Costas' });
            if (shinyFront) sprites.push({ src: shinyFront, label: 'Frente Shiny' });
            if (shinyBack) sprites.push({ src: shinyBack, label: 'Costas Shiny' });

            return sprites;
        }

        function renderVariationGallery(pokemon) {
            const gallery = document.getElementById('variation-gallery');
            if (!gallery) return;

            const sprites = getSpriteVariations(pokemon);
            gallery.innerHTML = sprites.map(sprite => `
                <button type="button" class="rounded-[1.5rem] border border-slate-700 bg-slate-950 p-2 transition hover:border-red-500 focus:outline-none" data-src="${sprite.src}">
                    <img src="${sprite.src}" alt="${sprite.label}" class="h-20 w-full object-contain" />
                    <span class="mt-2 block text-[10px] uppercase tracking-[0.35em] text-slate-400 text-center">${sprite.label}</span>
                </button>
            `).join('');

            const buttons = gallery.querySelectorAll('button');
            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const src = btn.dataset.src;
                    if (src) {
                        pokemonImage.src = src;
                    }
                });
            });
        }

        function buildInfoHtml(pokemon) {
            const tiposTraduzidos = pokemon.types.map(t => tiposPT[t.type.name] || t.type.name).join(' / ');
            const habilidades = pokemon.abilities.map(h => `<li class="text-white uppercase">${formatName(h.ability.name)}</li>`).join('');
            const statsNames = {
                'hp': 'HP', 'attack': 'ATK', 'defense': 'DEF',
                'special-attack': 'Sp.Atk', 'special-defense': 'Sp.Def', 'speed': 'SPD'
            };
            const stats = pokemon.stats.map(s => `<p><span class="text-green-400 uppercase">${statsNames[s.stat.name] || s.stat.name}:</span> <span class="text-white">${s.base_stat}</span></p>`).join('');

            return `
                <p class="text-[10px] uppercase tracking-[0.35em] text-red-400">pokedex</p>
                <div class="mt-4 space-y-3 text-sm leading-6">
                    <p class="whitespace-nowrap"><span class="text-green-400">Nº:</span> <span class="text-white">${pokemon.id}</span></p>
                    <p class="whitespace-nowrap"><span class="text-green-400">NOME:</span> <span class="text-white uppercase">${pokemon.name}</span></p>
                    <p class="whitespace-nowrap"><span class="text-green-400">TIPO:</span> <span class="text-white uppercase">${tiposTraduzidos}</span></p>
                    <p class="whitespace-nowrap"><span class="text-green-400">ALTURA:</span> <span class="text-white">${(pokemon.height / 10).toFixed(1)} m</span></p>
                    <p class="whitespace-nowrap"><span class="text-green-400">PESO:</span> <span class="text-white">${(pokemon.weight / 10).toFixed(1)} kg</span></p>
                    <div class="rounded-[1.5rem] bg-black/80 border border-black p-4 mt-4">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-red-400">habilidades</p>
                        <ul class="mt-3 space-y-2 text-sm text-white uppercase">${habilidades}</ul>
                    </div>
                    <div class="rounded-[1.5rem] bg-black/80 border border-black p-4 mt-4">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-red-400">estatísticas</p>
                        <div class="mt-3 space-y-2 text-sm text-white whitespace-nowrap">${stats}</div>
                    </div>
                </div>
            `;
        }

        function getRandomPokemonId() {
            const maxPokemonId = 1025;
            let randomId;
            do {
                randomId = Math.floor(Math.random() * maxPokemonId) + 1;
            } while (randomId === currentPokemonId);
            return randomId;
        }

        function setPokemonLoading(isLoading) {
            nextBtn.disabled = isLoading;
            searchBtn.disabled = isLoading;
            if (isLoading) {
                nextBtn.textContent = 'Carregando...';
                searchBtn.textContent = 'Buscando...';
            } else {
                nextBtn.textContent = 'Buscar próximo';
                searchBtn.textContent = 'Buscar';
            }
        }

        async function loadPokemonData(pokemon) {
            const officialArtwork = pokemon.sprites.other?.['official-artwork']?.front_default;
            pokemonImage.src = officialArtwork || pokemon.sprites.front_default;
            pokemonImage.alt = pokemon.name;
            renderVariationGallery(pokemon);
            infoContainer.innerHTML = buildInfoHtml(pokemon);
        }

        async function fetchPokemonByTerm(term) {
            const query = term?.trim();
            if (!query) {
                await fetchNextPokemon();
                return;
            }

            const normalizedTerm = query.toLowerCase();
            setPokemonLoading(true);
            try {
                const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${encodeURIComponent(normalizedTerm)}`);
                if (!response.ok) throw new Error('Pokémon não encontrado');
                const pokemon = await response.json();
                currentPokemonId = pokemon.id;
                await loadPokemonData(pokemon);
            } catch (error) {
                infoContainer.innerHTML = `<div class="text-red-400">Pokémon não encontrado. Verifique o nome ou ID.</div>`;
                console.error(error);
            } finally {
                setPokemonLoading(false);
            }
        }

        async function fetchNextPokemon() {
            const nextPokemonId = getRandomPokemonId();
            setPokemonLoading(true);
            try {
                const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${nextPokemonId}`);
                if (!response.ok) throw new Error('Erro na API');
                const pokemon = await response.json();
                currentPokemonId = pokemon.id;
                await loadPokemonData(pokemon);
            } catch (error) {
                infoContainer.innerHTML = `<div class="text-red-400">Erro ao carregar Pokémon. Tente novamente.</div>`;
                console.error(error);
            } finally {
                setPokemonLoading(false);
            }
        }

        if (initialPokemon) {
            renderVariationGallery(initialPokemon);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', fetchNextPokemon);
        }

        if (searchBtn) {
            searchBtn.addEventListener('click', () => {
                fetchPokemonByTerm(searchInput.value);
            });
        }

        if (searchInput) {
            searchInput.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    fetchPokemonByTerm(searchInput.value);
                }
            });
        }
    </script>
</body>
</html>
