<?php
// ============================================================
// INIT — Carga inicial de datos desde seed.json
// Ejecutar UNA SOLA VEZ desde el navegador, luego BORRAR este archivo
// ============================================================
require_once __DIR__ . '/config.php';

// Protección básica: solo correr si la BD no existe o está vacía
$dbExists = file_exists(DB_FILE);
$db = new PDO('sqlite:' . DB_FILE);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Crear tabla si no existe
$db->exec("
    CREATE TABLE IF NOT EXISTS events (
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
        updated_at TEXT
    )
");

$existing = (int) $db->query("SELECT COUNT(*) FROM events")->fetchColumn();
if ($existing > 0) {
    die("⚠️  La BD ya tiene $existing eventos. Si quieres recargar, primero borra el archivo itinerario.db del servidor.<br><br>Si todo está bien, BORRA init.php del servidor por seguridad.");
}

$seedFile = __DIR__ . '/seed.json';
if (!file_exists($seedFile)) {
    die("❌ No se encuentra seed.json en el mismo directorio.");
}

$events = json_decode(file_get_contents($seedFile), true);
if (!is_array($events)) {
    die("❌ seed.json no es un JSON válido.");
}

$stmt = $db->prepare("
    INSERT INTO events
    (start_date, start_time, end_date, end_time, place, activity, type, cost, notes, url, city, tentative, sort_order, updated_at)
    VALUES
    (:start_date, :start_time, :end_date, :end_time, :place, :activity, :type, :cost, :notes, :url, :city, :tentative, :sort_order, :updated_at)
");

$now = date('Y-m-d H:i:s');
$count = 0;
$db->beginTransaction();
foreach ($events as $e) {
    $stmt->execute([
        ':start_date' => $e['start_date'] ?? '',
        ':start_time' => $e['start_time'] ?? '',
        ':end_date'   => $e['end_date'] ?? '',
        ':end_time'   => $e['end_time'] ?? '',
        ':place'      => $e['place'] ?? '',
        ':activity'   => $e['activity'] ?? '',
        ':type'       => $e['type'] ?? 'Actividad',
        ':cost'       => $e['cost'] ?? '',
        ':notes'      => $e['notes'] ?? '',
        ':url'        => $e['url'] ?? '',
        ':city'       => $e['city'] ?? '',
        ':tentative'  => !empty($e['tentative']) ? 1 : 0,
        ':sort_order' => intval($e['sort_order'] ?? 0),
        ':updated_at' => $now,
    ]);
    $count++;
}
$db->commit();

echo "<!DOCTYPE html><meta charset='utf-8'><style>body{font-family:system-ui;max-width:600px;margin:40px auto;padding:20px;line-height:1.6}</style>";
echo "<h2>✅ Listo</h2>";
echo "<p>Cargados <strong>$count eventos</strong> en la base de datos.</p>";
echo "<p><strong>⚠️ Ahora borra <code>init.php</code> y <code>seed.json</code> del servidor</strong> por seguridad.</p>";
echo "<p>Ya puedes abrir <a href='index.php'>index.php</a> para usar la app.</p>";
