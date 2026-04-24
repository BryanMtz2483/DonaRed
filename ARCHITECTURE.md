# 📐 DonaRed - Arquitectura y Diagrama del Proyecto

## 🏗️ Arquitectura General

```
┌─────────────────────────────────────────────────────────┐
│                   NAVEGADOR DEL USUARIO                 │
│           (Blade Templates + JavaScript/Livewire)       │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│              CAPA DE PRESENTACIÓN (View)                │
│  ┌──────────────────────────────────────────────────┐   │
│  │  resources/views/                               │   │
│  │  ├── layouts/app/sidebar.blade.php             │   │
│  │  ├── dashboard.blade.php                       │   │
│  │  └── pages/donaciones/                         │   │
│  │      ├── lista.blade.php                       │   │
│  │      ├── gestionar.blade.php                   │   │
│  │      └── historial.blade.php                   │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│           CAPA DE LÓGICA (Livewire Components)          │
│  ┌──────────────────────────────────────────────────┐   │
│  │  app/Livewire/Donations/                        │   │
│  │  ├── ListaDonaciones → Listar + filtrar        │   │
│  │  ├── CrearDonacion → Crear nueva              │   │
│  │  ├── SolicitarDonacion → Solicitar            │   │
│  │  ├── GestionSolicitudes → Aceptar/rechazar    │   │
│  │  └── HistorialUsuario → Ver historial         │   │
│  │                                                 │   │
│  │  Características:                              │   │
│  │  • Validación en tiempo real                  │   │
│  │  • Actualización sin recargar (AJAX)          │   │
│  │  • Eventos y listeners                        │   │
│  │  • Paginación dinámina                        │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│            CAPA DE DATOS (Models + ORM)                 │
│  ┌──────────────────────────────────────────────────┐   │
│  │  app/Models/                                    │   │
│  │  ├── User                                       │   │
│  │  │   ├── donations() → HasMany                 │   │
│  │  │   └── donationRequests() → HasMany          │   │
│  │  │                                              │   │
│  │  ├── Donation                                   │   │
│  │  │   ├── user() → BelongsTo                    │   │
│  │  │   ├── requests() → HasMany                  │   │
│  │  │   └── scopes (available, byType, latest)    │   │
│  │  │                                              │   │
│  │  └── DonationRequest                            │   │
│  │      ├── donation() → BelongsTo                │   │
│  │      ├── user() → BelongsTo                    │   │
│  │      └── methods (accept, reject)              │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│        CAPA DE PERSISTENCIA (Base de Datos)             │
│  ┌──────────────────────────────────────────────────┐   │
│  │  Tables:                                        │   │
│  │  ├── users (id, name, email, password, ...)    │   │
│  │  ├── donations (id, titulo, desc, tipo, ...)   │   │
│  │  ├── requests (id, donation_id, user_id, ...) │   │
│  │  └── migrations log                            │   │
│  │                                                 │   │
│  │  Indexes:                                       │   │
│  │  • user_id en donations y requests             │   │
│  │  • estado en donations y requests              │   │
│  │  • unique(donation_id, user_id) en requests    │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

---

## 🔄 Diagrama de Flujo: Publicar a Entregar

```
USUARIO A: PUBLICA DONACIÓN
═══════════════════════════════════════

    Página: /donaciones
         ↓
    Click: "+ Publicar"
         ↓
    Componente: CrearDonacion
    • Abre formulario dinámico
    • Valida en tiempo real
    • Guarda en BD
         ↓
    Event: 'donationCreated'
    ↓
ListaDonaciones::refresh()
    ↓
DONACIÓN VISIBLE PARA TODOS


USUARIO B: SOLICITA DONACIÓN
═════════════════════════════════════════════

    Página: /donaciones
         ↓
    Ve donación de Usuario A
         ↓
    Click: "👋 Solicitar"
         ↓
    Componente: SolicitarDonacion
    • Valida permisos
    • Crea DonationRequest
    • Estado: 'pendiente'
         ↓
    Event: 'donationRequested'


USUARIO A: GESTIONA SOLICITUDES
═════════════════════════════════════════════

    Página: /donaciones/gestionar
         ↓
    Ve solicitud de Usuario B
    Estado: 'Pendiente'
         ↓
    Click: "✓ Aceptar"
         ↓
    Componente: GestionSolicitudes::aceptarSolicitud()
    • DonationRequest estado = 'aceptada'
    • Donation estado = 'en_proceso'
    • Otras solicitudes = 'rechazada'
         ↓
    Notificación: "✓ Aceptada"


USUARIO A: MARCA ENTREGADA
═════════════════════════════════════════════

    Mismo panel
         ↓
    Click: "📦 Marcar Entregada"
         ↓
    GestionSolicitudes::marcarEntregada()
    • Donation estado = 'entregada'
         ↓
    PROCESO COMPLETADO ✓


HISTORIAL ACTUALIZADO
═════════════════════════════════════════════

    Usuario A → /donaciones/historial
    • Donación: "Entregada"
    • Solicit rechazadas: Mostradas

    Usuario B → /donaciones/historial
    • Solicitud: "Aceptada"
    • Donación recibida: Mostrada
```

---

## 📊 Modelo Relacional

```
┌─────────────────┐      ┌──────────────────┐
│   users         │      │  donations       │
│─────────────────│      │──────────────────│
│ id (PK)         │◄──┐  │ id (PK)          │
│ name            │   └──┼─ user_id (FK)    │
│ email           │      │ titulo           │
│ password        │      │ descripcion      │
│ created_at      │      │ tipo             │
│ updated_at      │      │ estado           │
└─────────────────┘      │ created_at       │
         ▲                │ updated_at       │
         │                └──────────────────┘
         │                        ◄──┐
         │                           │
         │                ┌──────────────────────┐
         │                │  requests            │
         │                │──────────────────────│
         │                │ id (PK)              │
         │                │ donation_id (FK)    │
         │                │ user_id (FK) ───────┼──┐
         │                │ estado               │  │
         │                │ created_at           │  │
         │                │ updated_at           │  │
         │                │ UNIQUE(donation,user)│  │
         │                └──────────────────────┘  │
         │                                          │
         └──────────────────────────────────────────┘

RELACIONES:
User
  ├── hasMany → Donation (como donador)
  ├── hasMany → DonationRequest (como solicitante)
  └── hasMany → DonationRequest (via donations como receptor)

Donation
  ├── belongsTo → User
  └── hasMany → DonationRequest

DonationRequest
  ├── belongsTo → Donation
  └── belongsTo → User
```

---

## 🎞️ Ciclo de Vida de Componente Livewire

```
COMPONENTE: ListaDonaciones
═══════════════════════════════════════════════════════

1. MOUNT (Una sola vez)
   ├─ Inicializar propiedades
   ├─ Cargar opciones iniciales
   └─ Listeners registrados

2. RENDER (Cada actualización)
   ├─ getDonaciones()
   ├─ Aplicar filtros
   ├─ Paginar resultados
   └─ return view()

3. USER INTERACTION (Ejemplo: filtrar)
   ├─ Click en botón filtro
   ├─ wire:click="updateFilter('comida')"
   ├─ $filterType = 'comida'
   ├─ $refreshPage()
   └─ Volver a 2. RENDER

4. LISTENER (Evento externo)
   ├─ Otro componente dispara: dispatch('donationCreated')
   ├─ ListaDonaciones escucha: protected $listeners = ['donationCreated' => '$refresh']
   ├─ Ejecuta $refresh()
   └─ Volver a 2. RENDER

5. VALIDACIÓN EN TIEMPO REAL (En CrearDonacion)
   ├─ Usuario escribe en input
   ├─ wire:model.live="titulo"
   ├─ updated('titulo') es llamado
   ├─ $this->validateOnly('titulo')
   ├─ Si error: mostrar
   └─ Si ok: limpiar error
```

---

## 🛣️ Rutas Disponibles

```
WEB ROUTES:
═══════════════════════════════════════════════════════

GET  /                          
     → welcome.blade.php
     → Página pública

GET  /register                  
     → Formulario de registro (Fortify)

GET  /login                     
     → Página de login (Fortify)

═════════════════════════════════════════════════════════
RUTAS PROTEGIDAS (auth:verified middleware)
═════════════════════════════════════════════════════════

GET  /dashboard                 
     → dashboard.blade.php
     → Panel principal

GET  /donaciones                
     → pages/donaciones/lista.blade.php
     → ListaDonaciones component
     → CrearDonacion component

GET  /donaciones/gestionar      
     → pages/donaciones/gestionar.blade.php
     → GestionSolicitudes component

GET  /donaciones/historial      
     → pages/donaciones/historial.blade.php
     → HistorialUsuario component

GET  /settings (Si existen)
     → Configuración de usuario
```

---

## 📦 Estructura de Carpetas Completa

```
DonaRed/
│
├── app/
│   ├── Livewire/
│   │   └── Donations/
│   │       ├── ListaDonaciones.php
│   │       ├── CrearDonacion.php
│   │       ├── SolicitarDonacion.php
│   │       ├── GestionSolicitudes.php
│   │       └── HistorialUsuario.php
│   │
│   ├── Models/
│   │   ├── User.php (actualizado)
│   │   ├── Donation.php
│   │   └── DonationRequest.php
│   │
│   ├── Actions/
│   ├── Http/
│   ├── Providers/
│   └── (otros)
│
├── database/
│   ├── migrations/
│   │   ├── 2025_03_28_000001_create_donations_table.php
│   │   └── 2025_03_28_000002_create_requests_table.php
│   │
│   ├── factories/
│   │   ├── UserFactory.php
│   │   ├── DonationFactory.php
│   │   └── DonationRequestFactory.php
│   │
│   └── seeders/
│       └── DonationSeeder.php
│
├── resources/views/
│   ├── layouts/
│   │   ├── app/
│   │   │   ├── sidebar.blade.php (actualizado)
│   │   │   └── header.blade.php
│   │   └── app.blade.php
│   │
│   ├── livewire/donations/
│   │   ├── lista-donaciones.blade.php
│   │   ├── crear-donacion.blade.php
│   │   ├── solicitar-donacion.blade.php
│   │   ├── gestion-solicitudes.blade.php
│   │   └── historial-usuario.blade.php
│   │
│   ├── pages/donaciones/
│   │   ├── lista.blade.php
│   │   ├── gestionar.blade.php
│   │   └── historial.blade.php
│   │
│   ├── dashboard.blade.php (actualizado)
│   └── welcome.blade.php
│
├── routes/
│   ├── web.php (actualizado)
│   └── settings.php
│
├── config/
├── bootstrap/
├── storage/
├── tests/
├── vendor/
│
└── Documentación:
    ├── DONARED_SETUP.md
    ├── DONARED_EJEMPLOS.md
    ├── DONARED_CHECKLIST.md
    ├── DONARED_EXTENSIONES.md
    ├── DONARED_RESUMEN.md
    ├── QUICK_START.md
    └── README.md
```

---

## 🔐 Flujo de Autenticación

```
USUARIO NO AUTENTICADO
═══════════════════════════════════════════════════════

Accede a /donaciones
    ↓
Laravel Middleware: auth:verified
    ↓
¿Autenticado? NO
    ↓
Redirect a /login


USUARIO AUTENTICADO
═══════════════════════════════════════════════════════

Accede a /donaciones
    ↓
Middleware: auth:verified
    ↓
¿Autenticado? SÍ
¿Email verificado? SÍ
    ↓
Carga aplicación
    ↓
auth()->user() disponible en componentes


CHECK EN COMPONENTES
═══════════════════════════════════════════════════════

En ListaDonaciones:
  @if (auth()->check())
      // Mostrar botón de solicitar
  @else
      // Mostrar link de login

En SolicitarDonacion:
  if ( $this->donation->user_id === auth()->id())
      // Error: no puedes solicitar propios
```

---

## 💾 Flujo de Datos: Crear Donación

```
┌─────────────────────────────────────────────────────────┐
│ 1. USUARIO ABRE FORMULARIO                              │
│    Click: "+ Publicar Donación"                        │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 2. COMPONENTE: CrearDonacion                           │
│    wire:click="$set('showForm', true)"                 │
│    Renderiza formulario (sin recargar)                │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 3. USUARIO RELLENA CAMPOS                               │
│    wire:model="titulo"        → updated('titulo')      │
│    wire:model="descripcion"   → updated('descripcion') │
│    wire:model="tipo"          → updated('tipo')        │
│    Validación en tiempo real: validateOnly()          │
│    Mostrar errores si aplica                           │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 4. USUARIO ENVÍA FORMULARIO                             │
│    Click: "✓ Publicar Donación"                        │
│    wire:submit="guardarDonacion"                       │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 5. MÉTODO: gaudarDonacion()                             │
│    • Validar todas las propiedades                     │
│    • Si error: mostrar y salir                         │
│    • Si ok: continuar                                  │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 6. CREAR EN BD                                          │
│    Donation::create([                                   │
│      'titulo' => $this->titulo,                        │
│      'descripcion' => $this->descripcion,             │
│      'tipo' => $this->tipo,                           │
│      'user_id' => auth()->id(),                       │
│    ])                                                   │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 7. DISPARAR EVENTO                                      │
│    $this->dispatch('donationCreated')                   │
│    ->to(ListaDonaciones::class)                        │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 8. COMPONENTE: ListaDonaciones                         │
│    Escucha: protected $listeners = [                   │
│      'donationCreated' => '$refresh'                   │
│    ]                                                    │
│    Ejecuta: render() nuevamente                        │
│    getDonaciones() ahora incluye la nueva              │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 9. ACTUALIZAR UI                                        │
│    • Grid se actualiza con nueva donación             │
│    • Se ve en la lista sin recargar página            │
│    • Otros usuarios ven automáticamente si refresca    │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ 10. NOTIFICACIÓN                                        │
│     dispatch('notify', [                               │
│       'type' => 'success',                             │
│       'message' => '✓ ¡Donación creada!'             │
│     ])                                                  │
│     Flash message aparece (2 segundos)                │
└─────────────────────────────────────────────────────────┘
```

---

## 🎨 Capas de UI

```
┌─────────────────────────────────────────────────────────┐
│                  TAILWIND CSS                           │
│   Grid system, responsive, dark mode, etc.             │
└─────────────────────────────────────────────────────────┘
                          ↑
┌─────────────────────────────────────────────────────────┐
│                FLUX COMPONENTS                          │
│  sidebar, header, menu, profile, dropdown, etc.        │
└─────────────────────────────────────────────────────────┘
                          ↑
┌─────────────────────────────────────────────────────────┐
│                  BLADE TEMPLATES                        │
│  layouts, pages, components customizados              │
└─────────────────────────────────────────────────────────┘
                          ↑
┌─────────────────────────────────────────────────────────┐
│              LIVEWIRE COMPONENTS                        │
│  Lógica interactive, validación, eventos              │
└─────────────────────────────────────────────────────────┘
                          ↑
┌─────────────────────────────────────────────────────────┐
│                   JAVASCRIPT                           │
│  AJAX requests automático, eventos, interactividad    │
└─────────────────────────────────────────────────────────┘
```

---

**Diagrama completado. Ahora entiendes toda la arquitectura de DonaRed.** 🎉
