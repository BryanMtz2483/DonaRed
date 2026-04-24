<div class="w-full">
    <!-- Botón para abrir formulario -->
    @if ($showForm)
        <div class="card-glass-lg mb-12 animate-slide-down">
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
                        class="flex-1 btn-primary-lg font-bold flex items-center justify-center gap-2"
                    >
                        <span wire:loading.remove>💚 Publicar Donación</span>
                        <span wire:loading class="inline-flex items-center gap-2"><span class="animate-spin">✨</span> Publicando...</span>
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
    @else
        <button 
            wire:click="$set('showForm', true)"
            class="inline-flex items-center justify-center gap-3 px-8 py-4 btn-primary-lg font-bold animate-pulse-glow hover:animate-none transition-all"
        >
            <span class="text-2xl">💝</span>
            <span class="dark:text-black!">Publicar Donación</span>
        </button>
    @endif
</div>
