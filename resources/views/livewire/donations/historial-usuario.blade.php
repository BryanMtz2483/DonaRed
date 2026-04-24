<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Header -->
    <div class="mb-6 animate-fade-in">
        <h2 class="text-section mb-2 text-black!">
            📊 Mi Historial
        </h2>
        <p class="text-body text-zinc-600 dark:text-zinc-300">
            Visualiza todas tus donaciones y solicitudes
        </p>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        <div class="card-glass text-center animate-scale-in" style="animation-delay: 0s">
            <p class="text-xl font-bold text-red-500 mb-1">{{ $estadisticas['donaciones_totales'] }}</p>
            <p class="text-xs text-zinc-600 dark:text-zinc-400">Donaciones</p>
        </div>
        <div class="card-glass text-center animate-scale-in" style="animation-delay: 0.1s">
            <p class="text-xl font-bold text-green-500 mb-1">{{ $estadisticas['donaciones_entregadas'] }}</p>
            <p class="text-xs text-zinc-600 dark:text-zinc-400">Entregadas</p>
        </div>
        <div class="card-glass text-center animate-scale-in" style="animation-delay: 0.2s">
            <p class="text-xl font-bold text-yellow-400 mb-1">{{ $estadisticas['solicitudes_totales'] }}</p>
            <p class="text-xs text-zinc-600 dark:text-zinc-400">Solicitudes</p>
        </div>
        <div class="card-glass text-center animate-scale-in" style="animation-delay: 0.3s">
            <p class="text-xl font-bold text-orange-500 mb-1">{{ $estadisticas['solicitudes_pendientes'] }}</p>
            <p class="text-xs text-zinc-600 dark:text-zinc-400">Pendientes</p>
        </div>
        <div class="card-glass text-center animate-scale-in" style="animation-delay: 0.4s">
            <p class="text-xl font-bold text-green-500 mb-1">{{ $estadisticas['solicitudes_aceptadas'] }}</p>
            <p class="text-xs text-zinc-600 dark:text-zinc-400">Aprobadas</p>
        </div>
    </div>

    <!-- Pestañas -->
    <div class="flex gap-2 mb-6 border-b border-zinc-200 dark:border-zinc-700">
        <button 
            wire:click="changeTab('donaciones')"
            class="px-4 py-2 font-semibold border-b-2 transition {{ $tab === 'donaciones' ? 'border-red-500 text-red-500 dark:text-red-400' : 'border-transparent text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-300' }}"
        >
            🎁 Mis Donaciones
        </button>
        <button 
            wire:click="changeTab('solicitudes')"
            class="px-4 py-2 font-semibold border-b-2 transition {{ $tab === 'solicitudes' ? 'border-green-500 text-green-500 dark:text-green-400' : 'border-transparent text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-300' }}"
        >
            👋 Mis Solicitudes
        </button>
    </div>

    <!-- Filtro por estado -->
    <div class="flex gap-2 mb-6 flex-wrap">
        <button 
            wire:click="filterByStatus('')" 
            class="px-3 py-1 rounded-lg text-xs font-medium transition {{ $filterStatus === '' ? 'btn-primary' : 'bg-white dark:bg-white text-zinc-900 border border-red-300 dark:border-red-300 hover:bg-red-50' }}"
        >
            Todas
        </button>
        @if ($tab === 'donaciones')
            <button 
                wire:click="filterByStatus('disponible')" 
                class="px-3 py-1 rounded-lg text-xs font-medium transition {{ $filterStatus === 'disponible' ? 'btn-secondary' : 'bg-white dark:bg-white text-zinc-900 border border-green-300 dark:border-green-300 hover:bg-green-50' }}"
            >
                ✨ Disponibles
            </button>
            <button 
                wire:click="filterByStatus('en_proceso')" 
                class="px-3 py-1 rounded-lg text-xs font-medium transition {{ $filterStatus === 'en_proceso' ? 'btn-accent' : 'bg-white dark:bg-white text-zinc-900 border border-yellow-300 dark:border-yellow-300 hover:bg-yellow-50' }}"
            >
                ⏳ En Proceso
            </button>
            <button 
                wire:click="filterByStatus('entregada')" 
                class="px-3 py-1 rounded-lg text-xs font-medium transition {{ $filterStatus === 'entregada' ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-zinc-200 dark:bg-green-500 text-zinc-800 dark:text-white hover:bg-zinc-300' }}"
            >
                ✓ Entregadas
            </button>
        @else
            <button 
                wire:click="filterByStatus('pendiente')" 
                class="px-3 py-1 rounded-lg text-xs font-medium transition {{ $filterStatus === 'pendiente' ? 'btn-accent' : 'bg-white dark:bg-white text-zinc-900 border border-yellow-300 dark:border-yellow-300 hover:bg-yellow-50' }}"
            >
                ⏳ Pendientes
            </button>
            <button 
                wire:click="filterByStatus('aceptada')" 
                class="px-3 py-1 rounded-lg text-xs font-medium transition {{ $filterStatus === 'aceptada' ? 'btn-secondary' : 'bg-white dark:bg-white text-zinc-900 border border-green-300 dark:border-green-300 hover:bg-green-50' }}"
            >
                ✅ Aceptadas
            </button>
            <button 
                wire:click="filterByStatus('rechazada')" 
                class="px-3 py-1 rounded-lg text-xs font-medium transition {{ $filterStatus === 'rechazada' ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-zinc-200 dark:bg-white text-zinc-800 dark:text-black border border-red-500 dark:border-red-500 hover:bg-zinc-300' }}"
            >
                ✗ Rechazadas
            </button>
        @endif
    </div>

    <!-- Contenido por pestaña -->
    @if ($items->isEmpty())
        <div class="card-glass-lg text-center">
            <p class="text-black dark:text-black text-lg">
                {{ $tab === 'donaciones' ? '📭 Aún no has hecho donaciones' : '📭 Aún no has solicitado donaciones' }}
            </p>
        </div>
    @else
        <div class="space-y-4">
            @forelse ($items as $item)
                @if ($tab === 'donaciones')
                    <!-- Item: Donación -->
                    <div class="card-glass animate-fade-in hover:scale-[1.02] transition-transform duration-300">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-zinc-900 dark:text-black mb-1">
                                    {{ $item->titulo }}
                                </h3>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                                    {{ Str::limit($item->descripcion, 100) }}
                                </p>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="badge-success">{{ ucfirst($item->tipo) }}</span>
                                    @if ($item->estado === 'disponible')
                                        <span class="badge-success">✨ Disponible</span>
                                    @elseif ($item->estado === 'en_proceso')
                                        <span class="badge-warning">⏳ En Proceso</span>
                                    @else
                                        <span class="badge-danger">✓ Entregada</span>
                                    @endif
                                    <span class="badge-success">📋 {{ $item->requests->count() }} solicitud(es)</span>
                                </div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">
                                    📅 {{ $item->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="ml-4">
                                @if ($item->estado === 'disponible' && $item->requests->count() === 0)
                                    <button 
                                        wire:click="cancelarDonacion({{ $item->id }})"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs font-semibold transition"
                                    >
                                        ✗ Eliminar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Item: Solicitud -->
                    <div class="card-glass animate-fade-in hover:scale-[1.02] transition-transform duration-300">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-zinc-900 dark:text-white mb-1">
                                    Solicitud de: <span class="text-red-500">{{ $item->donation->titulo }}</span>
                                </h3>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                                    Donador: <span class="font-semibold">{{ $item->donation->user->name }}</span>
                                </p>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="badge-success">{{ ucfirst($item->donation->tipo) }}</span>
                                    @if ($item->estado === 'pendiente')
                                        <span class="badge-warning">⏳ Pendiente</span>
                                    @elseif ($item->estado === 'aceptada')
                                        <span class="badge-success">✅ Aceptada</span>
                                    @else
                                        <span class="badge-danger">✗ Rechazada</span>
                                    @endif
                                </div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">
                                    📅 {{ $item->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="ml-4">
                                @if ($item->estado === 'pendiente')
                                    <button 
                                        wire:click="cancelarSolicitud({{ $item->id }})"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs font-semibold transition"
                                    >
                                        ✗ Cancelar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="card-glass-lg text-center">
                    <p class="text-zinc-500 dark:text-zinc-400">
                        No hay elementos que mostrar con estos filtros
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    @endif
</div>
