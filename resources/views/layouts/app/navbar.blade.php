<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gradient-to-b from-white via-orange-50 to-yellow-50">
        <!-- Animated background elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-b from-red-500/20 to-transparent rounded-full blur-3xl animate-float"></div>
            <div class="absolute top-1/2 -left-40 w-80 h-80 bg-gradient-to-b from-green-500/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-40 right-1/3 w-80 h-80 bg-gradient-to-b from-yellow-500/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
        </div>

        <!-- NAVBAR -->
        <nav class="sticky top-0 z-50 glass backdrop-blur-md bg-white/70 border-b border-red-200/30">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 md:h-20">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-red-500 via-yellow-400 to-green-500 shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300">
                            <span class="text-xl">❤️</span>
                        </span>
                        <span class="hidden sm:inline-block text-lg md:text-xl font-bold bg-gradient-to-r from-red-500 via-yellow-400 to-green-500 bg-clip-text text-transparent">
                            DonaRed
                        </span>
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center gap-8">
                        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2 text-zinc-700 hover:text-red-500 transition font-medium {{ request()->routeIs('dashboard') ? 'text-red-500' : '' }}">
                            🏠 Dashboard
                        </a>
                        <a href="{{ route('donations.list') }}" wire:navigate class="flex items-center gap-2 text-zinc-700 hover:text-green-500 transition font-medium {{ request()->routeIs('donations.list') ? 'text-green-500' : '' }}">
                            🎁 Donaciones
                        </a>
                        <a href="{{ route('donations.manage') }}" wire:navigate class="flex items-center gap-2 text-zinc-700 hover:text-yellow-500 transition font-medium {{ request()->routeIs('donations.manage') ? 'text-yellow-500' : '' }}">
                            📋 Solicitudes
                        </a>
                        <a href="{{ route('donations.history') }}" wire:navigate class="flex items-center gap-2 text-zinc-700 hover:text-red-500 transition font-medium {{ request()->routeIs('donations.history') ? 'text-red-500' : '' }}">
                            📊 Historial
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center gap-4">
                        <!-- Desktop User Menu -->
                        <flux:dropdown position="bottom" align="end" class="hidden md:block">
                            <flux:profile
                                :name="auth()->user()->name"
                                :initials="auth()->user()->initials()"
                                icon-trailing="chevron-down"
                            />

                            <flux:menu>
                                <div class="px-3 py-2 text-sm">
                                    <p class="font-semibold text-zinc-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-zinc-600">{{ auth()->user()->email }}</p>
                                </div>
                                <flux:menu.separator />
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                                    ⚙️ Configuración
                                </flux:menu.item>
                                <flux:menu.separator />
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <flux:menu.item
                                        as="button"
                                        type="submit"
                                        icon="arrow-right-start-on-rectangle"
                                        class="w-full cursor-pointer text-red-600 hover:bg-red-50"
                                    >
                                        🚪 Cerrar Sesión
                                    </flux:menu.item>
                                </form>
                            </flux:menu>
                        </flux:dropdown>

                        <!-- Mobile Menu Button -->
                        <flux:dropdown position="bottom" align="end" class="md:hidden">
                            <button class="p-2 rounded-lg hover:bg-red-100 transition">
                                <svg class="w-6 h-6 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>

                            <flux:menu class="w-48">
                                <flux:menu.item :href="route('dashboard')" icon="home" wire:navigate>
                                    🏠 Dashboard
                                </flux:menu.item>
                                <flux:menu.item :href="route('donations.list')" icon="gift" wire:navigate>
                                    🎁 Donaciones
                                </flux:menu.item>
                                <flux:menu.item :href="route('donations.manage')" icon="inbox" wire:navigate>
                                    📋 Solicitudes
                                </flux:menu.item>
                                <flux:menu.item :href="route('donations.history')" icon="user" wire:navigate>
                                    📊 Historial
                                </flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                                    ⚙️ Configuración
                                </flux:menu.item>
                                <flux:menu.separator />
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <flux:menu.item
                                        as="button"
                                        type="submit"
                                        class="w-full cursor-pointer text-red-600 hover:bg-red-50"
                                    >
                                        🚪 Cerrar Sesión
                                    </flux:menu.item>
                                </form>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="relative z-10 w-full">
            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>
