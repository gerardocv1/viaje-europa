<?php
// ============================================================
// INIT — Carga inicial de datos desde seed.json
// Ejecutar UNA SOLA VEZ desde el navegador, luego BORRAR este archivo
// ============================================================
require_once __DIR__ . '/config.php';

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

// ── Si ya hay datos, pedir contraseña antes de continuar ──
$authed = false;
$authError = '';
if ($existing > 0) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['password']) && $_POST['password'] === SHARED_PASSWORD) {
            $authed = true;
        } else {
            $authError = 'Contraseña incorrecta.';
        }
    }

    if (!$authed) {
        // Mostrar formulario de contraseña
        ?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Init — confirmación</title>
<style>
  body { font-family: system-ui, sans-serif; max-width: 480px; margin: 60px auto; padding: 20px; line-height: 1.6; background: #0f0f12; color: #e8e4de; }
  h2 { margin-bottom: 6px; }
  p  { color: #9a9aa8; font-size: 14px; }
  .warning { background: rgba(217,104,104,.12); border: 1px solid #d96868; border-radius: 8px; padding: 14px 18px; margin: 24px 0; font-size: 14px; color: #e89898; }
  label { display: block; font-size: 11px; letter-spacing: .15em; text-transform: uppercase; color: #5e5e6c; margin-bottom: 8px; margin-top: 20px; }
  input[type=password] { width: 100%; padding: 12px 14px; background: #1c1c24; border: 1px solid #2a2a36; border-radius: 6px; color: #f0ece6; font-size: 16px; outline: none; box-sizing: border-box; }
  input[type=password]:focus { border-color: #e9a36b; }
  button { margin-top: 20px; width: 100%; padding: 14px; background: #d96868; color: #fff; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; cursor: pointer; }
  .err { color: #d96868; font-size: 13px; margin-top: 10px; min-height: 18px; }
</style>
</head>
<body>
  <h2>⚠️ Base de datos existente</h2>
  <p>Ya hay <strong><?= $existing ?> eventos</strong> cargados. Continuar borrará todos los datos y recargará el seed.</p>
  <div class="warning">Esta acción es irreversible. Confirma con la clave compartida de la app.</div>
  <form method="POST">
    <label for="pw">Clave compartida</label>
    <input type="password" id="pw" name="password" autofocus autocomplete="current-password">
    <div class="err"><?= htmlspecialchars($authError) ?></div>
    <button type="submit">Confirmar y recargar datos</button>
  </form>
</body>
</html>
<?php
        exit;
    }

    // Autenticado — borrar datos existentes antes de reinsertar
    $db->exec("DELETE FROM events");
    $db->exec("DELETE FROM sqlite_sequence WHERE name='events'");
}

// ── Cargar seed ──
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
?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Init — listo</title>
<style>
  body { font-family: system-ui, sans-serif; max-width: 480px; margin: 60px auto; padding: 20px; line-height: 1.6; background: #0f0f12; color: #e8e4de; }
  code { background: #1c1c24; padding: 2px 6px; border-radius: 4px; font-size: 13px; }
  a { color: #e9a36b; }
</style>
</head>
<body>
  <h2>✅ Listo</h2>
  <p>Cargados <strong><?= $count ?> eventos</strong> en la base de datos.</p>
  <p><strong>⚠️ Ahora borra <code>init.php</code> y <code>seed.json</code> del servidor</strong> por seguridad.</p>
  <p><a href="index.php">Abrir la app →</a></p>
</body>
</html>
