# Itinerario Europa 2026 — Instrucciones de despliegue

App web móvil para gestionar el itinerario del viaje, compartida entre tú y tu pareja.

---

## 📦 Archivos

| Archivo | Para qué sirve |
|---|---|
| `config.php` | Configuración: clave compartida, nombre del viaje, zona horaria |
| `api.php` | Backend: maneja login, crear/editar/borrar eventos |
| `index.php` | La app: lo que abrís en el celular |
| `init.php` | Script de carga inicial. **Se corre UNA vez y se borra.** |
| `seed.json` | Los 64 eventos del Excel ya procesados, con las actividades distribuidas por día |

---

## 🚀 Despliegue (5 minutos)

### Paso 1 — Editar la clave (obligatorio)

Abre `config.php` y **cambia** la línea:
```php
define('SHARED_PASSWORD', 'europa2026');
```
Pon una clave que solo tú y tu pareja sepan. Esa es la que van a usar para entrar.

### Paso 2 — Subir los 5 archivos al servidor

Sube **todos** estos archivos a la carpeta donde quieras que viva la app (puede ser un subdirectorio, ej. `/itinerario/`):

- `config.php`
- `api.php`
- `index.php`
- `init.php`
- `seed.json`

Por FTP, panel de control, lo que uses.

### Paso 3 — Ejecutar init UNA vez

Abre en el navegador:
```
https://tu-servidor.com/itinerario/init.php
```

Vas a ver: **✅ Cargados 64 eventos en la base de datos.**

Esto crea automáticamente el archivo `itinerario.db` (la base SQLite) junto a los otros archivos. **No necesitas configurar nada más.**

### Paso 4 — Borrar archivos sensibles del servidor

Una vez cargados los datos, **borra del servidor** (por seguridad):
- `init.php`
- `seed.json`

Sin estos no se puede recargar la BD ni ver los datos en bruto. Tu información queda solo en `itinerario.db`.

### Paso 5 — Compartir el link

Manda a tu pareja el link a `index.php` + la clave compartida. Listo.

```
URL: https://tu-servidor.com/itinerario/
Clave: (la que pusiste en config.php)
```

---

## 📱 Tip: agregar a la pantalla de inicio del celular

Para que se sienta como una app nativa:

**iPhone (Safari):** Compartir → "Añadir a pantalla de inicio"
**Android (Chrome):** menú ⋮ → "Añadir a pantalla de inicio"

Queda como ícono y se abre en pantalla completa.

---

## 🌍 Cambiar zona horaria durante el viaje

Si quieres que "Hoy" refleje la hora de donde estás (no de Bogotá), edita `config.php`:

```php
date_default_timezone_set('Europe/Madrid'); // España
date_default_timezone_set('Europe/Paris');  // Francia
date_default_timezone_set('Europe/Rome');   // Italia
```

---

## 🛡️ Backup

Tu información está en un solo archivo: `itinerario.db`. Bájalo de vez en cuando (por FTP) si quieres tener respaldo.

---

## ✨ Lo que tiene la app

- **Login compartido** con clave (tú y tu pareja)
- **Vista por días** con tarjetas, iconos por tipo (✈️🏨🚆🚕📍🍽️) y colores diferenciados
- **Día actual resaltado** automáticamente
- **Filtro por ciudad** (Madrid / París / Milán / Roma / Bilbao)
- **Tap a una tarjeta** para editar todos los campos
- **Botón +** para agregar evento nuevo
- **Botón calendario** del header para saltar al día de hoy
- **Botón refresh** para recargar (útil si el otro hizo cambios)
- **Links de reservas** clicables (Booking, Airbnb, Omio, etc.)
- **Sección "Por asignar"** para eventos tentativos sin fecha
- **Responsive móvil**, pensada primero para celular

---

## 🐛 Si algo no funciona

- **"500 Internal Server Error"**: revisa que tu servidor tenga PHP con PDO_SQLite. Casi todos los hostings lo traen, pero algunos viejos no.
- **"No autenticado"**: las cookies de sesión no se están guardando. Asegúrate de no abrir la app por `http://` mezclado con `https://`, usa siempre el mismo protocolo.
- **No veo los cambios que hizo mi pareja**: toca el botón de refresh ↻ del header.

---

## 📝 Notas sobre las actividades distribuidas

Las actividades sueltas del Excel original (Plaza Mayor, Torre Eiffel, etc.) las distribuí tentativamente así:

- **Madrid (15 may, tarde)**: Plaza Mayor → Puerta del Sol → Gran Vía → Cibeles → Alcalá → Retiro → España
- **París 16 may**: Torre Eiffel + Arco del Triunfo
- **París 17 may**: Louvre + Tullerías + Notre Dame + Shakespeare + Panteón + Luxemburgo + Sena
- **París 18 may**: Disneyland (ya estaba)
- **París 19 may**: Versalles + Galerías Lafayette + Montmartre
- **Milán 20 may (tarde)**: Duomo + Galería + Castillo Sforzesco
- **Milán 21 may**: Trenino del Bernina (ya estaba)
- **Roma 23 may**: Coliseo + Foro + Trastevere
- **Roma 24 may**: Vaticano + Castel Sant'Angelo
- **Roma 25 may (mañana)**: Trevi + Panteón + Navona + Plaza España
- **Bilbao 26 may**: Casco Viejo + Mercado Ribera + Zubizuri
- **Bilbao 27 may**: Guggenheim + Doña Casilda + San Mamés

Todas con horas tentativas. **Ajusta libremente desde la app**, tocando cada tarjeta.
