<div class="fixed inset-0 z-50 flex items-start justify-center pt-18 pb-8">
    <!-- Backdrop oscuro y borroso -->
    <div
        wire:click="cancelar"
        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
    ></div>

    <!-- Formulario centrado (fondo blanco opaco) -->
    <div class="relative z-10 w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
        <div class="bg-white dark:bg-zinc-100 p-8 rounded-[1.875rem] shadow-2xl border border-zinc-200 animate-slide-down">
            <div class="mb-8 dark:text-black!">
                <h2 class="text-section mb-2 dark:text-black!">
                    ✏️ Editar Donación
                </h2>
                <p class="text-body text-zinc-600 dark:text-black!">
                    Modifica los detalles de tu donación. Los cambios se guardarán inmediatamente.
                </p>
            </div>

            <form wire:submit="actualizarDonacion" class="space-y-8">
                <!-- Título -->
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-black mb-3 uppercase tracking-wider">
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
                    <label class="block text-sm font-bold text-zinc-700 dark:text-black mb-3 uppercase tracking-wider">
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
                    <label class="block text-sm font-bold text-zinc-700 dark:text-black mb-3 uppercase tracking-wider">
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
                        wire:target="actualizarDonacion"
                        class="flex-1 px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-lg transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-green-500/30"
                    >
                        <span wire:loading.remove wire:target="actualizarDonacion">💾 Guardar Cambios</span>
                        <span wire:loading wire:target="actualizarDonacion" class="inline-flex items-center gap-2"><span class="animate-spin">✨</span> Guardando...</span>
                    </button>
                    <button
                        type="button"
                        wire:click="cancelar"
                        class="flex-1 px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold rounded-lg transition-all duration-300 shadow-lg shadow-red-500/30"
                    >
                        ✕ Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
