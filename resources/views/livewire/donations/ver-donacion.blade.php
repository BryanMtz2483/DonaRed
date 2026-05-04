<div>
    <!-- Modal backdrop -->
    <div class="fixed inset-0 bg-black/50 z-40 backdrop-blur-sm" wire:click="closeModal()"></div>

    <!-- Modal container - items-start para que no se mueva al scrollear -->
    <div class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-23">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[calc(100vh-100px)] flex flex-col" wire:click.stop>

            <!-- Header with close button - fijo arriba -->
            <div class="flex-none bg-gradient-to-r from-red-500/90 via-yellow-400/80 to-green-500/90 px-4 sm:px-6 py-4 flex justify-between items-center rounded-t-2xl">
                <h2 class="text-xl sm:text-2xl font-bold text-white line-clamp-1">{{ $donation->titulo }}</h2>
                <button 
                    wire:click="closeModal()"
                    class="text-white hover:bg-white/20 rounded-full p-2 transition shrink-0"
                >
                    ✕
                </button>
            </div>

            <!-- Content - scrollable area -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8 space-y-6 sm:space-y-8 bg-gradient-to-b from-white via-orange-50 to-yellow-50">

                <!-- Donante Info -->
                <div class="card-glass p-3 sm:p-4">
                    <p class="text-xs sm:text-sm text-black mb-1">👤 Donante</p>
                    <p class="text-base sm:text-lg font-semibold text-zinc-900">{{ $donation->user->name }}</p>
                </div>

                <!-- Descripción completa -->
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-zinc-900 mb-3">📝 Descripción Completa</h3>
                    <div class="card-glass-lg p-4 sm:p-6">
                        <p class="text-sm sm:text-base text-zinc-700 leading-relaxed whitespace-pre-wrap break-words overflow-hidden">
                            {{ $donation->descripcion }}
                        </p>
                    </div>
                </div>

                <!-- Meta información -->
                <div class="grid grid-cols-2 gap-2 sm:gap-4">
                    <div class="card-glass p-3 sm:p-4">
                        <p class="text-xs text-zinc-600 mb-1">📦 Tipo</p>
                        <p class="text-sm sm:text-base font-semibold text-zinc-900">
                            {{ match($donation->tipo) {
                                'comida' => '🍎 Comida',
                                'ropa' => '👕 Ropa',
                                'utiles' => '✏️ Útiles',
                                default => '📦 Otro'
                            } }}
                        </p>
                    </div>

                    <div class="card-glass p-3 sm:p-4">
                        <p class="text-xs text-black mb-1">📅 Publicado</p>
                        <p class="text-sm sm:text-base font-semibold text-zinc-900">
                            {{ $donation->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="card-glass p-3 sm:p-4">
                        <p class="text-xs text-black mb-1">👁️ Solicitudes</p>
                        <p class="text-sm sm:text-base font-semibold text-zinc-900">
                            {{ $donation->requests->count() }}
                        </p>
                    </div>

                    <div class="card-glass p-3 sm:p-4">
                        <p class="text-xs text-black mb-1">📊 Estado</p>
                        <p class="text-sm sm:text-base font-semibold">
                            @if ($donation->estado === 'disponible')
                                <span class="text-green-600">✨ Disponible</span>
                            @elseif ($donation->estado === 'en_proceso')
                                <span class="text-yellow-600">⏳ En Proceso</span>
                            @else
                                <span class="text-zinc-600">✓ Entregada</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Botones de acción - fijos abajo -->
            <div class="flex-none flex flex-col sm:flex-row gap-2 sm:gap-3 p-4 sm:p-6 border-t-2 border-red-200 bg-white rounded-b-2xl">
                <div class="flex-1">
                    <livewire:donations.solicitar-donacion :donation="$donation" :key="'ver-donacion-' . $donation->id" />
                </div>
                <button
                    wire:click="closeModal()"
                    class="px-4 sm:px-6 py-2 sm:py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition text-sm sm:text-base shrink-0"
                >
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
