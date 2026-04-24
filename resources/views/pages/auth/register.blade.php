<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <div class="text-center animate-fade-in">
            <h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-2">
                Crea tu Cuenta
            </h2>
            <p class="text-zinc-600">
                Únete a DonaRed y comienza a compartir
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            
            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-zinc-700 mb-2">
                    👤 {{ __('Nombre Completo') }}
                </label>
                <flux:input
                    name="name"
                    :value="old('name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Tu nombre completo"
                    class="bg-white/80 border-green-500/30 focus:border-green-500"
                />
            </div>

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
                    autocomplete="email"
                    placeholder="tu@email.com"
                    class="bg-white/80 border-green-500/30 focus:border-green-500"
                />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-zinc-700 mb-2">
                    🔐 {{ __('Contraseña') }}
                </label>
                <flux:input
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Mínimo 8 caracteres"
                    viewable
                    class="bg-white/80 border-green-500/30 focus:border-green-500"
                />
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-semibold text-zinc-700 mb-2">
                    ✓ {{ __('Confirmar Contraseña') }}
                </label>
                <flux:input
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Confirma tu contraseña"
                    viewable
                    class="bg-white/80 border-green-500/30 focus:border-green-500"
                />
            </div>

            <div class="flex items-center justify-center pt-4">
                <flux:button type="submit" class="w-full btn-secondary text-white font-bold" data-test="register-user-button">
                    <span wire:loading.remove>💚 Crear Cuenta</span>
                    <span wire:loading>⏳ Procesando...</span>
                </flux:button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-sm text-zinc-600">
                ¿Ya tienes cuenta? 
                <flux:link :href="route('login')" wire:navigate class="text-green-500 hover:text-green-600 font-semibold">
                    Inicia sesión
                </flux:link>
            </p>
        </div>
    </div>
</x-layouts::auth>
