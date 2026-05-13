# Itinerario Europa 2026 — Contexto del proyecto

App web móvil para gestionar un itinerario de viaje compartido entre dos personas (Gerardo y su pareja). Stack mínimo, sin frameworks, lista para correr en cualquier hosting con PHP.

---

## Propósito

Visualizar y editar desde el celular el itinerario de un viaje a Europa (14–29 de mayo 2026: Madrid → París → Milán → Roma → Bilbao → Madrid → Bogotá). Dos personas la usan simultáneamente, con cambios sincronizados a través del servidor. La fuente original fue un Excel; los datos viven ahora en la base.

---

## Stack

- **Backend:** PHP 8+ con PDO_SQLite (sin MySQL, sin frameworks)
- **Base de datos:** SQLite en un archivo único (`itinerario.db`)
- **Frontend:** HTML/CSS/JS vanilla, single-file (`index.php`)
- **Auth:** clave compartida + sesiones PHP nativas (sin usuarios individuales)
- **Despliegue:** subir archivos por FTP a cualquier hosting con PHP. Alternativamente, `start.sh` levanta el server local en `php -S`.
  Decisiones tomadas y descartadas (no proponer cambios sin razón fuerte):

- ❌ Google Sheets como fuente en vivo → descartado: requiere publicar como CSV público, perdemos privacidad de números de reserva, no permite editar desde la app.
- ❌ Firebase → descartado: setup demasiado complejo para un viaje de 2 semanas.
- ❌ MySQL → descartado: SQLite cubre el caso de uso sin configurar nada.
- ❌ React/Vue/build steps → descartado: el usuario quiere algo simple, archivos planos.
- ✅ PHP + SQLite + HTML vanilla — perfecto para el caso de uso temporal.

---

## Estructura de archivos

```
itinerario/
├── config.php       # Clave compartida, nombre del viaje, timezone
├── api.php          # Endpoints JSON: login, logout, me, list, create, update, delete, assign_date
├── index.php        # SPA completa (HTML + CSS + JS inline)
├── init.php         # Carga seed.json a la BD. Se corre una vez y se borra del servidor.
├── seed.json        # 64 eventos pre-procesados del Excel original
├── itinerario.db    # SQLite (se crea automáticamente al correr init.php)
├── start.sh         # Script bash para arrancar localmente (Mac/Linux)
├── start.bat        # Equivalente Windows
└── README.md        # Instrucciones de despliegue para el usuario final
```

---

## Esquema de la base

Tabla única: `events`

| Columna      | Tipo                     | Notas                                                                                     |
| ------------ | ------------------------ | ----------------------------------------------------------------------------------------- |
| `id`         | INTEGER PK AUTOINCREMENT |                                                                                           |
| `start_date` | TEXT                     | `YYYY-MM-DD` o vacío                                                                      |
| `start_time` | TEXT                     | `HH:MM` o vacío                                                                           |
| `end_date`   | TEXT                     | `YYYY-MM-DD` o vacío                                                                      |
| `end_time`   | TEXT                     | `HH:MM` o vacío                                                                           |
| `place`      | TEXT                     | Lugar/dirección (ej. "Madrid → París")                                                    |
| `activity`   | TEXT                     | Nombre del evento (campo principal)                                                       |
| `type`       | TEXT                     | Uno de: Vuelo, Tren, Traslado, Hospedaje, Actividad, Comida, Desplazamiento, Seguro, Otro |
| `cost`       | TEXT                     | "$X,XXX,XXX" formato libre                                                                |
| `notes`      | TEXT                     | Notas libres                                                                              |
| `url`        | TEXT                     | Link a reserva (Booking, Airbnb, Omio, etc.)                                              |
| `city`       | TEXT                     | Madrid / Paris / Milan / Roma / Bilbao (case-sensitive, importante para el filtro)        |
| `tentative`  | INTEGER (0/1)            | 1 = va a sección "Por asignar"                                                            |
| `sort_order` | INTEGER                  | Para ordenar empates dentro de un día                                                     |
| `updated_at` | TEXT                     | Timestamp ISO                                                                             |

Ordenamiento de `list`:

```sql
ORDER BY tentative ASC,
         CASE WHEN start_date IS NULL OR start_date = '' THEN 1 ELSE 0 END,
         start_date ASC,
         start_time ASC,
         sort_order ASC,
         id ASC
```

---

## API (api.php)

Todas las requests devuelven JSON `{ok: bool, error?: string, ...payload}`. Todas excepto `login`, `logout` y `me` requieren sesión autenticada.

| Acción                | Método | Body                           | Devuelve                             |
| --------------------- | ------ | ------------------------------ | ------------------------------------ |
| `?action=login`       | POST   | `{name, password}`             | `{ok, user}`                         |
| `?action=logout`      | POST   | —                              | `{ok}`                               |
| `?action=me`          | GET    | —                              | `{ok, auth, user, trip, today, now}` |
| `?action=list`        | GET    | —                              | `{ok, events: [...]}`                |
| `?action=create`      | POST   | event fields                   | `{ok, id}`                           |
| `?action=update`      | POST   | `{id, ...fields}`              | `{ok}`                               |
| `?action=delete`      | POST   | `{id}`                         | `{ok}`                               |
| `?action=assign_date` | POST   | `{id, start_date, start_time}` | `{ok}`                               |

Notas:

- `today` se devuelve desde el servidor (PHP `date('Y-m-d')` con `date_default_timezone_set` configurado en `config.php`). El frontend lo usa para resaltar el día actual.
- Sesiones PHP nativas con cookies (`session_start()` antes del header JSON).
- No hay hash de password; es comparación directa con `SHARED_PASSWORD` del config (suficiente para el caso de uso de 2 personas confiables).

---

## Frontend (index.php)

Un solo archivo. SPA mínima sin frameworks ni libs externas (salvo Google Fonts).

### Estados de UI

- `#login` — pantalla inicial; al autenticar se oculta y se muestra `#app`.
- `#app` — header sticky + nav de ciudades horizontal + main con días + FAB + modal.

### State global JS

```js
let STATE = {
  events: [], // todos los eventos del backend
  today: null, // 'YYYY-MM-DD' del servidor
  user: null, // nombre que ingresó al hacer login
  filterCity: "all", // filtro de ciudad activo
  editingId: null, // id del evento que está en el modal de edición; null = nuevo
};
```

### Render

`render()` agrupa eventos por `start_date` (los tentativos van aparte), renderiza un `DayGroup` por cada día con sus tarjetas ordenadas por hora. El día cuya fecha coincide con `STATE.today` recibe la clase `is-today` (fondo cálido sutil + badge "Hoy"). Días anteriores reciben `is-past` (opacity reducida).

### Tipos y colores (TYPE_META en JS)

```js
'Vuelo':          { icon: '✈️', color: '#7eb8d6' }   // azul
'Tren':           { icon: '🚆', color: '#a47fc7' }   // morado
'Traslado':       { icon: '🚕', color: '#d6c97e' }   // amarillo
'Hospedaje':      { icon: '🏨', color: '#e9a36b' }   // naranja (accent principal)
'Actividad':      { icon: '📍', color: '#8ec59a' }   // verde
'Comida':         { icon: '🍽️', color: '#e08074' }   // rojo coral
'Desplazamiento': { icon: '🚶', color: '#9a9aa8' }   // gris
'Seguro':         { icon: '🛡️', color: '#c7a47f' }   // beige
'Otro':           { icon: '⭐', color: '#c0b4d6' }   // lila
```

El color se aplica a la barra lateral de la tarjeta (`accent-bar`) y al borde del tag de tipo, vía CSS variable `--type-color`.

### Diseño visual

- **Tema:** oscuro, fondo `#0a0a0c`, acento terracota `#e9a36b`, "today" amarillo cálido `#f0c270`.
- **Tipografía:** Fraunces (display, serif italic) + IBM Plex Sans (body) + JetBrains Mono (timestamps). No usar Inter ni system-ui en titulares.
- **Layout:** mobile-first, max-width 720px, padding generoso, tarjetas con `border-radius: 8px`, modal bottom-sheet con slide-up animation.
- **Detalles:** grano sutil en background (SVG inline noise), backdrop-blur en header sticky, animaciones de modal con cubic-bezier suave.

### Modal

Bottom sheet único reutilizable para crear/editar. Si `STATE.editingId` está set, hace `update`; si null, hace `create`. Botón "Eliminar" solo visible en modo editar.

Campos del form (id en HTML): `f_activity, f_place, f_type, f_start_date, f_start_time, f_end_date, f_end_time, f_city, f_cost, f_notes, f_url, f_tentative`.

---

## Convenciones que el usuario espera

1. **Cero configuración para deployment**: subir archivos por FTP, correr `init.php` una vez, listo.
2. **Mobile-first siempre**: probar a 393px (iPhone 14). No agregar funciones que solo sirvan en desktop.
3. **Funcionar offline después de cargar** no es prioridad (el usuario aceptó que necesita conexión para sincronizar).
4. **Privacidad**: la clave compartida es la única barrera. No subir links de reservas a sitios públicos. No agregar telemetría ni analytics.
5. **Idioma:** español en toda la UI.
6. **Timezone:** se cambia en `config.php` con `date_default_timezone_set()`. Default: `America/Bogota`. Durante el viaje el usuario puede cambiarla a `Europe/Madrid`, `Europe/Paris`, `Europe/Rome` para que "Hoy" refleje su ubicación.

---

## Lo que NO debe hacer una nueva instancia de Claude sin preguntar

- ❌ Reemplazar SQLite por MySQL/Postgres
- ❌ Migrar a React/Vue/Svelte/Astro/etc.
- ❌ Agregar build steps (npm, webpack, tailwind compiler)
- ❌ Cambiar el esquema de la tabla `events` (rompería datos existentes)
- ❌ Cambiar la fuente Fraunces o el tema oscuro sin pedirlo el usuario
- ❌ Sugerir Google Sheets de nuevo (ya se descartó)
- ❌ Agregar dependencias npm/composer

---

## Lo que SÍ tiene sentido proponer/hacer

- ✅ Más tipos de eventos en `TYPE_META`
- ✅ Mejoras visuales sutiles (manteniendo el tema)
- ✅ Filtros adicionales (por tipo, por fecha)
- ✅ Export a iCal / Google Calendar
- ✅ Drag-and-drop para reordenar tentativos a días
- ✅ Modo "vista compacta" / "vista detallada"
- ✅ Totales/resúmenes (gasto total, días por ciudad)
- ✅ Mejor manejo de eventos multi-día (ej. hospedaje que cruza varios días)
- ✅ Mapa simple con marcadores por evento
- ✅ Backup/restore (export-import JSON)
- ✅ PWA con service worker para uso offline (si el usuario lo pide)

---

## Estado actual

- ✅ App funcional, probada end-to-end con Playwright en viewport iPhone
- ✅ 64 eventos cargados del Excel original incluyendo actividades sueltas distribuidas por día (Plaza Mayor, Torre Eiffel, Disney, Versalles, Coliseo, Vaticano, Guggenheim, etc. con horas tentativas)
- ✅ CRUD completo funcionando
- ✅ Login y sesiones funcionando
- ✅ Día actual resaltado
- ✅ Filtro por ciudad
- ✅ Script de arranque local (`start.sh` Mac/Linux, `start.bat` Windows)
- 🐛 Pendiente: usuario reporta que `start.sh` "no hace nada" en su Mac — falta diagnosticar (posiblemente CRLF line endings o problema de PATH de PHP). Comprobar con `bash -x ./start.sh` y `file start.sh`.

---

## Cuando el usuario te pida cambios

1. Si afecta el esquema de la BD: avisa que hay que migrar y propón un script
2. Si afecta el frontend: edita `index.php` directamente, NO partas el archivo
3. Si propone tecnologías nuevas: cuestiona antes de aceptar (el principio rector es "lo más simple que funcione")
4. Si reporta un bug: pídele la salida de consola del navegador o el log del servidor PHP antes de adivinar
