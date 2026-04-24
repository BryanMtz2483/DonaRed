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

        <div class="relative z-10">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-red-200 bg-white/70 backdrop-blur-md">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group heading="DonaRed" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="hover:bg-red-100 data-[current]:bg-red-500 data-[current]:text-white">
                        🏠 {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="gift" :href="route('donations.list')" :current="request()->routeIs('donations.list')" wire:navigate class="hover:bg-green-100 data-[current]:bg-green-500 data-[current]:text-white">
                        🎁 Donaciones
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="inbox" :href="route('donations.manage')" :current="request()->routeIs('donations.manage')" wire:navigate class="hover:bg-yellow-100 data-[current]:bg-yellow-500 data-[current]:text-zinc-900">
                        📋 Mis Solicitudes
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user" :href="route('donations.history')" :current="request()->routeIs('donations.history')" wire:navigate class="hover:bg-red-100 data-[current]:bg-red-500 data-[current]:text-white">
                        📊 Mi Historial
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <!-- External links removed to avoid icon conflicts -->
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:main class="px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </flux:main>

        @fluxScripts
        </div>
    </body>
</html>
