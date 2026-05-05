<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Novo Pokemon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    @include('components.navbar')
    
    <div class="min-h-screen p-8">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('pokemons.index') }}" class="text-red-500 hover:text-red-400 mb-6 inline-block">← Voltar</a>
            
            <div class="bg-gray-800 rounded-lg p-8">
                <h1 class="text-3xl font-bold mb-2">Criar Novo Pokemon</h1>
                <p class="text-gray-400 mb-8">Preencha os dados do seu novo pokemon personalizado</p>

                @if($errors->any())
                    <div class="bg-red-600 border border-red-700 rounded-lg p-4 mb-6">
                        <p class="font-semibold mb-2">Erros ao criar pokemon:</p>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pokemon.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- ID Automático -->
                    <div class="bg-gradient-to-r from-red-600 to-red-700 p-6 rounded-lg">
                        <p class="text-gray-200 text-sm font-semibold mb-1">ID Automático (Próximo Disponível)</p>
                        <p class="text-4xl font-bold">#{{ $nextId }}</p>
                        <input type="hidden" name="pokemon_id" value="{{ $nextId }}">
                    </div>

                    <!-- Nome -->
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-2">Nome do Pokemon *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500 @error('name') border-red-500 @enderror"
                            placeholder="Ex: Meu Pokemon Especial"
                            value="{{ old('name') }}"
                        >
                    </div>

                    <!-- Tipo - Múltiplo -->
                    <div>
                        <label for="types" class="block text-sm font-semibold mb-2">Tipo(s) do Pokemon * (Selecione um ou mais)</label>
                        <select 
                            id="types" 
                            name="types[]" 
                            multiple
                            required
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-red-500 @error('types') border-red-500 @enderror"
                        >
                            @foreach($types as $type)
                                <option value="{{ $type }}" @if(in_array($type, old('types', []))) selected @endif>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-gray-400 text-xs mt-1">Segure Ctrl (ou Cmd no Mac) para selecionar múltiplos tipos</p>
                    </div>

                    <!-- Altura e Peso -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="height" class="block text-sm font-semibold mb-2">Altura (metros) *</label>
                            <input 
                                type="number" 
                                id="height" 
                                name="height" 
                                step="0.1"
                                required
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500 @error('height') border-red-500 @enderror"
                                placeholder="Ex: 1.7"
                                value="{{ old('height') }}"
                            >
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-semibold mb-2">Peso (kg) *</label>
                            <input 
                                type="number" 
                                id="weight" 
                                name="weight" 
                                step="0.1"
                                required
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500 @error('weight') border-red-500 @enderror"
                                placeholder="Ex: 90.5"
                                value="{{ old('weight') }}"
                            >
                        </div>
                    </div>

                    <!-- Habilidades -->
                    <div class="border-t border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Habilidades</h3>
                        <div id="abilities-container" class="space-y-3">
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    name="abilities[]" 
                                    placeholder="Ex: good-as-gold"
                                    class="flex-1 px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500"
                                    value="{{ old('abilities.0', '') }}"
                                >
                                <button type="button" onclick="addAbility()" class="bg-green-600 hover:bg-green-700 px-4 py-3 rounded-lg font-semibold transition">
                                    + Adicionar
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-400 text-xs mt-2">Você pode adicionar múltiplas habilidades</p>
                    </div>

                    <!-- Status/Stats -->
                    <div class="border-t border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Status do Pokemon</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="stat_hp" class="block text-sm font-semibold mb-2">HP</label>
                                <input 
                                    type="number" 
                                    id="stat_hp" 
                                    name="stats[hp]" 
                                    min="0"
                                    max="255"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500"
                                    placeholder="Ex: 87"
                                    value="{{ old('stats.hp', '') }}"
                                >
                            </div>
                            <div>
                                <label for="stat_attack" class="block text-sm font-semibold mb-2">Ataque</label>
                                <input 
                                    type="number" 
                                    id="stat_attack" 
                                    name="stats[attack]" 
                                    min="0"
                                    max="255"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500"
                                    placeholder="Ex: 60"
                                    value="{{ old('stats.attack', '') }}"
                                >
                            </div>
                            <div>
                                <label for="stat_defense" class="block text-sm font-semibold mb-2">Defesa</label>
                                <input 
                                    type="number" 
                                    id="stat_defense" 
                                    name="stats[defense]" 
                                    min="0"
                                    max="255"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500"
                                    placeholder="Ex: 95"
                                    value="{{ old('stats.defense', '') }}"
                                >
                            </div>
                            <div>
                                <label for="stat_spdef" class="block text-sm font-semibold mb-2">Def. Especial</label>
                                <input 
                                    type="number" 
                                    id="stat_spdef" 
                                    name="stats[special-defense]" 
                                    min="0"
                                    max="255"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500"
                                    placeholder="Ex: 91"
                                    value="{{ old('stats.special-defense', '') }}"
                                >
                            </div>
                            <div>
                                <label for="stat_spatk" class="block text-sm font-semibold mb-2">At. Especial</label>
                                <input 
                                    type="number" 
                                    id="stat_spatk" 
                                    name="stats[special-attack]" 
                                    min="0"
                                    max="255"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500"
                                    placeholder="Ex: 133"
                                    value="{{ old('stats.special-attack', '') }}"
                                >
                            </div>
                            <div>
                                <label for="stat_speed" class="block text-sm font-semibold mb-2">Velocidade</label>
                                <input 
                                    type="number" 
                                    id="stat_speed" 
                                    name="stats[speed]" 
                                    min="0"
                                    max="255"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500"
                                    placeholder="Ex: 84"
                                    value="{{ old('stats.speed', '') }}"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Upload de Imagem -->
                    <div class="border-t border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Imagem do Pokemon</h3>
                        
                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-8 text-center hover:border-red-500 transition">
                            <input 
                                type="file" 
                                id="image" 
                                name="image"
                                accept="image/*"
                                class="hidden"
                                onchange="previewImage(event)"
                            >
                            
                            <div id="uploadPrompt" class="cursor-pointer">
                                <p class="text-4xl mb-2">📸</p>
                                <p class="text-white font-semibold mb-1">Clique ou arraste uma imagem</p>
                                <p class="text-gray-400 text-sm">PNG, JPG, GIF até 2MB</p>
                                <button type="button" onclick="document.getElementById('image').click()" class="mt-4 bg-red-600 hover:bg-red-700 px-6 py-2 rounded-lg font-semibold transition">
                                    Escolher Arquivo
                                </button>
                            </div>

                            <div id="imagePreview" class="hidden">
                                <img id="previewImg" src="" alt="Preview" class="max-h-64 mx-auto mb-4 rounded">
                                <button type="button" onclick="clearImage()" class="bg-gray-700 hover:bg-gray-600 px-6 py-2 rounded-lg font-semibold transition">
                                    Mudar Imagem
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-400 text-xs mt-2">Opcional - Se não enviar, será usado um ícone padrão</p>
                    </div>

                    <!-- Botões -->
                    <div class="flex gap-4 pt-4 border-t border-gray-700">
                        <button 
                            type="submit" 
                            class="flex-1 bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg font-semibold text-lg transition"
                        >
                            ✅ Salvar Pokemon #{{ $nextId }}
                        </button>
                        <a 
                            href="{{ route('pokemons.index') }}" 
                            class="flex-1 bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-lg font-semibold text-lg text-center transition"
                        >
                            ❌ Cancelar
                        </a>
                    </div>
                </form>

                <div class="mt-8 p-4 bg-gray-900 rounded-lg border border-gray-700">
                    <p class="text-gray-400 text-sm">
                        <strong>💡 Dica:</strong> Campos marcados com * são obrigatórios. Você pode selecionar múltiplos tipos de pokemon. A imagem é opcional.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('uploadPrompt').classList.add('hidden');
                    document.getElementById('imagePreview').classList.remove('hidden');
                    document.getElementById('previewImg').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function clearImage() {
            document.getElementById('image').value = '';
            document.getElementById('uploadPrompt').classList.remove('hidden');
            document.getElementById('imagePreview').classList.add('hidden');
        }

        function addAbility() {
            const container = document.getElementById('abilities-container');
            const newAbility = document.createElement('div');
            newAbility.className = 'flex gap-2';
            newAbility.innerHTML = `
                <input 
                    type="text" 
                    name="abilities[]" 
                    placeholder="Ex: good-as-gold"
                    class="flex-1 px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500"
                >
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-600 hover:bg-red-700 px-4 py-3 rounded-lg font-semibold transition">
                    - Remover
                </button>
            `;
            container.appendChild(newAbility);
        }

        // Drag and drop
        const dropZone = document.querySelector('div.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.style.borderColor = '#dc2626';
            dropZone.style.backgroundColor = 'rgba(220, 38, 38, 0.1)';
        }

        function unhighlight(e) {
            dropZone.style.borderColor = '#4b5563';
            dropZone.style.backgroundColor = 'transparent';
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('image').files = files;
            
            const event = { target: { files: files } };
            previewImage(event);
        }
    </script>
</body>
</html>
