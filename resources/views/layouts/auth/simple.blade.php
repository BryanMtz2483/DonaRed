<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gradient-to-b from-white via-orange-50 to-yellow-50 antialiased">
        <!-- Animated background elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-b from-red-500/20 to-transparent rounded-full blur-3xl animate-float"></div>
            <div class="absolute top-1/2 -left-40 w-80 h-80 bg-gradient-to-b from-green-500/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-40 right-1/3 w-80 h-80 bg-gradient-to-b from-yellow-500/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
        </div>
        
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 relative z-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium mb-4 animate-fade-in" wire:navigate>
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-red-500 via-yellow-400 to-green-500 shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300">
                        <span class="text-2xl">❤️</span>
                    </span>
                    <span class="text-xl font-bold bg-gradient-to-r from-red-500 via-yellow-400 to-green-500 bg-clip-text text-transparent">DonaRed</span>
                </a>
                <div class="card-glass-lg animate-slide-up" style="animation-delay: 0.1s;">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
