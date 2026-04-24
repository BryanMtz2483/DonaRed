<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <div class="text-center animate-fade-in">
            <h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-2">
                Inicia Sesión
            </h2>
            <p class="text-zinc-600">
                Bienvenido de vuelta a DonaRed
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label class="block text-sm font-semibold text-zinc-700 mb-2">
                    📧 {{ __('Email') }}
                </label>
                <flux:input
                    name="email"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="tu@email.com"
                    class="bg-white/80 border-red-500/30 focus:border-red-500"
                />
            </div>

            <!-- Password -->
            <div class="relative">
                <label class="block text-sm font-semibold text-zinc-700 mb-2">
                    🔐 {{ __('Contraseña') }}
                </label>
                <flux:input
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Ingresa tu contraseña')"
                    viewable
                    class="bg-white/80 border-red-500/30 focus:border-red-500"
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0 text-red-500 hover:text-red-600" :href="route('password.request')" wire:navigate>
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Recuérdame por 30 días')" :checked="old('remember')" class="text-zinc-700" />

            <div class="flex items-center justify-center pt-4">
                <flux:button type="submit" class="w-full btn-primary-lg text-white font-bold" data-test="login-button">
                    <span wire:loading.remove>🔓 Iniciar Sesión</span>
                    <span wire:loading>⏳ Procesando...</span>
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="text-center">
                <p class="text-sm text-zinc-600">
                    ¿No tienes cuenta? 
                    <flux:link :href="route('register')" wire:navigate class="text-red-500 hover:text-red-600 font-semibold">
                        Regístrate aquí
                    </flux:link>
                </p>
            </div>
        @endif
    </div>
</x-layouts::auth>
