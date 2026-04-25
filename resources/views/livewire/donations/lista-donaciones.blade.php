<div class="w-full pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Header Hero -->
    <div class="mb-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="flex-1">
            <h1 class="text-hero mb-3 animate-fade-in text-black!">🎁 Donaciones Disponibles</h1>
            <p class="text-subtitle text-zinc-700! dark:text-zinc-700! max-w-2xl">
                Descubre las donaciones increíbles de tu comunidad. Cada artículo es una oportunidad para cambiar una vida.
            </p>
        </div>
        <div class="shrink-0">
            <livewire:donations.crear-donacion />
        </div>
    </div>

    <!-- Buscador y Filtros Mejorados -->
    <div class="card-glass-lg mb-12 sticky top-16 z-40 md:static">
        <div class="space-y-6">
            <!-- Búsqueda -->
            <div>
                <label class="block text-sm font-semibold dark:text-black mb-3">🔍 Buscar</label>
                <input 
                    type="text" 
                    wire:model.live="searchTerm"
                    placeholder="Escribe parte del título o descripción..." 
                    class="w-full px-4 py-3 bg-white dark:bg-white border border-red-300 dark:border-red-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 dark:text-zinc-900 text-base transition-all"
                >
            </div>

            <!-- Filtros en dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Filtro por tipo -->
                <div>
                    <label class="block text-sm font-semibold dark:text-black mb-3">📦 Tipo de Donación</label>
                    <div class="flex flex-wrap gap-2">
                        <button 
                            wire:click="updateFilter('')" 
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $filterType === '' ? 'btn-primary' : 'bg-white dark:bg-white text-zinc-900 border-2 border-red-300 dark:border-red-300 hover:bg-red-50 dark:hover:bg-red-50' }}"
                        >
                            Todos
                        </button>
                        @foreach ($tipos as $tipo)
                            <button 
                                wire:click="updateFilter('{{ $tipo }}')" 
                                class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $filterType === $tipo ? 'btn-secondary' : 'bg-white dark:bg-white text-zinc-900 border-2 border-green-300 dark:border-green-300 hover:bg-green-50 dark:hover:bg-green-50' }}"
                            >
                                {{ match($tipo) { 'comida' => '🍎 Comida', 'ropa' => '👕 Ropa', 'utiles' => '✏️ Útiles', 'otro' => '📦 Otro', default => ucfirst($tipo) } }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Ordenamiento -->
                <div>
                    <label class="block text-sm font-semibold dark:text-black mb-3">📊 Ordenar por</label>
                    <select 
                        wire:model.live="sortBy" 
                        class="w-full px-4 py-2 bg-white dark:bg-white border border-yellow-300 dark:border-yellow-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:text-zinc-900 text-base transition-all"
                    >
                        <option value="recent">⏱️ Más Recientes</option>
                        <option value="oldest">📅 Más Antiguos</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de Donaciones -->
    @if ($donations->isEmpty())
        <div class="card-glass-lg text-center">
            <div class="text-6xl mb-6 filter opacity-50">🔍</div>
            <h3 class="text-section mb-2">No hay donaciones disponibles</h3>
            <p class="text-body text-zinc-600 dark:text-zinc-400 mb-8 max-w-md mx-auto">
                Parece que no hay donaciones con esos filtros. Intenta cambiar la búsqueda o vuelve luego.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach ($donations as $donation)
                <div class="group h-full card-glass rounded-2xl overflow-hidden animate-scale-in transition-all duration-500"
                     style="animation-delay: {{ $loop->index * 0.05 }}s">
                    
                    <!-- Header con gradiente -->
                    <div class="relative overflow-hidden bg-gradient-to-br from-red-500/90 via-yellow-400/80 to-green-500/90 dark:from-red-600/70 dark:via-yellow-500/60 dark:to-green-600/70 px-6 py-6 pb-8">
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-10 bg-white transition-opacity duration-300"></div>
                        
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-white leading-tight mb-2 line-clamp-2">
                                        {{ $donation->titulo }}
                                    </h3>
                                    <p class="text-white/90 text-sm font-medium">
                                        De: <span class="font-semibold">{{ $donation->user->name }}</span>
                                    </p>
                                </div>
                                
                                <!-- Tipo badge -->
                                <div class="shrink-0 ml-3">
                                    <div class="bg-white/20 dark:bg-zinc-800/30 backdrop-blur px-3 py-1 rounded-full">
                                        <span class="text-white font-bold text-xs uppercase tracking-wider">
                                            {{ match($donation->tipo) { 'comida' => '🍎', 'ropa' => '👕', 'utiles' => '✏️', default => '📦' } }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Mini descripción -->
                            <p class="text-white/80 text-xs leading-relaxed line-clamp-2 break-words">
                                {{ Str::limit($donation->descripcion, 60, '...') }}
                            </p>
                        </div>
                    </div>

                    <!-- Contenido principal -->
                    <div class="p-6 flex-1 flex flex-col">
                        <!-- Descripción limitada -->
                        <p class="text-body dark:text-black! mb-5 flex-1 line-clamp-3 break-words overflow-hidden">
                            {{ Str::limit($donation->descripcion, 150, '...') }}
                        </p>

                        <!-- Meta información -->
                        <div class="grid grid-cols-2 gap-4 mb-5 pb-5 border-b border-zinc-200 dark:border-zinc-700">
                            <div>
                                <p class="text-xs font-semibold text-zinc-500 dark:text-black uppercase mb-1">Publicado</p>
                                <p class="text-sm text-zinc-700 dark:text-black font-medium">
                                    {{ $donation->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-500 dark:text-black uppercase mb-1">Solicitudes</p>
                                <p class="text-sm text-zinc-700 dark:text-black font-medium">
                                    {{ $donation->requests->count() }} 👥
                                </p>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="mb-6">
                            @if ($donation->estado === 'disponible')
                                <span class="badge-success text-black!">✨ Disponible Ahora</span>
                            @elseif ($donation->estado === 'en_proceso')
                                <span class="badge-warning text-black!">⏳ En Proceso</span>
                            @else
                                <span class="badge-danger text-black!">📦 Entregada</span>
                            @endif
                        </div>

                        <!-- Botones acción -->
                        <div class="flex gap-2">
                            <button 
                                wire:click="$dispatch('openDonation', { donationId: {{ $donation->id }} })"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold text-sm transition"
                            >
                                👁️ Ver Donación
                            </button>
                            <div class="flex-1">
                                @if (auth()->check())
                                    @if ($donation->user_id === auth()->id())
                                        <div class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 rounded-lg text-center">
                                            <p class="text-xs font-semibold text-zinc-600 dark:text-white">✓ Es tu Donación</p>
                                        </div>
                                    @else
                                        <livewire:donations.solicitar-donacion :donation="$donation" :key="'solicitar-' . $donation->id . '-' . time()" />
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="block px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold text-center text-sm transition">
                                        Iniciar Sesión
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        @if ($donations->hasPages())
            <div class="flex justify-center mb-8">
                {{ $donations->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    @endif

    <!-- Modal para ver donación completa -->
    @if ($selectedDonation)
        <livewire:donations.ver-donacion :donation="$selectedDonation" :key="'ver-donacion-' . $selectedDonation->id" />
    @endif
</div>
