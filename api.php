<?php
// ============================================================
// API — Backend con SQLite (no requiere configuración)
// ============================================================
require_once __DIR__ . '/config.php';

session_start();
header('Content-Type: application/json; charset=utf-8');

// --- Inicializar BD si no existe ---
function getDB() {
    $isNew = !file_exists(DB_FILE);
    $db = new PDO('sqlite:' . DB_FILE);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($isNew) {
        $db->exec("
            CREATE TABLE events (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                start_date TEXT,
                start_time TEXT,
                end_date TEXT,
                end_time TEXT,
                place TEXT,
                activity TEXT,
                type TEXT,
                cost TEXT,
                notes TEXT,
                url TEXT,
                city TEXT,
                tentative INTEGER DEFAULT 0,
                sort_order INTEGER DEFAULT 0,
                updated_at TEXT,
                place_id INTEGER
            )
        ");
    } else {
        // Migración: agregar place_id si no existe
        try { $db->exec("ALTER TABLE events ADD COLUMN place_id INTEGER"); } catch (Exception $e) {}
    }

    // Crear tabla de lugares turísticos
    $db->exec("
        CREATE TABLE IF NOT EXISTS places (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            city TEXT,
            description TEXT,
            duration_min INTEGER,
            address TEXT,
            lat REAL,
            lng REAL,
            wikipedia_title TEXT,
            images TEXT
        )
    ");

    // Migraciones de columnas en places (seguras para BD existente)
    $wikiAdded = false;
    try { $db->exec("ALTER TABLE places ADD COLUMN wikipedia_title TEXT"); $wikiAdded = true; } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE places ADD COLUMN images TEXT"); } catch (Exception $e) {}

    // Sembrar lugares si la tabla está vacía
    $count = $db->query("SELECT COUNT(*) FROM places")->fetchColumn();
    $jsonFile = __DIR__ . '/places.json';
    if ($count == 0 && file_exists($jsonFile)) {
        $places = json_decode(file_get_contents($jsonFile), true) ?: [];
        $stmt = $db->prepare("
            INSERT INTO places (name, city, description, duration_min, address, lat, lng, wikipedia_title, images)
            VALUES (:name, :city, :description, :duration_min, :address, :lat, :lng, :wikipedia_title, :images)
        ");
        foreach ($places as $p) {
            $stmt->execute([
                ':name'            => $p['name'] ?? '',
                ':city'            => $p['city'] ?? '',
                ':description'     => $p['description'] ?? '',
                ':duration_min'    => isset($p['duration_min']) ? intval($p['duration_min']) : null,
                ':address'         => $p['address'] ?? '',
                ':lat'             => isset($p['lat']) ? floatval($p['lat']) : null,
                ':lng'             => isset($p['lng']) ? floatval($p['lng']) : null,
                ':wikipedia_title' => $p['wikipedia_title'] ?? null,
                ':images'          => isset($p['images']) ? json_encode($p['images']) : null,
            ]);
        }
    } elseif ($wikiAdded && file_exists($jsonFile)) {
        // Backfill wikipedia_title para places ya existentes
        $places = json_decode(file_get_contents($jsonFile), true) ?: [];
        $stmt = $db->prepare("UPDATE places SET wikipedia_title = :wt WHERE name = :name AND (wikipedia_title IS NULL OR wikipedia_title = '')");
        foreach ($places as $p) {
            if (!empty($p['wikipedia_title'])) {
                $stmt->execute([':wt' => $p['wikipedia_title'], ':name' => $p['name']]);
            }
        }
    }

    return $db;
}

// --- Helpers ---
function jsonInput() {
    return json_decode(file_get_contents('php://input'), true) ?: [];
}
function fail($msg, $code = 400) {
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $msg]);
    exit;
}
function ok($data = []) {
    echo json_encode(['ok' => true] + $data);
    exit;
}
function requireAuth() {
    if (empty($_SESSION['auth'])) fail('No autenticado', 401);
}

// --- Router ---
$action = $_GET['action'] ?? '';

try {
    switch ($action) {

        case 'login': {
            $in = jsonInput();
            if (($in['password'] ?? '') === SHARED_PASSWORD) {
                $_SESSION['auth'] = true;
                $_SESSION['user'] = trim($in['name'] ?? 'viajero') ?: 'viajero';
                ok(['user' => $_SESSION['user']]);
            }
            fail('Clave incorrecta', 401);
        }

        case 'logout': {
            $_SESSION = [];
            session_destroy();
            ok();
        }

        case 'me': {
            ok([
                'auth' => !empty($_SESSION['auth']),
                'user' => $_SESSION['user'] ?? null,
                'trip' => TRIP_NAME,
                'today' => date('Y-m-d'),
                'now' => date('Y-m-d H:i:s'),
            ]);
        }

        case 'list': {
            requireAuth();
            $db = getDB();
            $rows = $db->query("
                SELECT * FROM events
                ORDER BY
                    tentative ASC,
                    CASE WHEN start_date IS NULL OR start_date = '' THEN 1 ELSE 0 END,
                    start_date ASC,
                    start_time ASC,
                    sort_order ASC,
                    id ASC
            ")->fetchAll(PDO::FETCH_ASSOC);
            ok(['events' => $rows]);
        }

        case 'places': {
            requireAuth();
            $db = getDB();
            $city = $_GET['city'] ?? '';
            if ($city) {
                $stmt = $db->prepare("SELECT * FROM places WHERE city = ? ORDER BY name");
                $stmt->execute([$city]);
            } else {
                $stmt = $db->query("SELECT * FROM places ORDER BY city, name");
            }
            ok(['places' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        }

        case 'create': {
            requireAuth();
            $in = jsonInput();
            $db = getDB();
            $stmt = $db->prepare("
                INSERT INTO events
                (start_date, start_time, end_date, end_time, place, activity, type, cost, notes, url, city, tentative, sort_order, updated_at, place_id)
                VALUES
                (:start_date, :start_time, :end_date, :end_time, :place, :activity, :type, :cost, :notes, :url, :city, :tentative, :sort_order, :updated_at, :place_id)
            ");
            $stmt->execute([
                ':start_date' => $in['start_date'] ?? '',
                ':start_time' => $in['start_time'] ?? '',
                ':end_date'   => $in['end_date'] ?? '',
                ':end_time'   => $in['end_time'] ?? '',
                ':place'      => $in['place'] ?? '',
                ':activity'   => $in['activity'] ?? '',
                ':type'       => $in['type'] ?? 'Actividad',
                ':cost'       => $in['cost'] ?? '',
                ':notes'      => $in['notes'] ?? '',
                ':url'        => $in['url'] ?? '',
                ':city'       => $in['city'] ?? '',
                ':tentative'  => !empty($in['tentative']) ? 1 : 0,
                ':sort_order' => intval($in['sort_order'] ?? 0),
                ':updated_at' => date('Y-m-d H:i:s'),
                ':place_id'   => ($in['place_id'] ?? null) ? intval($in['place_id']) : null,
            ]);
            ok(['id' => $db->lastInsertId()]);
        }

        case 'update': {
            requireAuth();
            $in = jsonInput();
            $id = intval($in['id'] ?? 0);
            if (!$id) fail('Falta id');
            $db = getDB();
            $stmt = $db->prepare("
                UPDATE events SET
                    start_date = :start_date,
                    start_time = :start_time,
                    end_date   = :end_date,
                    end_time   = :end_time,
                    place      = :place,
                    activity   = :activity,
                    type       = :type,
                    cost       = :cost,
                    notes      = :notes,
                    url        = :url,
                    city       = :city,
                    tentative  = :tentative,
                    sort_order = :sort_order,
                    updated_at = :updated_at,
                    place_id   = :place_id
                WHERE id = :id
            ");
            $stmt->execute([
                ':id'         => $id,
                ':start_date' => $in['start_date'] ?? '',
                ':start_time' => $in['start_time'] ?? '',
                ':end_date'   => $in['end_date'] ?? '',
                ':end_time'   => $in['end_time'] ?? '',
                ':place'      => $in['place'] ?? '',
                ':activity'   => $in['activity'] ?? '',
                ':type'       => $in['type'] ?? 'Actividad',
                ':cost'       => $in['cost'] ?? '',
                ':notes'      => $in['notes'] ?? '',
                ':url'        => $in['url'] ?? '',
                ':city'       => $in['city'] ?? '',
                ':tentative'  => !empty($in['tentative']) ? 1 : 0,
                ':sort_order' => intval($in['sort_order'] ?? 0),
                ':updated_at' => date('Y-m-d H:i:s'),
                ':place_id'   => ($in['place_id'] ?? null) ? intval($in['place_id']) : null,
            ]);
            ok();
        }

        case 'delete': {
            requireAuth();
            $in = jsonInput();
            $id = intval($in['id'] ?? 0);
            if (!$id) fail('Falta id');
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM events WHERE id = :id");
            $stmt->execute([':id' => $id]);
            ok();
        }

        case 'assign_date': {
            // Asignar fecha a un evento tentativo (lo saca de "Por asignar")
            requireAuth();
            $in = jsonInput();
            $id = intval($in['id'] ?? 0);
            if (!$id) fail('Falta id');
            $db = getDB();
            $stmt = $db->prepare("
                UPDATE events SET
                    start_date = :start_date,
                    start_time = :start_time,
                    tentative = 0,
                    updated_at = :updated_at
                WHERE id = :id
            ");
            $stmt->execute([
                ':id'         => $id,
                ':start_date' => $in['start_date'] ?? '',
                ':start_time' => $in['start_time'] ?? '',
                ':updated_at' => date('Y-m-d H:i:s'),
            ]);
            ok();
        }

        default:
            fail('Acción desconocida: ' . $action);
    }
} catch (Exception $e) {
    fail('Error: ' . $e->getMessage(), 500);
}
