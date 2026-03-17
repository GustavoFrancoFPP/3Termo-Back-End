<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                    🤝 Fornecedores
                </h2>
                <p class="text-gray-600 text-sm mt-1">Gerenciamento de parceiros</p>
            </div>
            <a href="{{ route('fornecedores.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-600 to-pink-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:from-rose-700 hover:to-pink-700 active:from-rose-800 active:to-pink-800 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Novo Fornecedor
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Mensagem de Sucesso -->
            @if (session('success'))
                <div class="mb-8 p-5 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 shadow-md rounded-r-lg animate-pulse">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($fornecedores as $fornecedor)
                    <div class="group relative overflow-hidden bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-xl hover:border-rose-300 transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Decoração de fundo -->
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-gradient-to-br from-rose-100 to-pink-100 rounded-full opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-2xl text-gray-900">{{ $fornecedor->nome }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $fornecedor->tipo ?? 'Fornecedor' }}</p>
                                </div>
                                <svg class="w-8 h-8 text-rose-500 opacity-20 group-hover:opacity-50 transition-opacity" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                            </div>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between items-start">
                                    <span class="text-gray-700 font-medium">CNPJ</span>
                                    <span class="text-gray-900 font-semibold text-right">{{ $fornecedor->cnpj ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-start">
                                    <span class="text-gray-700 font-medium">Email</span>
                                    <span class="text-gray-900 font-semibold text-right truncate text-sm">{{ $fornecedor->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-start">
                                    <span class="text-gray-700 font-medium">Telefone</span>
                                    <span class="text-gray-900 font-semibold">{{ $fornecedor->telefone ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-start">
                                    <span class="text-gray-700 font-medium">Cidade</span>
                                    <span class="text-gray-900 font-semibold">{{ $fornecedor->cidade ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                                <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold text-sm hover:from-blue-600 hover:to-blue-700 active:from-blue-700 active:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    Editar
                                </a>

                                <button onclick="window.dispatchEvent(new CustomEvent('openDeleteModal', { detail: 'delete-fornecedor-{{ $fornecedor->id }}' }))" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg font-semibold text-sm hover:from-red-600 hover:to-red-700 active:from-red-700 active:to-red-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 8.646 4 4 0 010-8.646M9 9H3v12a6 6 0 0012 0V9h-6z" /></svg>
                            <p class="text-gray-500 text-lg font-medium">Nenhum fornecedor cadastrado</p>
                            <p class="text-gray-400 text-sm mt-2">Comece adicionando seu primeiro fornecedor!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modais de Exclusão -->
    @foreach ($fornecedores as $fornecedor)
        <x-delete-modal :name="'delete-fornecedor-' . $fornecedor->id" :item-name="$fornecedor->nome" :item-type="'fornecedor'" :action="route('fornecedores.destroy', $fornecedor->id)" />
    @endforeach
</x-app-layout>