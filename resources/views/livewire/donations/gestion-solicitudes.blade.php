<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Header -->
    <div class="mb-6 animate-fade-in">
        <h2 class="text-section mb-2">
            📋 Gestión de Solicitudes
        </h2>
        <p class="text-body text-zinc-600 dark:text-zinc-300">
            Administra las solicitudes de tus donaciones
        </p>
    </div>

    <!-- Resumen de solicitudes -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="card-glass text-center">
            <p class="text-2xl font-bold text-yellow-400 mb-1">{{ $summary['pendientes'] }}</p>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Pendientes</p>
        </div>
        <div class="card-glass text-center">
            <p class="text-2xl font-bold text-green-500 mb-1">{{ $summary['aceptadas'] }}</p>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Aceptadas</p>
        </div>
        <div class="card-glass text-center">
            <p class="text-2xl font-bold text-red-500 mb-1">{{ $summary['rechazadas'] }}</p>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Rechazadas</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="flex gap-2 mb-6 flex-wrap">
        <button 
            wire:click="filterByStatus('')" 
            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $filterStatus === '' ? 'btn-primary' : 'bg-white dark:bg-white text-zinc-900 border border-red-300 dark:border-red-300 hover:bg-red-50' }}"
        >
            Todas
        </button>
        <button 
            wire:click="filterByStatus('pendiente')" 
            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $filterStatus === 'pendiente' ? 'btn-accent' : 'bg-white dark:bg-white text-zinc-900 border border-yellow-300 dark:border-yellow-300 hover:bg-yellow-50' }}"
        >
            ⏳ Pendientes
        </button>
        <button 
            wire:click="filterByStatus('aceptada')" 
            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $filterStatus === 'aceptada' ? 'btn-secondary' : 'bg-white dark:bg-white text-zinc-900 border border-green-300 dark:border-green-300 hover:bg-green-50' }}"
        >
            ✅ Aceptadas
        </button>
        <button 
            wire:click="filterByStatus('rechazada')" 
            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $filterStatus === 'rechazada' ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-white dark:bg-white text-zinc-900 border border-red-300 dark:border-red-300 hover:bg-red-50' }}"
        >
            ✗ Rechazadas
        </button>
    </div>

    <!-- Listado de solicitudes -->
    @if ($requests->isEmpty())
        <div class="card-glass-lg text-center">
            <p class="text-zinc-500 dark:text-zinc-400 text-lg">
                📭 No hay solicitudes para mostrar
            </p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($requests as $request)
                <div class="card-glass border-l-4 {{ $request->estado === 'pendiente' ? 'border-yellow-400' : ($request->estado === 'aceptada' ? 'border-green-500' : 'border-red-500') }} hover:scale-[1.02] transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <!-- Info solicitud -->
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-yellow-400 rounded-full flex items-center justify-center text-lg">
                                    👤
                                </div>
                                <div>
                                    <p class="font-semibold text-zinc-900 dark:text-white">{{ $request->user->name }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $request->user->email }}</p>
                                </div>
                            </div>

                            <!-- Donación solicitada -->
                            <div class="ml-13">
                                <p class="text-sm text-zinc-700 dark:text-zinc-300 mb-1">
                                    <strong>Solicita:</strong> {{ $request->donation->titulo }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">
                                    📅 Hace {{ $request->created_at->diffForHumans() }}
                                </p>

                                <!-- Estado badge -->
                                @if ($request->estado === 'pendiente')
                                    <span class="badge-warning">⏳ Pendiente</span>
                                @elseif ($request->estado === 'aceptada')
                                    <span class="badge-success">✅ Aceptada</span>
                                @else
                                    <span class="badge-danger">✗ Rechazada</span>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="flex gap-2 ml-4">
                            @if ($request->estado === 'pendiente')
                                <button 
                                    wire:click="aceptarSolicitud({{ $request->id }})"
                                    wire:loading.attr="disabled"
                                    class="btn-secondary text-sm disabled:opacity-50"
                                >
                                    <span wire:loading.remove>✓ Aceptar</span>
                                    <span wire:loading>...</span>
                                </button>
                                <button 
                                    wire:click="rechazarSolicitud({{ $request->id }})"
                                    wire:loading.attr="disabled"
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm font-semibold transition disabled:opacity-50"
                                >
                                    <span wire:loading.remove>✗ Rechazar</span>
                                    <span wire:loading>...</span>
                                </button>
                            @elseif ($request->estado === 'aceptada' && $request->donation->estado !== 'entregada')
                                <button 
                                    wire:click="marcarEntregada({{ $request->id }})"
                                    wire:loading.attr="disabled"
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm font-semibold transition disabled:opacity-50"
                                >
                                    <span wire:loading.remove>📦 Marcar Entregada</span>
                                    <span wire:loading>...</span>
                                </button>
                            @else
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Sin acciones
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    @endif
</div>
