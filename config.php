<?php
// ============================================================
// CONFIGURACIÓN — EDITA ESTOS VALORES
// ============================================================

// Clave compartida (tú y tu pareja la usan para entrar)
// CÁMBIALA por algo que solo ustedes sepan
define('SHARED_PASSWORD', 'europa2026');

// Base de datos en carpeta separada para que no se sobreescriba en cada deploy
define('DB_FILE', __DIR__ . '/data/itinerario.db');

// Nombre del viaje (se muestra en el header)
define('TRIP_NAME', 'Europa 2026');

// Zona horaria para mostrar "hoy" correctamente
// Durante el viaje puedes cambiarla a 'Europe/Madrid', 'Europe/Paris', etc.
date_default_timezone_set('America/Bogota');
