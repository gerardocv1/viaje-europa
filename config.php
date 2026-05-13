<?php
// ============================================================
// CONFIGURACIÓN — EDITA ESTOS VALORES
// ============================================================

// Clave compartida (tú y tu pareja la usan para entrar)
// CÁMBIALA por algo que solo ustedes sepan
define('SHARED_PASSWORD', 'europa2026');

// Nombre del archivo de base de datos (no lo cambies a menos que sepas)
define('DB_FILE', __DIR__ . '/itinerario.db');

// Nombre del viaje (se muestra en el header)
define('TRIP_NAME', 'Europa 2026');

// Zona horaria para mostrar "hoy" correctamente
// Durante el viaje puedes cambiarla a 'Europe/Madrid', 'Europe/Paris', etc.
date_default_timezone_set('America/Bogota');
