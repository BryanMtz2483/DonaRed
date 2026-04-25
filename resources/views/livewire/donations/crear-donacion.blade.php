<div class="w-full">
    <!-- Botón para abrir formulario -->
    <button
        wire:click="$set('showForm', true)"
        class="inline-flex items-center justify-center gap-3 px-10 py-5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-extrabold text-lg rounded-2xl shadow-[0_0_30px_rgba(239,68,68,0.4)] hover:shadow-[0_0_50px_rgba(239,68,68,0.6)] hover:scale-105 transform transition-all duration-300 border-4 border-white dark:border-zinc-800 ring-4 ring-red-500/30 animate-pulse-glow"
    >
        <span class="text-3xl">💝</span>
        <span class="dark:text-white">Publicar Donación</span>
    </button>

    <!-- Modal con formulario -->
    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-start justify-center pt-18 pb-8">
            <!-- Backdrop oscuro y borroso -->
            <div
                wire:click="cancelar"
                class="absolute inset-0 bg-black/50 backdrop-blur-sm"
            ></div>

            <!-- Formulario centrado (fondo blanco opaco, no transparente) -->
            <div class="relative z-10 w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
                <div class="bg-white dark:bg-zinc-100 p-8 rounded-[1.875rem] shadow-2xl border border-zinc-200 animate-slide-down">
                    <div class="mb-8 dark:text-black!">
                        <h2 class="text-section mb-2 dark:text-black!">
                            💝 Crear Nueva Donación
                        </h2>
                        <p class="text-body text-zinc-600 dark:text-black!">
                            Comparte algo que no necesitas y transforma una vida. Cada donación cuenta. ✨
                        </p>
                    </div>

                    <form wire:submit="guardarDonacion" class="space-y-8">
                        <!-- Título -->
                        <div>
                            <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3 uppercase tracking-wider">
                                🎯 Título de la Donación
                            </label>
                            <input
                                type="text"
                                wire:model="titulo"
                                placeholder="Ej: Kit de comida lista para llevar"
                                class="w-full px-5 py-3 bg-white dark:bg-white border {{ $errors->has('titulo') ? 'border-red-500 focus:ring-red-500' : 'border-red-300 dark:border-red-300 focus:ring-red-400' }} rounded-xl focus:outline-none focus:ring-2 dark:text-zinc-900 text-base transition-all"
                            >
                            @error('titulo')
                                <p class="text-red-500 text-sm mt-2 font-medium">⚠️ {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3 uppercase tracking-wider">
                                📖 Descripción
                            </label>
                            <textarea
                                wire:model="descripcion"
                                placeholder="Describe lo que estás donando, su estado, cantidad, etc..."
                                rows="4"
                                class="w-full px-5 py-3 bg-white dark:bg-white border {{ $errors->has('descripcion') ? 'border-red-500 focus:ring-red-500' : 'border-red-300 dark:border-red-300 focus:ring-red-400' }} rounded-xl focus:outline-none focus:ring-2 dark:text-zinc-900 text-base transition-all resize-none"
                            ></textarea>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">Mínimo 10 caracteres, máximo 1000</p>
                            @error('descripcion')
                                <p class="text-red-500 text-sm mt-2 font-medium">⚠️ {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo de donación -->
                        <div>
                            <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3 uppercase tracking-wider">
                                📦 Tipo de Donación
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @php
                                    $tipos_map = [
                                        'comida' => ['icon' => '🍎', 'label' => 'Comida'],
                                        'ropa' => ['icon' => '👕', 'label' => 'Ropa'],
                                        'utiles' => ['icon' => '✏️', 'label' => 'Útiles'],
                                        'otro' => ['icon' => '📦', 'label' => 'Otro'],
                                    ];
                                @endphp
                                @foreach ($tipos_map as $valor => $data)
                                    <button
                                        type="button"
                                        wire:click="$set('tipo', '{{ $valor }}')"
                                        class="p-4 rounded-xl transition-all duration-300 border-2 font-semibold text-center {{ $tipo === $valor ? 'btn-primary' : 'bg-white dark:bg-white border-red-300 dark:border-red-300 text-zinc-900 dark:text-zinc-900 hover:bg-red-50' }}"
                                    >
                                        <div class="text-3xl mb-2">{{ $data['icon'] }}</div>
                                        <div class="text-sm">{{ $data['label'] }}</div>
                                    </button>
                                @endforeach
                            </div>
                            @error('tipo')
                                <p class="text-red-500 text-sm mt-2 font-medium">⚠️ {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-zinc-200 dark:border-zinc-700">
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="guardarDonacion"
                                class="flex-1 btn-primary-lg font-bold flex items-center justify-center gap-2"
                            >
                                <span wire:loading.remove wire:target="guardarDonacion">💚 Publicar Donación</span>
                                <span wire:loading wire:target="guardarDonacion" class="inline-flex items-center gap-2"><span class="animate-spin">✨</span> Publicando...</span>
                            </button>
                            <button
                                type="button"
                                wire:click="cancelar"
                                class="flex-1 px-6 py-4 bg-zinc-300 dark:bg-zinc-700 hover:bg-zinc-400 dark:hover:bg-zinc-600 text-zinc-900 dark:text-white font-bold rounded-lg transition-all duration-300"
                            >
                                ✕ Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
