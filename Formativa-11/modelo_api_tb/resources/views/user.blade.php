<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .info-scroll {
            overflow-y: auto;
            max-height: 560px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #38bdf8 #0f172a;
        }
        .info-scroll::-webkit-scrollbar { width: 8px; }
        .info-scroll::-webkit-scrollbar-track { background: #0f172a; border-radius: 9999px; }
        .info-scroll::-webkit-scrollbar-thumb { background: #475569; border-radius: 9999px; }
        .info-scroll::-webkit-scrollbar-thumb:hover { background: #334155; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-sky-950 text-slate-100">
    <div class="mx-auto max-w-6xl px-4 py-10">
        <div class="rounded-[2rem] border border-slate-800 bg-slate-900/95 shadow-2xl shadow-slate-950/60 overflow-hidden">
            <div class="grid gap-6 lg:grid-cols-[360px_minmax(0,1fr)]">
                <section class="bg-slate-950/80 p-8 border-r border-slate-800">
                    <div class="space-y-6">
                        <div class="rounded-[2rem] border border-slate-800 bg-slate-900 p-5">
                            <div class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-cyan-500 to-sky-700 p-4">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.25),_transparent_40%)]"></div>
                                <img id="user-image" src="{{ $user['image'] ?? 'https://via.placeholder.com/360x360' }}" alt="{{ $user['firstName'] ?? 'Usuário' }}" class="relative mx-auto h-72 w-72 rounded-[1.5rem] object-cover border-4 border-white/10 shadow-xl" />
                            </div>
                        </div>

                        <div class="rounded-[2rem] border border-slate-800 bg-slate-950 p-6">
                            <p class="text-xs uppercase tracking-[0.35em] text-cyan-300">Informações rápidas</p>
                            <div class="mt-4 grid gap-4 text-sm">
                                <div class="rounded-3xl bg-slate-900 p-4">
                                    <p class="text-slate-400 text-[10px] uppercase tracking-[0.35em]">ID do usuário</p>
                                    <p id="user-id" class="mt-2 text-lg font-semibold text-white">{{ $user['id'] }}</p>
                                </div>
                                <div class="rounded-3xl bg-slate-900 p-4">
                                    <p class="text-slate-400 text-[10px] uppercase tracking-[0.35em]">Contato</p>
                                    <p id="user-email" class="mt-2 text-white">{{ $user['email'] }}</p>
                                </div>
                                <div class="rounded-3xl bg-slate-900 p-4">
                                    <p class="text-slate-400 text-[10px] uppercase tracking-[0.35em]">Telefone</p>
                                    <p id="user-phone" class="mt-2 text-white">{{ $user['phone'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="p-8">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.35em] text-cyan-300">Perfil de usuário</p>
                            <h1 id="user-fullname" class="mt-3 text-3xl font-bold text-white">{{ ucfirst($user['firstName'] . ' ' . $user['lastName']) }}</h1>
                            <p id="user-username" class="mt-2 text-sm text-slate-400">@{{ $user['username'] }}</p>
                        </div>

                        <div class="rounded-3xl border border-cyan-500/20 bg-cyan-500/10 px-4 py-3 text-sm font-semibold text-cyan-100">
                            Dados do perfil
                        </div>
                    </div>

                    <div class="mt-8 rounded-[2rem] border border-slate-800 bg-slate-950 p-6 shadow-[0_20px_60px_rgba(15,23,42,0.35)]">
                        <div id="info-container" class="space-y-6 info-scroll pr-3">
                            @if(isset($error))
                                <div class="rounded-3xl bg-red-600/10 border border-red-500/20 p-6 text-red-200">
                                    {{ $error }}
                                </div>
                            @else
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="rounded-3xl bg-slate-900 p-5">
                                        <p class="text-[10px] uppercase tracking-[0.35em] text-slate-500">Dados pessoais</p>
                                        <div class="mt-4 space-y-3 text-sm text-slate-100">
                                            <p><span class="font-semibold text-white">Nome completo:</span> {{ ucfirst($user['firstName'] . ' ' . $user['lastName']) }}</p>
                                            <p><span class="font-semibold text-white">Usuário:</span> {{ $user['username'] }}</p>
                                            <p><span class="font-semibold text-white">Idade:</span> {{ $user['age'] }} anos</p>
                                            <p><span class="font-semibold text-white">Gênero:</span> {{ ucfirst($user['gender']) }}</p>
                                        </div>
                                    </div>
                                    <div class="rounded-3xl bg-slate-900 p-5">
                                        <p class="text-[10px] uppercase tracking-[0.35em] text-slate-500">Empresa</p>
                                        <div class="mt-4 space-y-3 text-sm text-slate-100">
                                            <p><span class="font-semibold text-white">Nome:</span> {{ $user['company']['name'] ?? 'N/A' }}</p>
                                            <p><span class="font-semibold text-white">Cargo:</span> {{ $user['company']['title'] ?? 'Título desconhecido' }}</p>
                                            <p><span class="font-semibold text-white">Área:</span> {{ $user['company']['department'] ?? 'N/D' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-3xl bg-slate-900 p-5">
                                    <p class="text-[10px] uppercase tracking-[0.35em] text-slate-500">Endereço</p>
                                    <div class="mt-4 space-y-2 text-sm text-slate-100">
                                        <p>{{ $user['address']['address'] ?? 'Endereço não disponível' }}</p>
                                        <p>{{ $user['address']['city'] ?? '' }}{{ $user['address']['state'] ? ' - ' . $user['address']['state'] : '' }}</p>
                                        <p>{{ $user['address']['postalCode'] ?? '' }}{{ $user['address']['country'] ? ', ' . $user['address']['country'] : '' }}</p>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:flex-1">
                            <input id="user-search" type="text" placeholder="Buscar usuário por nome, username ou ID" class="w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20" />
                            <button id="search-btn" type="button" class="inline-flex items-center justify-center rounded-3xl bg-cyan-500 px-6 py-3 text-sm font-bold uppercase tracking-[0.15em] text-slate-950 transition hover:bg-cyan-400 focus:outline-none focus:ring-4 focus:ring-cyan-300/30">
                                Buscar
                            </button>
                        </div>
                        <button id="next-btn" type="button" class="inline-flex items-center justify-center rounded-3xl bg-cyan-500 px-6 py-3 text-sm font-bold uppercase tracking-[0.15em] text-slate-950 transition hover:bg-cyan-400 focus:outline-none focus:ring-4 focus:ring-cyan-300/30">
                            Buscar próximo
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        const userApiUrl = "{{ url('user') }}";
        const nextBtn = document.getElementById('next-btn');
        const searchInput = document.getElementById('user-search');
        const searchBtn = document.getElementById('search-btn');
        const userImage = document.getElementById('user-image');
        const userFullname = document.getElementById('user-fullname');
        const userUsername = document.getElementById('user-username');
        const userEmail = document.getElementById('user-email');
        const userPhone = document.getElementById('user-phone');
        const userId = document.getElementById('user-id');
        const infoContainer = document.getElementById('info-container');
        let currentUserId = {{ $user['id'] ?? 1 }};

        function buildUserHtml(user) {
            return `
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-slate-900 p-5">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-slate-500">Dados pessoais</p>
                        <div class="mt-4 space-y-3 text-sm text-slate-100">
                            <p><span class="font-semibold text-white">Nome completo:</span> ${user.firstName} ${user.lastName}</p>
                            <p><span class="font-semibold text-white">Usuário:</span> ${user.username}</p>
                            <p><span class="font-semibold text-white">Idade:</span> ${user.age} anos</p>
                            <p><span class="font-semibold text-white">Gênero:</span> ${user.gender}</p>
                        </div>
                    </div>
                    <div class="rounded-3xl bg-slate-900 p-5">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-slate-500">Empresa</p>
                        <div class="mt-4 space-y-3 text-sm text-slate-100">
                            <p><span class="font-semibold text-white">Nome:</span> ${user.company?.name || 'N/A'}</p>
                            <p><span class="font-semibold text-white">Cargo:</span> ${user.company?.title || 'Título desconhecido'}</p>
                            <p><span class="font-semibold text-white">Área:</span> ${user.company?.department || 'N/D'}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-slate-900 p-5">
                    <p class="text-[10px] uppercase tracking-[0.35em] text-slate-500">Endereço</p>
                    <div class="mt-4 space-y-2 text-sm text-slate-100">
                        <p>${user.address?.address || 'Endereço não disponível'}</p>
                        <p>${user.address?.city || ''}${user.address?.state ? ' - ' + user.address?.state : ''}</p>
                        <p>${user.address?.postalCode || ''}${user.address?.country ? ', ' + user.address?.country : ''}</p>
                    </div>
                </div>

            `;
        }

        function setUserLoading(isLoading) {
            nextBtn.disabled = isLoading;
            if (searchBtn) searchBtn.disabled = isLoading;
            if (searchInput) searchInput.disabled = isLoading;
            if (isLoading) {
                nextBtn.textContent = 'Carregando...';
                if (searchBtn) searchBtn.textContent = 'Buscando...';
            } else {
                nextBtn.textContent = 'Buscar próximo';
                if (searchBtn) searchBtn.textContent = 'Buscar';
            }
        }

        function displayUser(user) {
            userImage.src = user.image || 'https://via.placeholder.com/360x360';
            userImage.alt = `${user.firstName} ${user.lastName}`;
            userFullname.textContent = `${user.firstName} ${user.lastName}`;
            userUsername.textContent = `@${user.username}`;
            userEmail.textContent = user.email;
            userPhone.textContent = user.phone;
            userId.textContent = user.id;
            infoContainer.innerHTML = buildUserHtml(user);
        }

        async function fetchUserBySearch(term) {
            const query = term?.trim();
            if (!query) {
                await fetchNextUser();
                return;
            }

            setUserLoading(true);
            try {
                let url;
                if (/^\d+$/.test(query)) {
                    url = `${userApiUrl}/${query}`;
                } else {
                    url = `${userApiUrl}/search?q=${encodeURIComponent(query)}`;
                }

                const response = await fetch(url);
                if (!response.ok) throw new Error('Usuário não encontrado');
                const user = await response.json();
                currentUserId = user.id;
                displayUser(user);
            } catch (error) {
                infoContainer.innerHTML = `
                    <div class="rounded-3xl bg-red-600/10 border border-red-500/20 p-6 text-red-200">
                        Usuário não encontrado. Verifique o termo pesquisado.
                    </div>
                `;
                console.error(error);
            } finally {
                setUserLoading(false);
            }
        }

        function getRandomUserId() {
            let randomId;
            do {
                randomId = Math.floor(Math.random() * 100) + 1;
            } while (randomId === currentUserId);
            return randomId;
        }

        async function fetchNextUser() {
            currentUserId = getRandomUserId();
            await fetchUserBySearch(String(currentUserId));
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', fetchNextUser);
        }

        if (searchBtn) {
            searchBtn.addEventListener('click', () => {
                fetchUserBySearch(searchInput.value);
            });
        }

        if (searchInput) {
            searchInput.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    fetchUserBySearch(searchInput.value);
                }
            });
        }
    </script>
</body>
</html>
