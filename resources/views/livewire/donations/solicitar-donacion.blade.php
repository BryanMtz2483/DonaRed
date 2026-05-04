<div class="flex gap-2 items-center">
    @if (!auth()->check())
        <a href="{{ route('login') }}" class="btn-primary text-center text-sm px-4 py-2">
            Iniciar Sesión
        </a>
    @elseif ($isOwner)
        <div class="px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-lg text-center shadow-lg">
            <p class="text-sm sm:text-base font-bold text-white">👑 Tu Donación</p>
        </div>
    @else
        @php
            $requestStatus = $this->getRequestStatus();
        @endphp

        @if ($requestStatus === 'pendiente')
            <div class="flex gap-2">
                <div class="px-4 py-2 bg-yellow-500/20 border border-yellow-500 rounded-lg text-center">
                    <p class="text-sm font-semibold text-yellow-600 dark:text-yellow-400">✓ Solicitada</p>
                </div>
                <button 
                    wire:click="cancelarSolicitud"
                    wire:loading.attr="disabled"
                    class="btn-accent px-4 py-2 text-sm disabled:opacity-50 rounded-lg"
                >
                    <span wire:loading.remove>✕ Cancelar</span>
                    <span wire:loading class="inline-flex items-center gap-1"><span class="animate-spin">⌛</span></span>
                </button>
            </div>
        @elseif ($requestStatus === 'aceptada')
            <div class="px-4 py-2 bg-green-500/20 border border-green-500 rounded-lg text-center">
                <p class="text-sm font-bold text-green-600 dark:text-green-400">✨ ¡Aceptada!</p>
            </div>
        @elseif ($requestStatus === 'rechazada')
            <div class="px-4 py-2 bg-red-500/20 border border-red-500 rounded-lg text-center">
                <p class="text-sm font-bold text-red-600 dark:text-red-400">Rechazada</p>
            </div>
        @else
            <button 
                wire:click="solicitar"
                wire:loading.attr="disabled"
                class="btn-primary text-sm disabled:opacity-50 px-4 py-2 rounded-lg"
            >
                <span wire:loading.remove>👋 Solicitar</span>
                <span wire:loading class="inline-flex items-center gap-1"><span class="animate-spin">✨</span></span>
            </button>
        @endif
    @endif
</div>
