<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonaRed - Comparte lo Que No Necesitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-zinc-900">

    <!-- ============================================
         NAVBAR STICKY
         ============================================ -->
    <nav class="sticky top-0 z-50 glass backdrop-blur-md bg-white/70 dark:bg-zinc-900/70 border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-red-500 via-yellow-400 to-green-500 bg-clip-text text-transparent">
                        ❤️
                    </div>
                    <span class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-white">DonaRed</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#como-funciona" class="text-zinc-700 dark:text-zinc-300 hover:text-red-500 transition">
                        Cómo Funciona
                    </a>
                    <a href="#impacto" class="text-zinc-700 dark:text-zinc-300 hover:text-red-500 transition">
                        Impacto
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-zinc-700 dark:text-zinc-300 hover:text-red-500 transition font-medium">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-primary hidden sm:inline-block">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- ============================================
         HERO SECTION
         ============================================ -->
    <section class="relative min-h-[90vh] md:min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-b from-white via-orange-50 to-yellow-50 dark:from-zinc-900 dark:via-orange-950 dark:to-yellow-950">
        
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-b from-red-500/20 to-transparent rounded-full blur-3xl animate-float"></div>
            <div class="absolute top-1/2 -left-40 w-80 h-80 bg-gradient-to-b from-green-500/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-40 right-1/3 w-80 h-80 bg-gradient-to-b from-yellow-500/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20 md:py-0">
            <!-- Main Headline -->
            <h1 class="text-hero animate-fade-in mb-6">
                Comparte lo Que No Necesitas
            </h1>

            <!-- Subheadline -->
            <p class="text-subtitle animate-fade-in mb-12" style="animation-delay: 0.2s;">
                Tu comunidad cuidándose mutuamente. Dona, solicita, transforma vidas.
            </p>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16 animate-slide-up" style="animation-delay: 0.4s;">
                <a href="#donaciones-destacadas" class="btn-primary-lg">
                    Ver Donaciones 🎁
                </a>
                <a href="{{ route('login') }}" class="btn-secondary px-8 py-4 text-lg rounded-lg">
                    Solicitar Ayuda 🤝
                </a>
            </div>

            <!-- Scroll indicator -->
            <div class="flex justify-center items-center gap-2 animate-bounce">
                <span class="text-zinc-500 dark:text-zinc-400 text-sm">Desplázate para descubrir</span>
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </section>

    <!-- ============================================
         CÓMO FUNCIONA SECTION
         ============================================ -->
    <section id="como-funciona" class="py-20 md:py-24 px-4 sm:px-6 lg:px-8 bg-white dark:bg-zinc-800">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-section text-center mb-16 animate-fade-in">
                ¿Cómo Funciona DonaRed?
            </h2>

            <!-- Steps Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="card-glass-lg group hover-lift animate-scale-in">
                    <div class="text-6xl mb-4">🎁</div>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-3">
                        Comparte
                    </h3>
                    <p class="text-body text-zinc-600 dark:text-zinc-400">
                        Publica los artículos que ya no necesitas. Es rápido, fácil y seguro.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="card-glass-lg group hover-lift animate-scale-in" style="animation-delay: 0.1s;">
                    <div class="text-6xl mb-4">🤝</div>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-3">
                        Conecta
                    </h3>
                    <p class="text-body text-zinc-600 dark:text-zinc-400">
                        Encuentra lo que necesitas o conecta con quien pueda ayudarte.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="card-glass-lg group hover-lift animate-scale-in" style="animation-delay: 0.2s;">
                    <div class="text-6xl mb-4">💚</div>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-3">
                        Transforma
                    </h3>
                    <p class="text-body text-zinc-600 dark:text-zinc-400">
                        Juntos hacemos una diferencia real en nuestras comunidades.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         DONACIONES DESTACADAS
         ============================================ -->
    <section id="donaciones-destacadas" class="py-20 md:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-900 dark:to-zinc-800">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-section text-center mb-4 animate-fade-in">
                Donaciones Destacadas
            </h2>
            <p class="text-center text-subtitle mb-12 animate-fade-in" style="animation-delay: 0.1s;">
                Mira lo que otras personas están compartiendo
            </p>

            <!-- Donations Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($featuredDonations as $donation)
                    <div class="card-glass group hover:scale-105 animate-scale-in transition-all duration-300" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <!-- Type Badge -->
                        <div class="mb-4">
                            <span class="badge-success text-xs font-semibold">
                                {{ match($donation->tipo) { 'comida' => '🍎', 'ropa' => '👕', 'utiles' => '✏️', default => '📦' } }}
                                {{ ucfirst($donation->tipo) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2 line-clamp-2">
                            {{ $donation->titulo }}
                        </h3>

                        <!-- Description -->
                        <p class="text-body text-zinc-600 dark:text-zinc-400 line-clamp-2 mb-4">
                            {{ $donation->descripcion }}
                        </p>

                        <!-- Donor Info -->
                        <div class="flex items-center gap-2 text-zinc-700 dark:text-zinc-300 mb-4">
                            <span class="text-lg">👤</span>
                            <span class="text-sm font-medium">{{ $donation->user->name }}</span>
                        </div>

                        <!-- Status & Date -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                📅 {{ $donation->created_at->diffForHumans() }}
                            </span>
                            @if ($donation->estado === 'disponible')
                                <span class="text-xs font-semibold text-green-600 dark:text-green-400">✨ Disponible</span>
                            @elseif ($donation->estado === 'en_proceso')
                                <span class="text-xs font-semibold text-yellow-600 dark:text-yellow-400">⏳ En Proceso</span>
                            @else
                                <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">✓ Entregada</span>
                            @endif
                        </div>

                        <!-- CTA -->
                        @auth
                            <a href="{{ route('donations.list') }}" class="inline-block text-red-500 font-semibold hover:text-red-600 transition">
                                Ver Más →
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block text-red-500 font-semibold hover:text-red-600 transition">
                                Solicitar →
                            </a>
                        @endauth
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="text-6xl mb-4">🎁</div>
                        <p class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">
                            No hay donaciones disponibles aún
                        </p>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                            ¡Sé el primero en compartir y ayudar a tu comunidad!
                        </p>
                        @auth
                            <a href="{{ route('donations.create') }}" class="btn-primary">
                                💝 Publicar Donación
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-primary">
                                Crear Cuenta y Donar
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                @auth
                    <a href="{{ route('donations.list') }}" class="btn-primary">
                        Ver Todas las Donaciones
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">
                        Iniciar Sesión para Ver Más
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- ============================================
         NÚMEROS DE IMPACTO
         ============================================ -->
    <section id="impacto" class="py-20 md:py-24 px-4 sm:px-6 lg:px-8 bg-white dark:bg-zinc-800">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-section text-center mb-16 animate-fade-in">
                El Impacto de Nuestra Comunidad
            </h2>

            <!-- Stats Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($stats as $stat)
                    <div class="text-center card-glass-lg hover-lift animate-scale-in">
                        <div class="text-5xl md:text-6xl mb-4 counter">
                            {{ $stat['number'] }}
                        </div>
                        <p class="text-zoom font-semibold text-zinc-700 dark:text-zinc-300">
                            {{ $stat['label'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================
         TESTIMONIOS
         ============================================ -->
    <section class="py-20 md:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-900 dark:to-zinc-800">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-section text-center mb-16 animate-fade-in">
                Historias que Inspiran
            </h2>

            <!-- Testimonials Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="card-glass-lg hover-lift animate-scale-in">
                        <!-- Avatar -->
                        <div class="text-5xl mb-4">{{ $testimonial['avatar'] }}</div>

                        <!-- Story -->
                        <p class="text-body text-zinc-700 dark:text-zinc-300 mb-4 italic">
                            "{{ $testimonial['story'] }}"
                        </p>

                        <!-- Name & Role -->
                        <h4 class="font-bold text-zinc-900 dark:text-white">
                            {{ $testimonial['name'] }}
                        </h4>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $testimonial['role'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================
         CTA FINAL
         ============================================ -->
    <section class="py-20 md:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-red-500 via-yellow-400 to-green-500">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 animate-fade-in">
                Sé Parte del Cambio
            </h2>
            <p class="text-lg md:text-xl text-white/90 mb-12 animate-fade-in" style="animation-delay: 0.1s;">
                Únete a miles de personas transformando sus comunidades
            </p>

            <!-- Auth Check for CTA -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up" style="animation-delay: 0.2s;">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-red-500 font-bold py-4 px-8 rounded-lg hover:bg-gray-50 transition-all transform hover:scale-105 active:scale-95">
                        Ir al Dashboard
                    </a>
                    <a href="{{ route('donations.list') }}" class="bg-white/20 backdrop-blur text-white font-bold py-4 px-8 rounded-lg hover:bg-white/30 transition-all border border-white/50">
                        Ver Donaciones
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary-lg text-black bg-white">
                        Empezar a Donar 🎁
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- ============================================
         FOOTER
         ============================================ -->
    <footer class="bg-zinc-900 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div>
                    <h4 class="font-bold mb-4">❤️ DonaRed</h4>
                    <p class="text-zinc-400 text-sm">
                        Conectando comunidades, transformando vidas a través de la solidaridad.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-bold mb-4">Links</h4>
                    <ul class="space-y-2 text-zinc-400 text-sm">
                        <li><a href="#como-funciona" class="hover:text-white transition">Cómo Funciona</a></li>
                        <li><a href="#impacto" class="hover:text-white transition">Impacto</a></li>
                        <li><a href="#" class="hover:text-white transition">Sobre Nosotros</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-zinc-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Términos de Servicio</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacidad</a></li>
                        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>

                <!-- Redes Sociales -->
                <div>
                    <h4 class="font-bold mb-4">Síguenos</h4>
                    <ul class="space-y-2 text-zinc-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Twitter</a></li>
                        <li><a href="#" class="hover:text-white transition">Instagram</a></li>
                        <li><a href="#" class="hover:text-white transition">Facebook</a></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-zinc-800 pt-8 text-center">
                <p class="text-zinc-400 text-sm">
                    © 2026 DonaRed. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>

    @vite('resources/js/landing.js')
</body>
</html>
