<x-layouts::app.navbar>
    <!-- GREETING SECTION -->
    <section class="relative py-8 md:py-12 px-0 border-b border-red-200/30 overflow-hidden bg-gradient-to-b from-white via-orange-50 to-yellow-50">
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-b from-red-500/20 to-transparent rounded-full blur-3xl animate-float"></div>
            <div class="absolute top-1/2 -left-40 w-80 h-80 bg-gradient-to-b from-green-500/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-40 right-1/3 w-80 h-80 bg-gradient-to-b from-yellow-500/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="animate-fade-in">
                    <h1 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-2">
                        ¡Hola, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-lg text-zinc-600">
                        Bienvenido de vuelta a DonaRed
                    </p>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('donations.list') }}" class="btn-secondary px-6 py-3 rounded-lg">
                        📦 Explorar Donaciones
                    </a>
                    <a href="{{ route('donations.list', ['create' => 'true']) }}" class="btn-primary px-6 py-3 rounded-lg">
                        ➕ Nueva Donación
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- MI IMPACTO SECTION -->
    <section class="py-12 md:py-16 px-0 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-section mb-8 animate-fade-in text-black!">Mi Impacto</h2>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Mi Donaciones -->
                <div class="card-glass-lg hover-lift animate-scale-in">
                    <div class="text-4xl mb-3">📦</div>
                    <p class="text-sm text-zinc-600 mb-2">Mis Donaciones Activas</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">{{ $totalActiveDonations }}</p>
                </div>

                <!-- Personas Ayudadas -->
                <div class="card-glass-lg hover-lift animate-scale-in" style="animation-delay: 0.1s;">
                    <div class="text-4xl mb-3">🤝</div>
                    <p class="text-sm text-zinc-600 mb-2">Personas ayudadas</p>
                    <p class="text-3xl font-bold bg-gradient-to-r from-green-500 to-green-600 bg-clip-text text-transparent">{{ $deliveredDonations }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- MIS DONACIONES ACTIVAS -->
    <section class="py-12 md:py-16 px-0 bg-gradient-to-b from-zinc-50 to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-section text-black!">Mis Donaciones Activas</h2>
                <a href="{{ route('donations.list') }}" class="text-red-500 font-semibold hover:text-red-600 transition">Ver Todas</a>
            </div>
            
            @if ($myDonations->isEmpty())
                <div class="card-glass-lg text-center py-16">
                    <div class="text-6xl mb-4">🎁</div>
                    <p class="text-lg font-semibold text-zinc-900 mb-2">Aún no has hecho donaciones</p>
                    <p class="text-zinc-600 mb-6">¡Sé el primero en compartir y ayudar a tu comunidad!</p>
                    <a href="{{ route('donations.list') }}" class="btn-primary inline-block">
                        ➕ Crear Donación
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($myDonations as $donation)
                        <div class="card-glass p-6 hover-lift animate-slide-up">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-zinc-900">{{ $donation->titulo }}</h3>
                                        @if ($donation->estado === 'disponible')
                                            <span class="badge-success">Disponible</span>
                                        @elseif ($donation->estado === 'en_proceso')
                                            <span class="badge-warning">En Proceso</span>
                                        @else
                                            <span class="badge-danger">Entregada</span>
                                        @endif
                                    </div>
                                    <p class="text-body text-zinc-600 mb-2">
                                        {{ Str::limit($donation->descripcion, 100) }}
                                    </p>
                                    <div class="flex gap-4 text-sm text-zinc-500">
                                        <span>📍 
                                            @switch($donation->tipo)
                                                @case('comida')
                                                    Comida
                                                    @break
                                                @case('ropa')
                                                    Ropa
                                                    @break
                                                @case('utiles')
                                                    Útiles
                                                    @break
                                                @default
                                                    Otro
                                            @endswitch
                                        </span>
                                        <span>📅 {{ $donation->created_at->format('d/m/Y') }}</span>
                                        <span>👁️ {{ $donation->requests->count() }} solicitud(es)</span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button class="btn-secondary px-4 py-2 text-sm rounded-lg">Editar</button>
                                    <button class="btn-accent px-4 py-2 text-sm rounded-lg">Detalles</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- EXPLORAR DONACIONES EN VIVO -->
    <section class="py-12 md:py-16 px-0 bg-gradient-to-b from-zinc-50 to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-section text-black!">Explora Nuestro Catálogo</h2>
                    <p class="text-body text-zinc-600">
                        Descubre lo que otras personas están compartiendo en tu comunidad
                    </p>
                </div>
            </div>

            @if ($exploreDonations->isEmpty())
                <div class="card-glass-lg text-center py-16">
                    <div class="text-6xl mb-4">🔍</div>
                    <p class="text-lg font-semibold text-zinc-900 mb-2">No hay donaciones disponibles aún</p>
                    <p class="text-zinc-600 mb-6">¡Sé el primero en compartir y ayudar a tu comunidad!</p>
                    <a href="{{ route('donations.list') }}" class="btn-primary inline-block">
                        ➕ Nueva Donación
                    </a>
                </div>
            @else
                <!-- Donaciones Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($exploreDonations as $donation)
                        <div class="card-glass group hover-lift animate-scale-in transition-all duration-300">
                            <!-- Type Badge -->
                            <div class="mb-4">
                                <span class="badge-success text-xs font-semibold">
                                    @switch($donation->tipo)
                                        @case('comida')
                                            🍎 Comida
                                            @break
                                        @case('ropa')
                                            👕 Ropa
                                            @break
                                        @case('utiles')
                                            ✏️ Útiles
                                            @break
                                        @default
                                            📦 Otro
                                    @endswitch
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg font-bold text-zinc-900 mb-2 line-clamp-2">
                                {{ $donation->titulo }}
                            </h3>

                            <!-- Description -->
                            <p class="text-body text-zinc-600 line-clamp-2 mb-4">
                                {{ $donation->descripcion }}
                            </p>

                            <!-- Donor Info -->
                            <div class="flex items-center gap-2 text-zinc-700 mb-4">
                                <span class="text-lg">👤</span>
                                <span class="text-sm font-medium">{{ $donation->user->name }}</span>
                            </div>

                            <!-- Status & Date -->
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-zinc-500">
                                    📅 {{ $donation->created_at->diffForHumans() }}
                                </span>
                                @if ($donation->estado === 'disponible')
                                    <span class="text-xs font-semibold text-green-600">✨ Disponible</span>
                                @elseif ($donation->estado === 'en_proceso')
                                    <span class="text-xs font-semibold text-yellow-600">⏳ En Proceso</span>
                                @else
                                    <span class="text-xs font-semibold text-zinc-600">✓ Entregada</span>
                                @endif
                            </div>

                            <!-- Requests Count -->
                            <div class="mb-4">
                                <span class="text-xs text-zinc-500">👁️ {{ $donation->requests->count() }} solicitud(es)</span>
                            </div>

                            <!-- CTA -->
                            <a href="{{ route('donations.list') }}" class="inline-block text-red-500 font-semibold hover:text-red-600 transition">
                                Ver Más →
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="{{ route('donations.list') }}" class="btn-primary-lg">
                    Ver Todas las Donaciones
                </a>
            </div>
        </div>
    </section>

    <!-- STATS FOOTER -->
    <section class="py-12 md:py-16 px-0 bg-gradient-to-r from-red-500 via-yellow-400 to-green-500">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-8">
                Tu Comunidad en Números
            </h3>
            
            <div class="grid sm:grid-cols-4 gap-6">
                <div>
                    <p class="text-4xl font-bold text-white counter">342</p>
                    <p class="text-white/80 text-sm mt-2">Donaciones Activas</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-white counter">156</p>
                    <p class="text-white/80 text-sm mt-2">Personas Ayudadas</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-white counter">2500</p>
                    <p class="text-white/80 text-sm mt-2">Artículos Compartidos</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-white counter">89</p>
                    <p class="text-white/80 text-sm mt-2">Historias de Éxito</p>
                </div>
            </div>
        </div>
    </section>

</x-layouts::app.navbar>

