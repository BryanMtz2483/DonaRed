# DonaRed 🎁 - Sistema de Donaciones Locales

> **Un sistema moderno, intuitive y completamente funcional para facilitar el intercambio de donaciones entre miembros de una comunidad.**

[![Laravel](https://img.shields.io/badge/Laravel-13.0-red.svg?style=flat-square)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-4.1-blue.svg?style=flat-square)](https://livewire.laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3%2B-purple.svg?style=flat-square)](https://www.php.net)

---

## 🎯 ¿Qué es DonaRed?

DonaRed es una plataforma web que conecta personas en una comunidad para intercambiar donaciones de forma fácil, segura y sin intermediarios. Cualquier usuario puede:

- 🎁 **Publicar** lo que desee donar
- 👋 **Solicitar** donaciones que necesita
- 📋 **Gestionar** solicitudes dinámicamente
- 📊 **Rastrear** el historial de actividades

**Todo sin recargar la página** gracias a Livewire.

---

## ✨ Características Principales

### 🚀 Para Usuarios

| Feature | Descripción |
|---------|------------|
| 🔐 **Autenticación** | Registro e inicio de sesión seguro |
| 🎁 **Publicar** | Crear donaciones con título, descripción y tipo |
| 👁️ **Listar** | Ver donaciones disponibles con filtros en tiempo real |
| 👋 **Solicitar** | Pedir donaciones sin crear cuenta nueva |
| 📋 **Gestionar** | Aceptar/rechazar solicitudes dinámicamente |
| 📊 **Historial** | Rastrear todas tus donaciones y solicitudes |
| 🎨 **Responsive** | Funciona en mobile, tablet y desktop |

### 🔧 Para Desarrolladores

- ✅ **Código Limpio** - Arquitectura MVC bien estructurada
- ✅ **Componentes Reutilizables** - 5 componentes Livewire
- ✅ **Bien Documentado** - 8 documentos de referencia
- ✅ **Fácil de Extender** - Guía con 10 mejoras futuras
- ✅ **Best Practices** - Usando patrones Laravel modernos
- ✅ **Validaciones** - En cliente y servidor
- ✅ **Relaciones BD** - Modelos con Eloquent

---

## 🏗️ Stack Tecnológico

### Backend
```
PHP 8.3+ → Laravel 13 → Eloquent ORM → MySQL/PostgreSQL/SQLite
```

### Frontend
```
Blade Templates → TailwindCSS → Livewire 4.1 → Flux Components → JavaScript
```

### Tools
```
Composer → NPM → Vite → PHPUnit/Pest → Git
```

---

## 📦 Contenido del Proyecto

### Código
- **3 Modelos** Eloquent con relaciones completas
- **5 Componentes** Livewire funcionales
- **8+ Vistas** Blade responsivas
- **2 Migraciones** para base de datos
- **2 Factories** para datos de prueba
- **1 Seeder** con 20+ registros

### Documentación
- **QUICK_START.md** - Empezar en 5 minutos
- **DONARED_SETUP.md** - Guía de instalación completa
- **DONARED_EJEMPLOS.md** - 10 casos prácticos
- **DONARED_CHECKLIST.md** - 50+ items de verificación
- **DONARED_EXTENSIONES.md** - Mejoras futuras
- **ARCHITECTURE.md** - Diagrama de sistema
- **MAPA_PROYECTO.md** - Referencias rápidas

---

## 🚀 Quick Start

### 1. Clone y Configure
```bash
cd DonaRed
cp .env.example .env
php artisan key:generate
```

### 2. Base de Datos
Edita `.env` con tu configuración:
```env
DB_CONNECTION=mysql
DB_DATABASE=donared
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Instala Todo
```bash
composer install
npm install
npm run build
php artisan migrate
php artisan db:seed --class=DonationSeeder
```

### 4. Inicia Servidor
```bash
php artisan serve, aunue recomiendo más "composer run dev"
```

Abre: **http://localhost:8000** ✅

---

## 📚 Documentación

Lee estos archivos en orden:

1. **[QUICK_START.md](QUICK_START.md)** ⚡ - 5 minutos
2. **[DONARED_SETUP.md](DONARED_SETUP.md)** 📖 - Setup detallado
3. **[ARCHITECTURE.md](ARCHITECTURE.md)** 🏗️ - Entender estructura
4. **[MAPA_PROYECTO.md](MAPA_PROYECTO.md)** 🗺️ - Referencias rápidas
5. **[DONARED_EJEMPLOS.md](DONARED_EJEMPLOS.md)** 💡 - Casos de uso
6. **[DONARED_CHECKLIST.md](DONARED_CHECKLIST.md)** ✅ - Verificación

---

## 🎯 Casos de Uso

### 👩‍🦰 María: Donadora
1. Se registra en DonaRed
2. Publica 2 kits de comida que no usará
3. Recibe 3 solicitudes en 2 horas
4. Acepta una y entrega personalmente
5. Marca como entregada en la app

### 👨‍👦 Carlos: Solicitante
1. Ve donaciones disponibles en su zona
2. Encuentra libros para sus hijos
3. Solicita 3 opciones diferentes
4. Una es aceptada en 30 minutos
5. Retira personalmente y queda registrado

### 🏛️ ONG: Organización
1. Crea cuenta organizacional
2. Publica donaciones en nombre de beneficiarios
3. Coordina entregas
4. Mide impacto social con datos

---

## 🗄️ Base de Datos

### Tablas
```sql
users (id, name, email, password, timestamps)
donations (id, titulo, descripcion, tipo, estado, user_id, timestamps)
requests (id, donation_id, user_id, estado, timestamps)
```

### Estados de Donación
- ✅ `disponible` - Abierto a solicitudes
- ⏳ `en_proceso` - Solicitud aceptada
- 📦 `entregada` - Ya entregado

### Estados de Solicitud
- ⏳ `pendiente` - Esperando respuesta
- ✅ `aceptada` - Aprobado
- ❌ `rechazada` - No aprobado

---

## 🔐 Seguridad

- ✅ **Autenticación** con Laravel Fortify
- ✅ **Autorización** basada en usuario
- ✅ **CSRF Protection** automático
- ✅ **SQL Injection** prevenido (ORM)
- ✅ **XSS Protection** (Blade escaping)
- ✅ **Hashing** de contraseñas con bcrypt

---

## 🛠️ Archivos Principales

```
app/
├── Livewire/Donations/          # Componentes interactivos
├── Models/                       # Modelos Eloquent
└── Providers/                    # Service Providers

database/
├── migrations/                   # Estructura de BD
├── factories/                    # Datos fake
└── seeders/                      # Popular datos

resources/views/
├── layouts/                      # Layouts principales
├── livewire/                     # Vistas de componentes
└── pages/                        # Páginas principales

routes/
└── web.php                       # Rutas públicas

DOCUMENTACIÓN (en raíz):
├── DONARED_SETUP.md
├── DONARED_EJEMPLOS.md
├── ARCHITECTURE.md
├── MAPA_PROYECTO.md
└── ... (más)
```

---

## 📊 Estadísticas

```
Líneas de Código:     4500+
Modelos:              3
Componentes:          5
Vistas:               8+
Funcionalidades:      15+
Documentación:        8 archivos
```

---

## 🎓 Aprende con DonaRed

Este proyecto es perfecto para aprender:

- ✅ **Laravel 13** - Último framework PHP
- ✅ **Livewire 4.1** - Componentes reactivos
- ✅ **Eloquent ORM** - Base de datos moderna
- ✅ **Blade Templating** - Vistas elegantes
- ✅ **TailwindCSS** - Estilos responsive
- ✅ **Architecture Patterns** - MVC limpio

---

## 🚀 Próximos Pasos

Después de instalar, considera:

1. **Notificaciones por Email** - Alertar cambios
2. **Geolocalización** - Ver donaciones cerca
3. **Sistema de Calificaciones** - Valorar usuarios
4. **Chat entre Usuarios** - Comunicación directa
5. **Dashboard Admin** - Estadísticas globales
6. **Aplicación Móvil** - React Native
7. **Despliegue** - Producción

Ver [DONARED_EXTENSIONES.md](DONARED_EXTENSIONES.md) para detalles.

---

## 🤝 Contribuciones

¿Quieres mejorar DonaRed?

1. Fork el proyecto
2. Crea rama (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre Pull Request

---

## ❓ FAQ

**P: ¿Necesito pagar para usar DonaRed?**
R: No, es completamente gratuito. Solo necesitas servidores para hospedar.

**P: ¿Puedo personalizar los colores?**
R: Sí, edita `tailwind.config.js` o archivos Blade.

**P: ¿Cómo agrego más tipos de donación?**
R: Actualiza el enum en la migración y componentes.

**P: ¿Soporta múltiples idiomas?**
R: No yet, pero es fácil agregar con Laravel localization.

**P: ¿Puedo vender esto?**
R: Sí, está bajo licencia MIT.

---

## 📄 Licencia

Este proyecto está bajo licencia **MIT**. Eres libre de:
- ✅ Usar comercialmente
- ✅ Modificar
- ✅ Distribuir
- ✅ Usar en privado

[Ver licencia completa](LICENSE)

---

## 📞 Soporte

- **Documentación**: Revisar archivos `.md` en raíz
- **Issues**: Crear issue en GitHub
- **Ejemplos**: Ver [DONARED_EJEMPLOS.md](DONARED_EJEMPLOS.md)
- **Checklist**: Usar [DONARED_CHECKLIST.md](DONARED_CHECKLIST.md)

---

## 🙏 Agradecimientos

Gracias a:
- **Laravel Community** - Excelente framework
- **Livewire** - Componentes reactivos
- **TailwindCSS** - Estilos hermosos
- **Flux** - Componentes pre-buildados

---

## 🌟 Si te gustó, da una ⭐!

```
  ╔═══════════════════════════════════════╗
  ║   ¡Gracias por usar DonaRed!          ║
  ║   Juntos hacemos comunidad             ║
  ║                                       ║
  ║   Síguenos y comparte este proyecto   ║
  ╚═══════════════════════════════════════╝
```

---

**Creado con ❤️ para conectar personas y cambiar vidas.**

*Última actualización: Marzo 2026*  
*Versión: 1.0.0*  
*Estado: Production Ready ✅*

---

## 📖 Índice de Documentación

| Archivo | Descripción |
|---------|-------------|
| [QUICK_START.md](QUICK_START.md) | Empezar en 5 minutos |
| [DONARED_SETUP.md](DONARED_SETUP.md) | Instalación detallada |
| [DONARED_EJEMPLOS.md](DONARED_EJEMPLOS.md) | Casos de uso prácticos |
| [DONARED_CHECKLIST.md](DONARED_CHECKLIST.md) | Verificación 50+ items |
| [DONARED_RESUMEN.md](DONARED_RESUMEN.md) | Resumen ejecutivo |
| [DONARED_EXTENSIONES.md](DONARED_EXTENSIONES.md) | Mejoras futuras |
| [ARCHITECTURE.md](ARCHITECTURE.md) | Diagrama de sistema |
| [MAPA_PROYECTO.md](MAPA_PROYECTO.md) | Referencias rápidas |

---

**¿Listo para comenzar?** → Ve a [QUICK_START.md](QUICK_START.md) ⚡
