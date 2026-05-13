<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="theme-color" content="#0a0a0c">
<title><?= htmlspecialchars(TRIP_NAME) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,500;9..144,600;9..144,700&family=IBM+Plex+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
  --bg: #0a0a0c;
  --bg-2: #131318;
  --bg-3: #1c1c24;
  --line: #2a2a36;
  --text: #f0ece6;
  --text-dim: #9a9aa8;
  --text-faint: #5e5e6c;
  --accent: #e9a36b;        /* terracota suave */
  --accent-2: #c47a4d;
  --today: #f0c270;
  --today-bg: rgba(240, 194, 112, 0.08);
  --danger: #d96868;
  --shadow: 0 8px 24px rgba(0,0,0,0.4);
}
* { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }
html, body { height: 100%; }
body {
  font-family: 'IBM Plex Sans', system-ui, sans-serif;
  background: var(--bg);
  color: var(--text);
  font-size: 15px;
  line-height: 1.5;
  padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
  overflow-x: hidden;
}
button, input, select, textarea { font-family: inherit; font-size: inherit; color: inherit; }
a { color: var(--accent); text-decoration: none; }
.mono { font-family: 'JetBrains Mono', monospace; }

/* ========== LOGIN ========== */
#login {
  min-height: 100vh; min-height: 100dvh;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  padding: 40px 24px;
  background: radial-gradient(ellipse at top, #1a1620 0%, var(--bg) 60%);
}
#login .brand {
  font-family: 'Fraunces', serif;
  font-weight: 400;
  font-size: 14px;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 20px;
}
#login h1 {
  font-family: 'Fraunces', serif;
  font-weight: 300;
  font-size: 56px;
  line-height: 0.95;
  letter-spacing: -0.02em;
  text-align: center;
  margin-bottom: 8px;
  font-style: italic;
}
#login h1 em {
  font-weight: 500;
  font-style: normal;
}
#login .sub {
  color: var(--text-dim);
  font-size: 14px;
  margin-bottom: 48px;
  text-align: center;
  letter-spacing: 0.05em;
}
#login form { width: 100%; max-width: 320px; }
#login label {
  display: block;
  font-size: 11px;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--text-faint);
  margin-bottom: 8px;
  margin-top: 20px;
}
#login input {
  width: 100%;
  padding: 14px 0;
  background: transparent;
  border: none;
  border-bottom: 1px solid var(--line);
  color: var(--text);
  font-size: 16px;
  outline: none;
  transition: border-color 0.2s;
}
#login input:focus { border-bottom-color: var(--accent); }
#login button {
  margin-top: 36px;
  width: 100%;
  padding: 16px;
  background: var(--accent);
  color: #1a0f08;
  border: none;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  cursor: pointer;
  border-radius: 2px;
  transition: background 0.15s;
}
#login button:hover { background: var(--accent-2); }
#login button:disabled { opacity: 0.5; cursor: wait; }
#login .err {
  color: var(--danger);
  font-size: 13px;
  margin-top: 16px;
  text-align: center;
  min-height: 18px;
}

/* ========== APP ========== */
#app { display: none; }
#app.active { display: block; min-height: 100vh; min-height: 100dvh; }

header.top {
  position: sticky; top: 0; z-index: 50;
  background: rgba(10, 10, 12, 0.85);
  backdrop-filter: blur(20px) saturate(1.2);
  -webkit-backdrop-filter: blur(20px) saturate(1.2);
  border-bottom: 1px solid var(--line);
  padding: 14px 20px;
  padding-top: calc(14px + env(safe-area-inset-top));
}
header.top .row {
  display: flex; align-items: center; justify-content: space-between; gap: 12px;
}
header.top .title {
  font-family: 'Fraunces', serif;
  font-weight: 500;
  font-style: italic;
  font-size: 20px;
  letter-spacing: -0.01em;
}
header.top .title small {
  display: block;
  font-family: 'IBM Plex Sans', sans-serif;
  font-style: normal;
  font-size: 10px;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--text-faint);
  font-weight: 400;
  margin-bottom: 2px;
}
header.top .actions { display: flex; gap: 6px; }
header.top button.icon {
  background: transparent;
  border: 1px solid var(--line);
  color: var(--text-dim);
  width: 38px; height: 38px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  transition: all 0.15s;
}
header.top button.icon:hover, header.top button.icon:active {
  border-color: var(--accent);
  color: var(--accent);
}
header.top button.icon svg { width: 16px; height: 16px; }

/* ========== NAV CIUDADES ========== */
.city-nav {
  display: flex; gap: 6px;
  overflow-x: auto;
  padding: 12px 16px 4px;
  scrollbar-width: none;
  border-bottom: 1px solid var(--line);
}
.city-nav::-webkit-scrollbar { display: none; }
.city-nav button {
  flex-shrink: 0;
  background: transparent;
  border: 1px solid var(--line);
  color: var(--text-dim);
  padding: 6px 14px;
  font-size: 12px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  border-radius: 100px;
  cursor: pointer;
  transition: all 0.15s;
}
.city-nav button.active {
  background: var(--text);
  color: var(--bg);
  border-color: var(--text);
}

/* ========== CONTENIDO ========== */
main { padding: 20px 16px 100px; max-width: 720px; margin: 0 auto; }

.day-group { margin-bottom: 36px; }
.day-group.is-today {
  position: relative;
  padding: 14px 14px 4px;
  margin-left: -14px;
  margin-right: -14px;
  border-radius: 12px;
  background: linear-gradient(180deg, var(--today-bg) 0%, transparent 80%);
}
.day-group.is-today .day-header {
  color: var(--today);
}
.day-group.is-today .day-header::before {
  background: var(--today);
  width: 100%;
}
.day-group.is-past { opacity: 0.55; }

.day-header {
  display: flex; align-items: baseline; gap: 14px;
  padding-bottom: 14px;
  margin-bottom: 16px;
  border-bottom: 1px solid var(--line);
  position: relative;
}
.day-header::before {
  content: '';
  position: absolute;
  left: 0; bottom: -1px;
  width: 40px; height: 1px;
  background: var(--accent);
}
.day-header .num {
  font-family: 'Fraunces', serif;
  font-size: 44px;
  font-weight: 300;
  line-height: 1;
  letter-spacing: -0.02em;
}
.day-header .info { flex: 1; }
.day-header .weekday {
  font-size: 11px;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--text-faint);
}
.day-header .month {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-size: 18px;
  font-weight: 400;
}
.day-header .badge {
  font-size: 10px;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--today);
  background: var(--today-bg);
  padding: 4px 10px;
  border-radius: 100px;
  border: 1px solid var(--today);
  align-self: center;
}

.event-list { display: flex; flex-direction: column; gap: 10px; }

.event-card {
  background: var(--bg-2);
  border: 1px solid var(--line);
  border-radius: 8px;
  padding: 14px 14px 14px 16px;
  display: flex; gap: 12px;
  cursor: pointer;
  transition: border-color 0.15s, transform 0.1s;
  position: relative;
  overflow: hidden;
}
.event-card:active { transform: scale(0.99); }
.event-card:hover { border-color: var(--accent); }
.event-card .accent-bar {
  position: absolute; left: 0; top: 0; bottom: 0;
  width: 3px;
  background: var(--type-color, var(--accent));
}
.event-card .icon-wrap {
  flex-shrink: 0;
  width: 40px; height: 40px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px;
  background: var(--bg-3);
}
.event-card .body { flex: 1; min-width: 0; }
.event-card .time {
  font-family: 'JetBrains Mono', monospace;
  font-size: 11px;
  color: var(--text-faint);
  letter-spacing: 0.05em;
  margin-bottom: 2px;
}
.event-card .activity {
  font-size: 15px;
  font-weight: 500;
  line-height: 1.3;
  margin-bottom: 2px;
  word-break: break-word;
}
.event-card .place {
  font-size: 12px;
  color: var(--text-dim);
  word-break: break-word;
}
.event-card .place-meta {
  display: flex; gap: 8px; align-items: center;
  margin-top: 6px;
  flex-wrap: wrap;
}
.event-card .tag {
  font-size: 10px;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--type-color, var(--accent));
  border: 1px solid var(--type-color, var(--accent));
  padding: 2px 8px;
  border-radius: 100px;
  opacity: 0.85;
}
.event-card .notes {
  font-size: 12px;
  color: var(--text-dim);
  margin-top: 6px;
  font-style: italic;
  line-height: 1.4;
}
.event-card .url-link {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 11px;
  color: var(--accent);
  margin-top: 6px;
}

/* ========== POR ASIGNAR ========== */
.tentative-section {
  margin-top: 40px;
  padding-top: 24px;
  border-top: 1px dashed var(--line);
}
.tentative-section h2 {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-weight: 400;
  font-size: 22px;
  margin-bottom: 8px;
}
.tentative-section .sub {
  font-size: 12px;
  color: var(--text-dim);
  margin-bottom: 16px;
}

/* ========== EMPTY ========== */
.empty {
  text-align: center;
  padding: 60px 20px;
  color: var(--text-faint);
}
.empty h3 {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-weight: 400;
  font-size: 24px;
  margin-bottom: 8px;
  color: var(--text-dim);
}

/* ========== FAB ========== */
.fab {
  position: fixed;
  right: 20px;
  bottom: calc(24px + env(safe-area-inset-bottom));
  width: 56px; height: 56px;
  background: var(--accent);
  color: var(--bg);
  border: none;
  border-radius: 50%;
  font-size: 28px;
  font-weight: 300;
  cursor: pointer;
  box-shadow: var(--shadow);
  z-index: 40;
  display: flex; align-items: center; justify-content: center;
  transition: transform 0.15s;
}
.fab:active { transform: scale(0.92); }

/* ========== MODAL ========== */
.modal-backdrop {
  display: none;
  position: fixed; inset: 0;
  background: rgba(0, 0, 0, 0.7);
  z-index: 100;
  align-items: flex-end;
  justify-content: center;
  animation: fadeIn 0.2s;
}
.modal-backdrop.show { display: flex; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }

.modal {
  background: var(--bg-2);
  width: 100%;
  max-width: 560px;
  max-height: 92vh;
  border-radius: 16px 16px 0 0;
  overflow-y: auto;
  animation: slideUp 0.25s cubic-bezier(0.2, 0.8, 0.2, 1);
  padding: 20px;
  padding-bottom: calc(20px + env(safe-area-inset-bottom));
}
.modal .handle {
  width: 40px; height: 4px;
  background: var(--line);
  border-radius: 100px;
  margin: 0 auto 16px;
}
.modal h2 {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-weight: 400;
  font-size: 24px;
  margin-bottom: 20px;
}
.modal .field { margin-bottom: 14px; }
.modal label {
  display: block;
  font-size: 10px;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--text-faint);
  margin-bottom: 6px;
}
.modal input, .modal select, .modal textarea {
  width: 100%;
  padding: 12px 14px;
  background: var(--bg);
  border: 1px solid var(--line);
  border-radius: 6px;
  color: var(--text);
  font-size: 15px;
  outline: none;
  transition: border-color 0.15s;
}
.modal input:focus, .modal select:focus, .modal textarea:focus { border-color: var(--accent); }
.modal textarea { resize: vertical; min-height: 70px; font-family: inherit; }
.modal .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.modal .actions {
  display: flex; gap: 10px;
  margin-top: 24px;
  padding-top: 20px;
  border-top: 1px solid var(--line);
}
.modal button {
  flex: 1;
  padding: 14px;
  border-radius: 6px;
  border: none;
  font-weight: 600;
  font-size: 13px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.15s;
}
.modal button.primary { background: var(--accent); color: #1a0f08; }
.modal button.primary:hover { background: var(--accent-2); }
.modal button.secondary { background: transparent; border: 1px solid var(--line); color: var(--text-dim); }
.modal button.danger { background: transparent; border: 1px solid var(--danger); color: var(--danger); flex: 0 0 auto; padding: 14px 18px; }
.modal button:disabled { opacity: 0.5; cursor: wait; }

/* ========== FORMULARIO MÓVIL — CARDS ========== */
.form-section {
  font-size: 10px; letter-spacing: .2em; text-transform: uppercase;
  color: var(--text-faint); margin: 18px 0 6px; padding: 0 2px;
}
.form-section:first-of-type { margin-top: 4px; }
.form-card {
  background: var(--bg-3); border: 1px solid var(--line);
  border-radius: 12px; overflow: hidden; margin-bottom: 2px;
}
.form-card .field {
  margin-bottom: 0; padding: 0 16px;
  border-bottom: 1px solid var(--line);
}
.form-card .field:last-child { border-bottom: none; }
.form-card label { padding-top: 10px; margin-bottom: 1px; }
.form-card input,
.form-card select,
.form-card textarea {
  background: transparent !important; border: none !important;
  border-radius: 0 !important; padding: 8px 0 13px !important;
  font-size: 16px !important; /* evita zoom en iOS al hacer focus */
}
.form-card input:focus, .form-card select:focus, .form-card textarea:focus { outline: none; }
.form-card textarea { min-height: 60px; }
.form-card .row-2i { display: grid; grid-template-columns: 1fr 1fr; }
.form-card .row-2i .field:first-child { border-right: 1px solid var(--line); }
.toggle-row {
  display: flex; align-items: center; gap: 14px;
  padding: 16px 4px; cursor: pointer; color: var(--text-dim); font-size: 14px;
}
.toggle-row input[type=checkbox] {
  width: 20px !important; height: 20px !important; flex-shrink: 0;
  accent-color: var(--accent); border: none !important; padding: 0 !important;
}

/* ========== TOAST ========== */
.toast {
  position: fixed;
  bottom: calc(96px + env(safe-area-inset-bottom));
  left: 50%;
  transform: translateX(-50%) translateY(20px);
  background: var(--bg-3);
  color: var(--text);
  padding: 10px 18px;
  border-radius: 100px;
  font-size: 13px;
  border: 1px solid var(--line);
  box-shadow: var(--shadow);
  opacity: 0;
  pointer-events: none;
  transition: all 0.25s;
  z-index: 200;
}
.toast.show {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
}

/* ========== LOADER ========== */
.loader {
  display: flex; justify-content: center; padding: 60px 0;
}
.loader::after {
  content: '';
  width: 24px; height: 24px;
  border: 2px solid var(--line);
  border-top-color: var(--accent);
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ========== PRÓXIMOS (1-2 días) ========== */
.day-group.is-upcoming .day-header .num { color: var(--accent); }
.day-group.is-upcoming .day-header::before { width: 56px; }
.badge-upcoming {
  font-size: 10px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--accent);
  background: rgba(233, 163, 107, 0.08);
  padding: 4px 10px;
  border-radius: 100px;
  border: 1px solid rgba(233, 163, 107, 0.3);
  align-self: center;
}

/* ========== ACONTECIENDO AHORA ========== */
.event-card.is-happening {
  border-color: rgba(240, 194, 112, 0.6);
  background: rgba(240, 194, 112, 0.05);
  box-shadow: 0 0 0 1px rgba(240, 194, 112, 0.2), 0 4px 20px rgba(240, 194, 112, 0.1);
}
.event-card.is-happening .accent-bar {
  background: var(--today) !important;
  width: 4px;
}
.event-card.is-happening .time { color: var(--today); }
.now-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 10px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--today);
  background: rgba(240, 194, 112, 0.12);
  padding: 3px 9px;
  border-radius: 100px;
  border: 1px solid rgba(240, 194, 112, 0.4);
}
.now-badge::before {
  content: '';
  width: 6px; height: 6px;
  background: var(--today);
  border-radius: 50%;
  animation: pulse-dot 1.5s ease-in-out infinite;
}
@keyframes pulse-dot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%       { opacity: 0.4; transform: scale(0.65); }
}

/* ========== AMBIENTE ========== */
.grain {
  position: fixed; inset: 0; pointer-events: none; opacity: 0.025; z-index: 1;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence baseFrequency='0.9'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}
</style>
</head>
<body>
<div class="grain"></div>

<!-- ========== LOGIN ========== -->
<div id="login">
  <div class="brand">Itinerario</div>
  <h1>Europa<br><em>2026</em></h1>
  <div class="sub">14 — 29 de Mayo</div>
  <form id="loginForm" autocomplete="off">
    <label for="name">Tu nombre</label>
    <input type="text" id="name" required>
    <label for="password">Clave compartida</label>
    <input type="password" id="password" required>
    <button type="submit" id="loginBtn">Entrar</button>
    <div class="err" id="loginErr"></div>
  </form>
</div>

<!-- ========== APP ========== -->
<div id="app">
  <header class="top">
    <div class="row">
      <div class="title">
        <small>Itinerario</small>
        <?= htmlspecialchars(TRIP_NAME) ?>
      </div>
      <div class="actions">
        <button class="icon" id="todayBtn" title="Ir a hoy">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="3" x2="8" y2="7"/><line x1="16" y1="3" x2="16" y2="7"/><circle cx="12" cy="15" r="1.5" fill="currentColor"/></svg>
        </button>
        <button class="icon" id="refreshBtn" title="Actualizar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
        </button>
        <button class="icon" id="logoutBtn" title="Salir">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </div>
    </div>
  </header>

  <nav class="city-nav" id="cityNav"></nav>

  <main id="main">
    <div class="loader"></div>
  </main>

  <button class="fab" id="addBtn" title="Agregar evento">+</button>
</div>

<!-- ========== MODAL ========== -->
<div class="modal-backdrop" id="modal">
  <div class="modal">
    <div class="handle"></div>
    <h2 id="modalTitle">Nuevo evento</h2>

    <!-- Ciudad: primero para filtrar lugares -->
    <div class="form-section">Ciudad</div>
    <div class="form-card">
      <div class="field">
        <label>Ciudad</label>
        <select id="f_city">
          <option value="">— elegir —</option>
          <option value="Bogota">Bogotá</option>
          <option value="Madrid">Madrid</option>
          <option value="Paris">París</option>
          <option value="Milan">Milán</option>
          <option value="Roma">Roma</option>
          <option value="Bilbao">Bilbao</option>
        </select>
      </div>
    </div>

    <!-- Qué -->
    <div class="form-section">¿Qué?</div>
    <div class="form-card">
      <div class="field">
        <label>Lugar</label>
        <input type="text" id="f_place" list="places-list" placeholder="Buscar lugar…">
        <datalist id="places-list"></datalist>
      </div>
      <div class="field">
        <label>Actividad</label>
        <input type="text" id="f_activity" placeholder="Ej: Visitar Gran Vía">
      </div>
      <div class="field">
        <label>Tipo</label>
        <select id="f_type">
          <option value="Vuelo">✈️ Vuelo</option>
          <option value="Tren">🚆 Tren</option>
          <option value="Traslado">🚕 Traslado</option>
          <option value="Hospedaje">🏨 Hospedaje</option>
          <option value="Actividad" selected>📍 Actividad</option>
          <option value="Comida">🍽️ Comida</option>
          <option value="Desplazamiento">🚶 Desplazamiento</option>
          <option value="Seguro">🛡️ Seguro</option>
          <option value="Otro">⭐ Otro</option>
        </select>
      </div>
    </div>

    <!-- Cuándo -->
    <div class="form-section">¿Cuándo?</div>
    <div class="form-card">
      <div class="row-2i">
        <div class="field">
          <label>Fecha</label>
          <input type="date" id="f_start_date" min="2026-05-14" max="2026-05-29">
        </div>
        <div class="field">
          <label>Hora inicio</label>
          <select id="f_start_time">
            <option value="">— hora —</option>
            <?php for ($h = 0; $h < 24; $h++): ?>
              <option value="<?= sprintf('%02d:00', $h) ?>"><?= sprintf('%02d:00', $h) ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>
      <div class="field">
        <label>Duración</label>
        <select id="f_duration">
          <option value="">— duración —</option>
          <option value="0.5">30 min</option>
          <option value="1">1 hora</option>
          <option value="1.5">1 h 30 min</option>
          <option value="2">2 horas</option>
          <option value="3">3 horas</option>
          <option value="4">4 horas</option>
          <option value="5">5 horas</option>
          <option value="6">6 horas</option>
          <option value="8">8 horas</option>
          <option value="12">12 horas</option>
          <option value="24">Todo el día</option>
        </select>
      </div>
    </div>

    <!-- Extras -->
    <div class="form-section">Extras</div>
    <div class="form-card">
      <div class="field">
        <label>Costo</label>
        <input type="text" id="f_cost" placeholder="$0">
      </div>
      <div class="field">
        <label>Notas</label>
        <textarea id="f_notes" rows="2" placeholder="Notas opcionales…"></textarea>
      </div>
      <div class="field">
        <label>Link / URL</label>
        <input type="url" id="f_url" placeholder="https://...">
      </div>
    </div>

    <label class="toggle-row">
      <input type="checkbox" id="f_tentative">
      Sin fecha asignada (va a "Por asignar")
    </label>

    <!-- Campos ocultos: se calculan desde duración o se preservan al editar -->
    <input type="hidden" id="f_end_date">
    <input type="hidden" id="f_end_time">

    <div class="actions">
      <button type="button" class="secondary" id="cancelBtn">Cancelar</button>
      <button type="button" class="danger" id="deleteBtn" style="display:none;" title="Eliminar">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:16px;height:16px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-2 14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
      </button>
      <button type="button" class="primary" id="saveBtn">Guardar</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
// ============================================================
// ESTADO Y CONFIGURACIÓN
// ============================================================
const TYPE_META = {
  'Vuelo':          { icon: '✈️', color: '#7eb8d6' },
  'Tren':           { icon: '🚆', color: '#a47fc7' },
  'Traslado':       { icon: '🚕', color: '#d6c97e' },
  'Hospedaje':      { icon: '🏨', color: '#e9a36b' },
  'Actividad':      { icon: '📍', color: '#8ec59a' },
  'Comida':         { icon: '🍽️', color: '#e08074' },
  'Desplazamiento': { icon: '🚶', color: '#9a9aa8' },
  'Seguro':         { icon: '🛡️', color: '#c7a47f' },
  'Otro':           { icon: '⭐', color: '#c0b4d6' }
};
const MONTHS = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
const WEEKDAYS = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];

let STATE = {
  events: [],
  today: null,
  user: null,
  filterCity: 'all',
  editingId: null
};

// ============================================================
// HELPERS
// ============================================================
function $(s) { return document.querySelector(s); }
function $$(s) { return document.querySelectorAll(s); }
function el(tag, attrs = {}, ...children) {
  const e = document.createElement(tag);
  for (const k in attrs) {
    if (k === 'class') e.className = attrs[k];
    else if (k === 'html') e.innerHTML = attrs[k];
    else if (k.startsWith('on')) e.addEventListener(k.substring(2), attrs[k]);
    else e.setAttribute(k, attrs[k]);
  }
  for (const c of children) {
    if (c == null) continue;
    e.appendChild(typeof c === 'string' ? document.createTextNode(c) : c);
  }
  return e;
}
function toast(msg) {
  const t = $('#toast'); t.textContent = msg; t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 1800);
}
async function api(action, body) {
  const opts = { method: body ? 'POST' : 'GET', credentials: 'same-origin' };
  if (body) { opts.headers = { 'Content-Type': 'application/json' }; opts.body = JSON.stringify(body); }
  const r = await fetch('api.php?action=' + action, opts);
  const data = await r.json();
  if (!data.ok) throw new Error(data.error || 'Error');
  return data;
}
function fmtTime(t) {
  if (!t) return '';
  const [h, m] = t.split(':');
  return `${h}:${m}`;
}
function fmtDate(d) {
  if (!d) return '';
  const [y, mo, da] = d.split('-').map(Number);
  return `${da} ${MONTHS[mo-1]}`;
}
function dayKey(d) { return d || 'sin-fecha'; }

// ============================================================
// DATOS DEL VIAJE — autocompletado
// ============================================================
const CITY_DATES = [
  ['2026-05-14', '2026-05-15', 'Madrid'],
  ['2026-05-16', '2026-05-19', 'Paris'],
  ['2026-05-20', '2026-05-21', 'Milan'],
  ['2026-05-22', '2026-05-24', 'Roma'],
  ['2026-05-25', '2026-05-27', 'Bilbao'],
  ['2026-05-28', '2026-05-29', 'Madrid'],
];
const PLACES_BY_CITY = {
  Bogota: [
    'Aeropuerto El Dorado','La Candelaria','Monserrate','Museo del Oro',
    'Museo Nacional','Parque Simón Bolívar','Zona Rosa','Usaquén',
    'Chapinero','Parque de la 93','Andrés Carne de Res','Plaza de Bolívar',
    'Mercado de las Pulgas','Paloquemao','Centro Comercial Andino',
    'Cerro de Monserrate','Jardín Botánico','Planetario de Bogotá',
    'Biblioteca Luis Ángel Arango','Chía','Zipaquirá — Catedral de Sal',
  ],
  Madrid: [
    'Plaza Mayor','Puerta del Sol','Gran Vía','Parque del Retiro',
    'Museo del Prado','Museo Reina Sofía','Museo Thyssen-Bornemisza',
    'Palacio Real','Plaza de Cibeles','Puerta de Alcalá','Plaza de España',
    'Templo de Debod','El Rastro','Mercado de San Miguel','La Latina',
    'Malasaña','Lavapiés','Chueca','Barrio de Salamanca',
    'Santiago Bernabéu','Aeropuerto Barajas T4',
    'Mercado de San Antón','El Corte Inglés Callao',
  ],
  Paris: [
    'Torre Eiffel','Trocadéro','Museo del Louvre','Catedral Notre-Dame',
    'Sacré-Cœur','Montmartre','Palacio de Versalles','Campos Elíseos',
    'Arco del Triunfo','Musée d\'Orsay','Centro Pompidou',
    'Jardines de Tuileries','Jardines de Luxemburgo','Île de la Cité',
    'Shakespeare & Company','Galerías Lafayette','Moulin Rouge',
    'Panteón de París','Plaza de la República','Bastille','Le Marais',
    'Saint-Germain-des-Prés','Río Sena','Palais Royal',
    'Disneyland París','Aeropuerto CDG','Aeropuerto Orly',
    'Montparnasse','Père Lachaise','Sainte-Chapelle',
  ],
  Milan: [
    'Duomo de Milán','Galería Vittorio Emanuele II','Castillo Sforzesco',
    'Teatro alla Scala','Navigli','Brera','Pinacoteca di Brera',
    'Parque Sempione','Arco della Pace','Porta Garibaldi',
    'Via Montenapoleone','Cementerio Monumental','Isola',
    'Aeropuerto Malpensa','Aeropuerto Linate',
    'Santa Maria delle Grazie (La Última Cena)',
    'Piazza Gae Aulenti','Corso Como',
    'Tirano','Bernina Express','San Moritz',
  ],
  Roma: [
    'Coliseo','Foro Romano','Palatino',
    'Basílica de San Pedro','Museos Vaticanos','Capilla Sixtina',
    'Fontana di Trevi','Panteón de Roma','Piazza Navona',
    'Plaza de España + Escalinata','Castel Sant\'Angelo','Trastevere',
    'Piazza Venezia','Altar de la Patria','Villa Borghese',
    'Campo de\' Fiori','Termas de Caracalla','Circo Máximo',
    'Bocca della Verità','Aventino + Jardín de los Naranjos',
    'Ghetto Judío','Pigneto','EUR','Aeropuerto Fiumicino',
    'Florencia — Duomo','Florencia — Uffizi','Florencia — Ponte Vecchio',
  ],
  Bilbao: [
    'Museo Guggenheim','Casco Viejo','Catedral de Santiago de Bilbao',
    'Mercado de la Ribera','Puente Zubizuri','Parque Doña Casilda',
    'Estadio San Mamés','Ría del Nervión','Basílica de Begoña',
    'Teatro Arriaga','Azkuna Zentroa','Gran Vía de Bilbao',
    'Playa de la Zurriola','San Sebastián — Parte Vieja',
    'San Sebastián — Playa de la Concha','Lekeitio','Getxo',
    'Vitoria-Gasteiz','Gernika','Bermeo',
  ],
};

function cityForDate(dateStr) {
  if (!dateStr) return '';
  for (const [from, to, city] of CITY_DATES) {
    if (dateStr >= from && dateStr <= to) return city;
  }
  return 'Bogota'; // antes o después del viaje
}

// Rango de fechas válidas por ciudad para el selector de fecha
const CITY_DATE_RANGE = {
  Bogota: { min: '',           max: ''           },
  Madrid: { min: '2026-05-14', max: '2026-05-29' }, // 14-15 + 28-29 (dos períodos)
  Paris:  { min: '2026-05-16', max: '2026-05-19' },
  Milan:  { min: '2026-05-20', max: '2026-05-21' },
  Roma:   { min: '2026-05-22', max: '2026-05-24' },
  Bilbao: { min: '2026-05-25', max: '2026-05-27' },
};
function updateDateRange(city) {
  const r = CITY_DATE_RANGE[city] || { min: '2026-05-14', max: '2026-05-29' };
  const inp = $('#f_start_date');
  inp.min = r.min; inp.max = r.max;
  // Si la fecha actual queda fuera del nuevo rango, ajustar al primer día válido
  if (r.min && inp.value && inp.value < r.min) { inp.value = r.min; applyDuration(); }
  if (r.max && inp.value && inp.value > r.max) { inp.value = r.max; applyDuration(); }
}

// Prefijo para autosugerir nombre de actividad según tipo
const ACTIVITY_PREFIX = {
  Comida: 'Comer en ', Hospedaje: 'Hospedaje en ',
  Vuelo: '', Tren: '', Traslado: '', Desplazamiento: '', Seguro: '',
};
function updatePlacesList(city) {
  const dl = document.getElementById('places-list');
  dl.innerHTML = '';
  (PLACES_BY_CITY[city] || []).forEach(p => {
    const o = document.createElement('option'); o.value = p; dl.appendChild(o);
  });
}
function setTimeSelect(id, val) {
  const sel = document.getElementById(id);
  // Normalizar a HH:00 si solo tenemos la hora o minutos no estándar
  if (val) {
    const [h] = val.split(':');
    const norm = `${h.padStart(2,'0')}:00`;
    sel.value = norm;
    if (sel.value !== norm) {
      // Hora no en opciones — agregar temporalmente
      const o = document.createElement('option');
      o.value = val; o.textContent = val;
      sel.insertBefore(o, sel.options[1]);
      sel.value = val;
    }
  } else {
    sel.value = '';
  }
}
function applyDuration() {
  const startDate = $('#f_start_date').value;
  const startTime = $('#f_start_time').value;
  const dur = parseFloat($('#f_duration').value);
  if (!startDate || !startTime || isNaN(dur)) return;
  const startH = parseInt(startTime.split(':')[0]);
  const totalMins = startH * 60 + Math.round(dur * 60);
  const endH = Math.floor(totalMins / 60) % 24;
  const endM = totalMins % 60;
  const endTime = `${String(endH).padStart(2,'0')}:${String(endM).padStart(2,'0')}`;
  const extraDays = Math.floor(totalMins / (60 * 24));
  if (extraDays > 0) {
    const [y, m, d] = startDate.split('-').map(Number);
    const dt = new Date(y, m - 1, d + extraDays);
    $('#f_end_date').value = dt.toISOString().split('T')[0];
  } else {
    $('#f_end_date').value = startDate;
  }
  $('#f_end_time').value = endTime;
}

function daysUntil(dateStr) {
  if (!STATE.today || !dateStr) return Infinity;
  const [ty, tm, td] = STATE.today.split('-').map(Number);
  const [ey, em, ed] = dateStr.split('-').map(Number);
  return Math.round((new Date(ey, em - 1, ed) - new Date(ty, tm - 1, td)) / 86400000);
}
function isHappeningNow(e) {
  if (!e.start_date || e.start_date !== STATE.today || !e.start_time) return false;
  const now = new Date();
  const nowMins = now.getHours() * 60 + now.getMinutes();
  const [sh, sm] = e.start_time.split(':').map(Number);
  const startMins = sh * 60 + sm;
  if (nowMins < startMins) return false;
  if (e.end_time && (!e.end_date || e.end_date === e.start_date)) {
    const [eh, em] = e.end_time.split(':').map(Number);
    return nowMins <= eh * 60 + em;
  }
  return nowMins <= startMins + 120; // activo 2h si no hay hora fin
}

// ============================================================
// LOGIN
// ============================================================
async function tryRestoreSession() {
  try {
    const r = await api('me');
    if (r.auth) {
      STATE.user = r.user;
      STATE.today = r.today;
      showApp();
      await loadEvents();
    }
  } catch (e) { /* ignorar */ }
}

$('#loginForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const btn = $('#loginBtn'); btn.disabled = true;
  $('#loginErr').textContent = '';
  try {
    const r = await api('login', { name: $('#name').value, password: $('#password').value });
    STATE.user = r.user;
    const me = await api('me');
    STATE.today = me.today;
    showApp();
    await loadEvents();
  } catch (err) {
    $('#loginErr').textContent = err.message;
  } finally {
    btn.disabled = false;
  }
});

$('#logoutBtn').addEventListener('click', async () => {
  await api('logout');
  location.reload();
});

function showApp() {
  $('#login').style.display = 'none';
  $('#app').classList.add('active');
}

// ============================================================
// CARGA Y RENDER
// ============================================================
async function loadEvents() {
  $('#main').innerHTML = '<div class="loader"></div>';
  try {
    const me = await api('me');
    STATE.today = me.today;
    const r = await api('list');
    STATE.events = r.events;
    render();
  } catch (err) {
    $('#main').innerHTML = `<div class="empty"><h3>Error</h3><p>${err.message}</p></div>`;
  }
}

function getCities() {
  const set = new Set();
  STATE.events.forEach(e => { if (e.city && !e.tentative) set.add(e.city); });
  const order = ['Madrid','Paris','Milan','Roma','Bilbao'];
  return [...set].sort((a, b) => {
    const ai = order.indexOf(a); const bi = order.indexOf(b);
    if (ai === -1 && bi === -1) return a.localeCompare(b);
    if (ai === -1) return 1;
    if (bi === -1) return -1;
    return ai - bi;
  });
}

function renderCityNav() {
  const nav = $('#cityNav'); nav.innerHTML = '';
  const cities = ['all', ...getCities()];
  cities.forEach(c => {
    const btn = el('button', {
      class: STATE.filterCity === c ? 'active' : '',
      onclick: () => { STATE.filterCity = c; render(); }
    }, c === 'all' ? 'Todo' : c);
    nav.appendChild(btn);
  });
}

function render() {
  renderCityNav();
  const main = $('#main'); main.innerHTML = '';

  // Filtrar
  let events = STATE.events;
  if (STATE.filterCity !== 'all') {
    events = events.filter(e => e.city === STATE.filterCity || e.tentative);
  }

  // Separar tentativos
  const tentatives = events.filter(e => e.tentative);
  const dated = events.filter(e => !e.tentative && e.start_date);
  const noDate = events.filter(e => !e.tentative && !e.start_date);

  // Agrupar por fecha
  const byDay = {};
  dated.forEach(e => {
    const k = dayKey(e.start_date);
    if (!byDay[k]) byDay[k] = [];
    byDay[k].push(e);
  });

  const dayKeys = Object.keys(byDay).sort();

  if (dayKeys.length === 0 && tentatives.length === 0 && noDate.length === 0) {
    main.appendChild(el('div', { class: 'empty' },
      el('h3', {}, 'Sin eventos'),
      el('p', {}, 'Toca el + para agregar el primero.')
    ));
    return;
  }

  // Render días
  let todayElement = null;
  for (const dk of dayKeys) {
    const group = renderDayGroup(dk, byDay[dk]);
    main.appendChild(group);
    if (group.classList.contains('is-today')) todayElement = group;
  }

  // Render "sin fecha pero del viaje"
  if (noDate.length) {
    const sec = el('div', { class: 'tentative-section' },
      el('h2', {}, 'Sin fecha'),
      el('div', { class: 'sub' }, 'Eventos sin fecha asignada')
    );
    const list = el('div', { class: 'event-list' });
    noDate.forEach(e => list.appendChild(renderCard(e)));
    sec.appendChild(list);
    main.appendChild(sec);
  }

  // Render tentativos
  if (tentatives.length) {
    const sec = el('div', { class: 'tentative-section' },
      el('h2', {}, 'Por asignar'),
      el('div', { class: 'sub' }, 'Tap para editar y asignar a un día')
    );
    const list = el('div', { class: 'event-list' });
    tentatives.forEach(e => list.appendChild(renderCard(e)));
    sec.appendChild(list);
    main.appendChild(sec);
  }

  // (botón flotante removido: el de calendar del header ya hace esta función)
}

function renderDayGroup(dateStr, events) {
  const [y, m, d] = dateStr.split('-').map(Number);
  const dt = new Date(y, m - 1, d);
  const isToday = dateStr === STATE.today;
  const isPast = dateStr < STATE.today;
  const days = daysUntil(dateStr);
  const isUpcoming = !isToday && !isPast && days >= 1 && days <= 2;

  const group = el('div', {
    class: 'day-group' + (isToday ? ' is-today' : '') + (isPast ? ' is-past' : '') + (isUpcoming ? ' is-upcoming' : ''),
    'data-date': dateStr
  });

  const header = el('div', { class: 'day-header' },
    el('div', { class: 'num' }, String(d)),
    el('div', { class: 'info' },
      el('div', { class: 'weekday' }, WEEKDAYS[dt.getDay()]),
      el('div', { class: 'month' }, MONTHS[m - 1])
    )
  );
  if (isToday) header.appendChild(el('div', { class: 'badge' }, 'Hoy'));
  else if (days === 1) header.appendChild(el('div', { class: 'badge-upcoming' }, 'Mañana'));
  else if (days === 2) header.appendChild(el('div', { class: 'badge-upcoming' }, 'En 2 días'));
  group.appendChild(header);

  const list = el('div', { class: 'event-list' });
  // Ordenar por hora
  events.sort((a, b) => (a.start_time || '99:99').localeCompare(b.start_time || '99:99'));
  events.forEach(e => list.appendChild(renderCard(e)));
  group.appendChild(list);

  return group;
}

function renderCard(e) {
  const meta = TYPE_META[e.type] || TYPE_META['Otro'];
  const happening = isHappeningNow(e);
  const card = el('div', {
    class: 'event-card' + (happening ? ' is-happening' : ''),
    style: `--type-color: ${meta.color};`,
    'data-event-id': e.id,
    onclick: () => openEditModal(e)
  });
  card.appendChild(el('div', { class: 'accent-bar' }));
  card.appendChild(el('div', { class: 'icon-wrap' }, meta.icon));

  const body = el('div', { class: 'body' });

  // tiempo
  let timeText = '';
  if (e.start_time && e.end_time && e.start_date === e.end_date) {
    timeText = `${fmtTime(e.start_time)} — ${fmtTime(e.end_time)}`;
  } else if (e.start_time) {
    timeText = fmtTime(e.start_time);
    if (e.end_date && e.end_date !== e.start_date) {
      timeText += ` · hasta ${fmtDate(e.end_date)} ${fmtTime(e.end_time)}`;
    }
  } else if (e.tentative) {
    timeText = 'Sin fecha';
  }
  if (timeText) body.appendChild(el('div', { class: 'time' }, timeText));

  body.appendChild(el('div', { class: 'activity' }, e.activity || '(Sin nombre)'));
  if (e.place && e.place !== e.activity) body.appendChild(el('div', { class: 'place' }, e.place));

  const meta_row = el('div', { class: 'place-meta' });
  meta_row.appendChild(el('span', { class: 'tag' }, e.type || 'Otro'));
  if (happening) meta_row.appendChild(el('span', { class: 'now-badge' }, 'Ahora'));
  body.appendChild(meta_row);

  if (e.notes) body.appendChild(el('div', { class: 'notes' }, e.notes));
  if (e.url) {
    const link = el('a', {
      class: 'url-link',
      href: e.url,
      target: '_blank',
      rel: 'noopener',
      onclick: (ev) => ev.stopPropagation()
    });
    link.innerHTML = '<svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg> Abrir enlace';
    body.appendChild(link);
  }

  card.appendChild(body);
  return card;
}

// ============================================================
// MODAL
// ============================================================
function openModal() { $('#modal').classList.add('show'); }
function closeModal() { $('#modal').classList.remove('show'); STATE.editingId = null; }

function openNewModal() {
  STATE.editingId = null;
  $('#modalTitle').textContent = 'Nuevo evento';
  $('#deleteBtn').style.display = 'none';
  $('#f_activity').value = '';
  $('#f_place').value = '';
  $('#f_type').value = 'Actividad';
  const initDate = STATE.today || '';
  $('#f_start_date').value = initDate;
  $('#f_start_time').value = '';
  $('#f_duration').value = '';
  $('#f_end_date').value = '';
  $('#f_end_time').value = '';
  const autoCity = (STATE.filterCity !== 'all' ? STATE.filterCity : '') || cityForDate(initDate);
  $('#f_city').value = autoCity;
  updatePlacesList(autoCity);
  updateDateRange(autoCity);
  $('#f_cost').value = '';
  $('#f_notes').value = '';
  $('#f_url').value = '';
  $('#f_tentative').checked = false;
  openModal();
}

function openEditModal(e) {
  STATE.editingId = e.id;
  $('#modalTitle').textContent = 'Editar evento';
  $('#deleteBtn').style.display = 'flex';
  $('#f_activity').value = e.activity || '';
  $('#f_place').value = e.place || '';
  $('#f_type').value = e.type || 'Actividad';
  $('#f_start_date').value = e.start_date || '';
  setTimeSelect('f_start_time', e.start_time || '');
  $('#f_duration').value = '';          // duración vacía al editar
  $('#f_end_date').value = e.end_date || '';   // preservar fin existente
  $('#f_end_time').value = e.end_time || '';
  $('#f_city').value = e.city || '';
  updatePlacesList(e.city || '');
  updateDateRange(e.city || '');
  $('#f_cost').value = e.cost || '';
  $('#f_notes').value = e.notes || '';
  $('#f_url').value = e.url || '';
  $('#f_tentative').checked = !!parseInt(e.tentative);
  openModal();
}

$('#addBtn').addEventListener('click', openNewModal);
$('#cancelBtn').addEventListener('click', closeModal);
$('#modal').addEventListener('click', (e) => { if (e.target === $('#modal')) closeModal(); });

// Al elegir fecha: confirmar ciudad y recalcular fin
$('#f_start_date').addEventListener('change', () => {
  const city = cityForDate($('#f_start_date').value);
  if (city) { $('#f_city').value = city; updatePlacesList(city); }
  applyDuration();
});
// Al cambiar hora o duración: recalcular fin
$('#f_start_time').addEventListener('change', applyDuration);
$('#f_duration').addEventListener('change', applyDuration);
// Al cambiar ciudad: filtrar fechas válidas + actualizar lista de lugares
$('#f_city').addEventListener('change', () => {
  const city = $('#f_city').value;
  updatePlacesList(city);
  updateDateRange(city);
});
// Al elegir lugar: autosugerir nombre de actividad si está vacío
$('#f_place').addEventListener('change', () => {
  const place = $('#f_place').value.trim();
  if (!place || $('#f_activity').value.trim()) return;
  const prefix = ACTIVITY_PREFIX[$('#f_type').value] ?? 'Visitar ';
  if (prefix !== '') $('#f_activity').value = prefix + place;
});

$('#saveBtn').addEventListener('click', async () => {
  const btn = $('#saveBtn'); btn.disabled = true;
  const data = {
    activity:   $('#f_activity').value.trim(),
    place:      $('#f_place').value.trim(),
    type:       $('#f_type').value,
    start_date: $('#f_start_date').value,
    start_time: $('#f_start_time').value,
    end_date:   $('#f_end_date').value,
    end_time:   $('#f_end_time').value,
    city:       $('#f_city').value.trim(),
    cost:       $('#f_cost').value.trim(),
    notes:      $('#f_notes').value.trim(),
    url:        $('#f_url').value.trim(),
    tentative:  $('#f_tentative').checked ? 1 : 0
  };
  try {
    if (STATE.editingId) {
      await api('update', { id: STATE.editingId, ...data });
      toast('Actualizado');
    } else {
      await api('create', data);
      toast('Creado');
    }
    closeModal();
    await loadEvents();
  } catch (err) {
    alert('Error: ' + err.message);
  } finally {
    btn.disabled = false;
  }
});

$('#deleteBtn').addEventListener('click', async () => {
  if (!STATE.editingId) return;
  if (!confirm('¿Eliminar este evento?')) return;
  try {
    await api('delete', { id: STATE.editingId });
    toast('Eliminado');
    closeModal();
    await loadEvents();
  } catch (err) {
    alert('Error: ' + err.message);
  }
});

$('#refreshBtn').addEventListener('click', async () => {
  await loadEvents();
  toast('Actualizado');
});

$('#todayBtn').addEventListener('click', () => {
  const todayGroup = document.querySelector('.day-group.is-today');
  if (todayGroup) {
    todayGroup.scrollIntoView({ behavior: 'smooth', block: 'start' });
  } else {
    toast('No hay eventos para hoy');
  }
});

// ============================================================
// LIVE STATUS — actualiza "Ahora" cada minuto sin re-render completo
// ============================================================
setInterval(() => {
  document.querySelectorAll('.event-card').forEach(card => {
    const id = parseInt(card.dataset.eventId);
    const e = STATE.events.find(ev => ev.id === id);
    if (!e) return;
    const happening = isHappeningNow(e);
    card.classList.toggle('is-happening', happening);
    const badge = card.querySelector('.now-badge');
    const meta_row = card.querySelector('.place-meta');
    if (happening && !badge && meta_row) {
      meta_row.appendChild(el('span', { class: 'now-badge' }, 'Ahora'));
    } else if (!happening && badge) {
      badge.remove();
    }
  });
}, 60000);

// ============================================================
// INIT
// ============================================================
tryRestoreSession();
</script>
</body>
</html>
