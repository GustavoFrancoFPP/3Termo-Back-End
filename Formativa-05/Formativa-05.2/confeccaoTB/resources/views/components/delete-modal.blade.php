@props([
    'name',
    'show' => false,
    'itemName' => 'este item',
    'itemType' => 'item',
    'action' => '',
])

<div
    x-data="{ open: false }"
    x-init="
        window.addEventListener('openDeleteModal', (e) => {
            if (e.detail === '{{ $name }}') {
                open = true;
            }
        });
        window.addEventListener('closeDeleteModal', (e) => {
            if (e.detail === '{{ $name }}' || e.detail === undefined) {
                open = false;
            }
        });
    "
    @keydown.escape.window="open = false"
    x-show="open"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 flex items-center justify-center"
    x-transition
>
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="open = false"></div>

    <!-- Modal -->
    <div @click.stop class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-50 animate-fade-in">
        <!-- Close Button -->
        <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Content -->
        <div class="p-6">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-8a4 4 0 110 8 4 4 0 010-8zm0-8a8 8 0 110 16 8 8 0 010-16z" />
                </svg>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-medium text-gray-900 text-center mb-2">
                Deseja excluir este {{ $itemType }}?
            </h3>

            <!-- Item Name -->
            <p class="mt-3 text-center text-gray-600">
                <span class="font-semibold text-gray-900 block text-lg break-words">{{ $itemName }}</span>
                <span class="text-sm text-gray-500 block mt-1">Esta ação não pode ser desfeita.</span>
            </p>
        </div>

        <!-- Actions -->
        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3 rounded-b-lg border-t border-gray-200">
            <form action="{{ $action }}" method="POST" class="flex-1 w-full">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Excluir
                </button>
            </form>

            <button @click="open = false" type="button" class="flex-1 w-full mt-3 sm:mt-0 inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 transition ease-in-out duration-150">
                Cancelar
            </button>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .animate-fade-in {
            animation: fadeIn 0.15s ease-in-out;
        }
        [x-cloak] { display: none; }
    </style>
</div>
<script>
    // Escape key para fechar modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            window.dispatchEvent(new CustomEvent('closeDeleteModal'));
        }
    });
</script>
