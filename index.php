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
main { padding: 20px 16px calc(96px + env(safe-area-inset-bottom)); max-width: 720px; margin: 0 auto; }

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
  bottom: calc(72px + env(safe-area-inset-bottom));
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

/* ========== INFO DE LUGAR (panel en modal) ========== */
.place-info-panel {
  margin: 6px 0 10px;
  padding: 10px 12px;
  background: var(--bg);
  border-radius: 8px;
  border: 1px solid var(--line);
  border-left: 3px solid var(--accent);
}
.place-info-panel .pi-desc {
  font-size: 13px;
  color: var(--text-dim);
  line-height: 1.5;
  margin-bottom: 6px;
}
.place-info-panel .pi-chips {
  display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
}
.place-info-panel .pi-chip {
  font-size: 11px;
  color: var(--text-faint);
  display: flex; align-items: center; gap: 4px;
  line-height: 1.3;
}
.place-info-panel .pi-map-link {
  font-size: 11px;
  color: var(--accent);
  text-decoration: none;
  display: inline-flex; align-items: center; gap: 4px;
}
.place-info-panel .pi-map-link:hover { text-decoration: underline; }

/* ========== BOTÓN EDITAR EN TARJETA ========== */
.card-edit-btn {
  position: absolute;
  top: 9px; right: 9px;
  width: 26px; height: 26px;
  background: var(--bg-3);
  border: 1px solid var(--line);
  border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  color: var(--text-faint);
  z-index: 2;
  transition: all 0.15s;
  flex-shrink: 0;
}
.card-edit-btn:hover, .card-edit-btn:active { color: var(--accent); border-color: rgba(233,163,107,0.5); }

/* ========== MODAL DETALLE ========== */
.modal.detail-modal {
  overflow: hidden;
  display: flex;
  flex-direction: column;
  padding: 0;
  max-height: 92vh;
}
.dm-carousel {
  width: 100%;
  height: 220px;
  background: var(--bg-3);
  border-radius: 16px 16px 0 0;
  overflow: hidden;
  position: relative;
  flex-shrink: 0;
}
.dm-img {
  width: 100%; height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 0.4s;
  display: block;
}
.dm-img.loaded { opacity: 1; }
.dm-spinner {
  position: absolute; inset: 0;
  display: flex; align-items: center; justify-content: center;
  background: var(--bg-3);
  z-index: 2;
}
.dm-spinner::after {
  content: '';
  width: 22px; height: 22px;
  border: 2px solid rgba(255,255,255,0.12);
  border-top-color: rgba(255,255,255,0.6);
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}
.dm-carousel-btn {
  position: absolute;
  top: 50%; transform: translateY(-50%);
  background: rgba(0,0,0,0.45);
  border: none; color: white;
  width: 32px; height: 32px;
  border-radius: 50%;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  z-index: 3;
  transition: background 0.15s;
}
.dm-carousel-btn:hover { background: rgba(0,0,0,0.65); }
.dm-carousel-btn.dm-prev { left: 10px; }
.dm-carousel-btn.dm-next { right: 10px; }
.dm-dots {
  position: absolute;
  bottom: 8px; left: 0; right: 0;
  display: flex; justify-content: center; gap: 5px;
  z-index: 3;
}
.dm-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: rgba(255,255,255,0.35);
  cursor: pointer;
  transition: background 0.2s, transform 0.2s;
}
.dm-dot.active { background: white; transform: scale(1.2); }
.dm-handle {
  text-align: center;
  padding: 12px 0 4px;
}
.dm-handle::after {
  content: '';
  display: inline-block;
  width: 40px; height: 4px;
  background: var(--line);
  border-radius: 100px;
}
.dm-body {
  overflow-y: auto;
  flex: 1;
  padding: 12px 20px calc(20px + env(safe-area-inset-bottom));
  -webkit-overflow-scrolling: touch;
}
.dm-type-row {
  display: flex; align-items: center; gap: 8px;
  margin-bottom: 10px;
  flex-wrap: wrap;
}
.dm-icon-wrap {
  width: 36px; height: 36px;
  border-radius: 8px;
  background: var(--bg-3);
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; flex-shrink: 0;
}
.dm-activity {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-weight: 400;
  font-size: 22px;
  line-height: 1.25;
  margin-bottom: 12px;
}
.dm-info-row {
  display: flex; align-items: flex-start; gap: 8px;
  font-size: 13px; color: var(--text-dim);
  margin-bottom: 7px; line-height: 1.5;
}
.dm-info-icon { color: var(--text-faint); flex-shrink: 0; }
.dm-divider { height: 1px; background: var(--line); margin: 14px 0; }
.dm-place-desc {
  font-size: 13px; color: var(--text-dim);
  line-height: 1.65; margin-bottom: 4px;
}
.dm-actions {
  display: flex; gap: 8px; flex-wrap: wrap;
  margin-top: 18px;
  padding-top: 14px;
  border-top: 1px solid var(--line);
}
.dm-action-btn {
  flex: 1; min-width: 72px;
  padding: 10px 12px;
  border-radius: 6px;
  font-size: 12px; font-weight: 600;
  letter-spacing: 0.07em; text-transform: uppercase;
  text-align: center; cursor: pointer;
  transition: all 0.15s; text-decoration: none;
  display: inline-flex; align-items: center; justify-content: center; gap: 5px;
  border: 1px solid var(--line);
  color: var(--text-dim); background: transparent;
}
.dm-action-btn:hover { border-color: var(--accent); color: var(--accent); }
.dm-action-btn.dm-edit-action {
  background: var(--accent); color: #1a0f08; border-color: var(--accent);
}
.dm-action-btn.dm-edit-action:hover { background: var(--accent-2); border-color: var(--accent-2); }

/* ========== BOTÓN MAPA EN TARJETA ========== */
.map-btn {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 11px;
  color: var(--text-faint);
  text-decoration: none;
  background: var(--bg-3);
  border: 1px solid var(--line);
  padding: 2px 8px;
  border-radius: 100px;
  transition: color 0.15s, border-color 0.15s;
}
.map-btn:hover { color: var(--accent); border-color: rgba(233,163,107,0.5); }
.map-btn svg { flex-shrink: 0; }

/* ========== AMBIENTE ========== */
.grain {
  position: fixed; inset: 0; pointer-events: none; opacity: 0.025; z-index: 1;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence baseFrequency='0.9'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}

/* ========== LUGARES CERCANOS ========== */
.modal.nearby-modal {
  padding: 0;
  display: flex;
  flex-direction: column;
  max-height: 85vh;
  overflow: hidden;
}
.nearby-modal-hd {
  padding: 12px 20px 14px;
  border-bottom: 1px solid var(--line);
  flex-shrink: 0;
}
.nearby-modal-hd h2 {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-weight: 400;
  font-size: 22px;
  margin-bottom: 4px;
}
.nearby-modal-hd p {
  font-size: 12px;
  color: var(--text-dim);
  line-height: 1.4;
  margin: 0;
}
#nearby-list {
  overflow-y: auto;
  flex: 1;
  padding: 8px 8px calc(24px + env(safe-area-inset-bottom));
  -webkit-overflow-scrolling: touch;
}
.nearby-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 12px;
  border-radius: 10px;
  cursor: pointer;
  transition: background 0.15s;
  margin-bottom: 2px;
}
.nearby-item:hover, .nearby-item:active { background: var(--bg-3); }
.nearby-info { flex: 1; min-width: 0; }
.nearby-name { font-size: 14px; font-weight: 500; margin-bottom: 2px; line-height: 1.3; }
.nearby-city {
  font-size: 10px;
  color: var(--text-faint);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 4px;
}
.nearby-desc {
  font-size: 12px;
  color: var(--text-dim);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.nearby-dist {
  flex-shrink: 0;
  font-family: 'JetBrains Mono', monospace;
  font-size: 12px;
  color: var(--accent);
  min-width: 54px;
  text-align: right;
  padding-top: 2px;
}
.nearby-dist.far { color: var(--text-faint); font-size: 11px; }
.dist-chip {
  font-family: 'JetBrains Mono', monospace;
  font-size: 10px;
  color: var(--text-faint);
  display: inline-flex;
  align-items: center;
  gap: 2px;
}
header.top button.icon.location-active {
  border-color: var(--accent);
  color: var(--accent);
  background: rgba(233, 163, 107, 0.08);
}

/* ========== TAB BAR ========== */
.tab-bar {
  position: fixed;
  bottom: 0; left: 0; right: 0;
  z-index: 50;
  background: rgba(10, 10, 12, 0.92);
  backdrop-filter: blur(20px) saturate(1.2);
  -webkit-backdrop-filter: blur(20px) saturate(1.2);
  border-top: 1px solid var(--line);
  display: flex;
  padding-bottom: env(safe-area-inset-bottom);
}
.tab-btn {
  flex: 1;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: 4px;
  padding: 10px 8px 12px;
  background: transparent; border: none; cursor: pointer;
  color: var(--text-faint);
  transition: color 0.15s;
  -webkit-tap-highlight-color: transparent;
}
.tab-btn.active { color: var(--accent); }
.tab-btn svg { width: 22px; height: 22px; flex-shrink: 0; }
.tab-btn span {
  font-size: 10px;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  font-weight: 500;
  font-family: 'IBM Plex Sans', sans-serif;
}

/* ========== THUMBNAIL LUGAR ========== */
.place-thumb {
  flex-shrink: 0;
  width: 64px; height: 64px;
  border-radius: 8px;
  overflow: hidden;
  background: var(--bg-3);
  display: flex; align-items: center; justify-content: center;
  font-size: 24px;
  align-self: center;
}
.place-thumb img {
  width: 100%; height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 0.35s;
  display: block;
}
.place-thumb img.loaded { opacity: 1; }

/* ========== VISTA LUGARES ========== */
.places-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 20px 4px 14px;
}
.places-header h2 {
  font-family: 'Fraunces', serif;
  font-style: italic;
  font-weight: 400;
  font-size: 20px;
}
.loc-request-btn {
  font-size: 12px;
  background: var(--bg-3);
  border: 1px solid var(--line);
  color: var(--accent);
  padding: 6px 14px;
  border-radius: 100px;
  cursor: pointer;
  transition: all 0.15s;
}
.loc-request-btn:active { opacity: 0.7; }
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
        <button class="icon" id="exportBtn" title="Descargar backup">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        </button>
        <button class="icon" id="nearbyBtn" title="Lugares cercanos">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><circle cx="12" cy="12" r="3"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
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

  <nav class="tab-bar" id="tab-bar">
    <button class="tab-btn active" id="tab-itinerario">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
        <rect x="3" y="5" width="18" height="16" rx="2"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
        <line x1="8" y1="3" x2="8" y2="7"/>
        <line x1="16" y1="3" x2="16" y2="7"/>
      </svg>
      <span>Itinerario</span>
    </button>
    <button class="tab-btn" id="tab-lugares">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
        <circle cx="12" cy="10" r="3"/>
      </svg>
      <span>Lugares</span>
    </button>
  </nav>
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
        <input type="text" id="f_place" list="places-list" placeholder="Buscar lugar…" autocomplete="off">
        <datalist id="places-list"></datalist>
        <div id="place-info-panel" class="place-info-panel" style="display:none">
          <div id="pi-desc" class="pi-desc"></div>
          <div class="pi-chips">
            <span id="pi-duration" class="pi-chip"></span>
            <span id="pi-address" class="pi-chip"></span>
            <a id="pi-map" class="pi-map-link" target="_blank" rel="noopener" style="display:none">
              <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              Ver en mapa
            </a>
          </div>
        </div>
      </div>
      <div class="field">
        <label>Actividad</label>
        <input type="text" id="f_activity" list="activity-list" placeholder="Ej: Visitar Gran Vía">
        <datalist id="activity-list"></datalist>
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
          <select id="f_start_date">
            <option value="">— elegir fecha —</option>
          </select>
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

<!-- ========== MODAL DETALLE ========== -->
<div class="modal-backdrop" id="detail-modal">
  <div class="modal detail-modal">
    <!-- Carrusel de imágenes -->
    <div id="dm-carousel" class="dm-carousel" style="display:none">
      <div id="dm-spinner" class="dm-spinner"></div>
      <img id="dm-img" class="dm-img" src="" alt="">
      <button class="dm-carousel-btn dm-prev" id="dm-prev" style="display:none">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <button class="dm-carousel-btn dm-next" id="dm-next" style="display:none">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
      <div id="dm-dots" class="dm-dots"></div>
    </div>
    <!-- Handle + contenido -->
    <div class="dm-handle"></div>
    <div class="dm-body">
      <div class="dm-type-row">
        <div class="dm-icon-wrap" id="dm-icon-wrap"></div>
        <span id="dm-type-tag" class="tag"></span>
        <span id="dm-now-badge" class="now-badge" style="display:none">Ahora</span>
      </div>
      <div id="dm-activity" class="dm-activity"></div>

      <div id="dm-time-row" class="dm-info-row" style="display:none">
        <span class="dm-info-icon">🕐</span>
        <span id="dm-time-text" class="mono"></span>
      </div>
      <div id="dm-place-row" class="dm-info-row" style="display:none">
        <span class="dm-info-icon">📍</span>
        <span id="dm-place-text"></span>
      </div>
      <div id="dm-cost-row" class="dm-info-row" style="display:none">
        <span class="dm-info-icon">💰</span>
        <span id="dm-cost-text"></span>
      </div>
      <div id="dm-notes-row" class="dm-info-row" style="display:none">
        <span class="dm-info-icon">📝</span>
        <span id="dm-notes-text" style="font-style:italic;"></span>
      </div>

      <!-- Descripción del lugar del catálogo -->
      <div id="dm-desc-section" style="display:none">
        <div class="dm-divider"></div>
        <div id="dm-desc-text" class="dm-place-desc"></div>
        <div id="dm-dur-row" class="dm-info-row" style="display:none">
          <span class="dm-info-icon">⏱</span>
          <span id="dm-dur-text"></span>
        </div>
        <div id="dm-addr-row" class="dm-info-row" style="display:none">
          <span class="dm-info-icon">🗺️</span>
          <span id="dm-addr-text" style="font-size:12px;"></span>
        </div>
      </div>

      <div class="dm-actions">
        <a id="dm-map-btn" class="dm-action-btn" target="_blank" rel="noopener" style="display:none">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          Mapa
        </a>
        <a id="dm-url-btn" class="dm-action-btn" target="_blank" rel="noopener" style="display:none">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
          Reserva
        </a>
        <button id="dm-close-btn" class="dm-action-btn">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          Cerrar
        </button>
        <button id="dm-edit-btn" class="dm-action-btn dm-edit-action">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Editar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ========== MODAL LUGARES CERCANOS ========== -->
<div class="modal-backdrop" id="nearby-modal">
  <div class="modal nearby-modal">
    <div class="handle" style="margin: 16px auto 0;"></div>
    <div class="nearby-modal-hd">
      <h2 id="nearby-title"></h2>
      <p id="nearby-sub"></p>
    </div>
    <div id="nearby-list"></div>
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
  places: [],
  today: null,
  user: null,
  filterCity: 'all',
  editingId: null,
  imageCache: {},      // place_id → [url, ...]
  detailEvent: null,   // evento abierto en modal de detalle
  userLocation: null,  // { lat, lng } si geolocalización disponible
  activeTab: 'itinerario',
};
let dmImages = [];
let dmCurrentImg = 0;

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

function haversine(lat1, lng1, lat2, lng2) {
  const R = 6371;
  const dLat = (lat2 - lat1) * Math.PI / 180;
  const dLng = (lng2 - lng1) * Math.PI / 180;
  const a = Math.sin(dLat/2)**2 + Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) * Math.sin(dLng/2)**2;
  return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
}
function fmtDistance(km) {
  if (km < 1) return `${Math.round(km * 1000)} m`;
  if (km < 10) return `${km.toFixed(1)} km`;
  return `${Math.round(km)} km`;
}
// Busca el lugar del catálogo correspondiente a un evento (igual lógica que el modal detalle)
function findPlaceForEvent(e) {
  let p = e.place_id ? STATE.places.find(pl => pl.id == e.place_id) : null;
  if (!p) p = findPlace(e.place) || findPlace(e.activity) || null;
  if (!p && STATE.places.length) {
    const act = (e.activity || '').toLowerCase().trim();
    const plc = (e.place || '').toLowerCase().trim();
    p = STATE.places.find(pl => {
      const n = pl.name.toLowerCase();
      if (n.length <= 3) return false;
      if (act.includes(n) || plc.includes(n)) return true;
      if (act.length > 7 && n.includes(act)) return true;
      if (plc.length > 7 && n.includes(plc)) return true;
      return false;
    }) || null;
  }
  return p;
}

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

// Días exactos del viaje por ciudad (solo los que corresponden)
const CITY_VALID_DATES = {
  Bogota: [], // vacío = mostrar todo el viaje
  Madrid: ['2026-05-14','2026-05-15','2026-05-28','2026-05-29'],
  Paris:  ['2026-05-16','2026-05-17','2026-05-18','2026-05-19'],
  Milan:  ['2026-05-20','2026-05-21'],
  Roma:   ['2026-05-22','2026-05-23','2026-05-24','2026-05-25'],
  Bilbao: ['2026-05-25','2026-05-26','2026-05-27'],
};
function updateDateSelect(city) {
  const sel = $('#f_start_date');
  const prev = sel.value;
  sel.innerHTML = '<option value="">— elegir fecha —</option>';
  let dates = CITY_VALID_DATES[city];
  if (!dates || dates.length === 0) {
    // Sin ciudad o Bogotá: todos los días del viaje
    dates = [];
    for (let d = 14; d <= 29; d++) dates.push(`2026-05-${String(d).padStart(2,'0')}`);
  }
  dates.forEach(dateStr => {
    const [y, m, d] = dateStr.split('-').map(Number);
    const dt = new Date(y, m - 1, d);
    const o = document.createElement('option');
    o.value = dateStr;
    o.textContent = `${d} · ${WEEKDAYS[dt.getDay()]}`;
    sel.appendChild(o);
  });
  sel.value = prev; // restaurar si sigue válido
}

// Verbos para autocompletar actividad según tipo
const ACTIVITY_VERBS = {
  Actividad:      ['Visitar','Conocer','Explorar','Pasear por','Descubrir','Recorrer'],
  Comida:         ['Comer en','Almorzar en','Cenar en','Desayunar en','Tomar algo en'],
  Hospedaje:      ['Hospedaje en','Alojamiento en','Check-in en'],
  Traslado:       ['Traslado a','Traslado desde','Ir a'],
  Vuelo:          ['Vuelo a','Vuelo desde','Vuelo directo a'],
  Tren:           ['Tren a','Tren desde','Viaje en tren a'],
  Desplazamiento: ['Caminar a','Ir a pie a','Moverse a'],
  Seguro:         ['Contratar seguro','Seguro de viaje'],
  Otro:           ['Visitar','Ir a','Conocer'],
};
function updateActivityList() {
  const place = $('#f_place').value.trim();
  const type  = $('#f_type').value;
  const dl    = document.getElementById('activity-list');
  dl.innerHTML = '';
  const verbs = ACTIVITY_VERBS[type] || ACTIVITY_VERBS['Otro'];
  verbs.forEach(verb => {
    const o = document.createElement('option');
    o.value = place ? `${verb} ${place}` : verb;
    dl.appendChild(o);
  });
}
function fmtDuration(mins) {
  if (!mins) return '';
  const h = Math.floor(mins / 60);
  const m = mins % 60;
  if (h === 0) return `${m} min`;
  return m ? `${h} h ${m} min` : `${h} h`;
}
function findPlace(name) {
  if (!name || !STATE.places.length) return null;
  const q = name.trim().toLowerCase();
  return STATE.places.find(p => p.name.toLowerCase() === q) || null;
}
function updatePlaceInfo(name) {
  const panel = $('#place-info-panel');
  const place = findPlace(name);
  if (place) {
    $('#pi-desc').textContent = place.description || '';
    $('#pi-duration').textContent = place.duration_min ? `⏱ ${fmtDuration(parseInt(place.duration_min))}` : '';
    $('#pi-address').textContent = place.address ? `📍 ${place.address}` : '';
    const mapLink = $('#pi-map');
    if (place.lat && place.lng) {
      mapLink.href = `https://www.google.com/maps?q=${place.lat},${place.lng}`;
      mapLink.style.display = '';
    } else {
      mapLink.style.display = 'none';
    }
    panel.style.display = '';
    // Auto-sugerir duración si el campo está vacío
    if (place.duration_min && !$('#f_duration').value) {
      const h = parseInt(place.duration_min) / 60;
      const opts = [0.5, 1, 1.5, 2, 3, 4, 5, 6, 8, 12, 24];
      const closest = opts.reduce((a, b) => Math.abs(b - h) < Math.abs(a - h) ? b : a);
      $('#f_duration').value = String(closest);
      applyDuration();
    }
  } else {
    panel.style.display = 'none';
  }
}
function updatePlacesList(city) {
  const dl = document.getElementById('places-list');
  dl.innerHTML = '';
  // Lugares del catálogo (con metadata) primero
  const catalogNames = STATE.places
    .filter(p => !city || p.city === city)
    .map(p => p.name);
  // Lugares estáticos como fallback (aeropuertos, etc.)
  const staticNames = PLACES_BY_CITY[city] || [];
  const all = [...new Set([...catalogNames, ...staticNames])];
  all.forEach(name => {
    const o = document.createElement('option'); o.value = name; dl.appendChild(o);
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
async function loadPlaces() {
  try {
    const r = await api('places');
    STATE.places = r.places || [];
  } catch (e) { STATE.places = []; }
}

async function loadEvents() {
  $('#main').innerHTML = '<div class="loader"></div>';
  try {
    const me = await api('me');
    STATE.today = me.today;
    if (!STATE.places.length) await loadPlaces();
    const r = await api('list');
    STATE.events = r.events;
    render();
    silentLocationRequest();
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
  if (STATE.activeTab === 'lugares') {
    $('#addBtn').style.display = 'none';
    renderPlacesView();
  } else {
    $('#addBtn').style.display = '';
    renderItinerarioView();
  }
}

function renderItinerarioView() {
  const main = $('#main'); main.innerHTML = '';

  let events = STATE.events;
  if (STATE.filterCity !== 'all') {
    events = events.filter(e => e.city === STATE.filterCity || e.tentative);
  }

  const tentatives = events.filter(e => e.tentative);
  const dated      = events.filter(e => !e.tentative && e.start_date);
  const noDate     = events.filter(e => !e.tentative && !e.start_date);

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

  for (const dk of dayKeys) {
    main.appendChild(renderDayGroup(dk, byDay[dk]));
  }

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
}

function renderPlacesView() {
  const main = $('#main'); main.innerHTML = '';

  if (!STATE.places.length) {
    main.appendChild(el('div', { class: 'loader' }));
    loadPlaces().then(() => renderPlacesView());
    return;
  }

  let places = STATE.places.filter(p => p.lat && p.lng);
  if (STATE.filterCity !== 'all') {
    places = places.filter(p => p.city === STATE.filterCity);
  }

  if (STATE.userLocation) {
    const { lat, lng } = STATE.userLocation;
    places = places.map(p => ({ ...p, _dist: haversine(lat, lng, p.lat, p.lng) }));
    places.sort((a, b) => a._dist - b._dist);
  } else {
    places.sort((a, b) => (b.duration_min || 0) - (a.duration_min || 0));
  }

  const hdr = el('div', { class: 'places-header' },
    el('h2', {}, STATE.userLocation ? 'Cerca de ti' : 'Todos los lugares')
  );
  if (!STATE.userLocation) {
    const btn = el('button', { class: 'loc-request-btn',
      onclick: () => requestLocation(() => renderPlacesView())
    }, '📍 Activar ubicación');
    hdr.appendChild(btn);
  }
  main.appendChild(hdr);

  const list = el('div', { class: 'event-list' });
  places.forEach(p => list.appendChild(renderPlaceCard(p)));
  main.appendChild(list);
  // Cargar miniaturas ahora que los elementos están en el DOM
  loadAllThumbs();
}

// ---- Thumbnails para tarjetas de lugares ----
// Carga todas las miniaturas visibles en la vista de lugares
function loadAllThumbs() {
  document.querySelectorAll('.place-thumb[data-place-id]').forEach(thumbEl => {
    if (thumbEl.querySelector('img')) return; // ya tiene imagen
    const placeId = thumbEl.dataset.placeId;
    const place = STATE.places.find(p => String(p.id) === String(placeId));
    if (place) loadPlaceThumb(place, thumbEl);
  });
}

function showThumbInEl(thumbEl, imgUrl, altText) {
  const img = document.createElement('img');
  img.alt = altText || '';
  img.onload  = () => img.classList.add('loaded');
  img.onerror = () => { img.remove(); thumbEl.textContent = '📍'; };
  img.src = imgUrl;
  thumbEl.textContent = '';
  thumbEl.appendChild(img);
}

async function loadPlaceThumb(place, thumbEl) {
  const cached = STATE.imageCache[place.id];
  if (cached !== undefined) {
    // Usar el último elemento del cache = URL original de Wikipedia (siempre válida)
    if (cached.length) showThumbInEl(thumbEl, cached[cached.length - 1], place.name);
    return;
  }
  if (!place.wikipedia_title) { STATE.imageCache[place.id] = []; return; }
  try {
    const r = await fetch(
      `https://en.wikipedia.org/api/rest_v1/page/summary/${encodeURIComponent(place.wikipedia_title)}`,
      { signal: AbortSignal.timeout ? AbortSignal.timeout(6000) : undefined }
    );
    if (!r.ok) { STATE.imageCache[place.id] = []; return; }
    const data = await r.json();
    let images = [];
    let thumbUrl = null;
    if (data.thumbnail?.source) {
      const orig = data.thumbnail.source;
      const hi   = orig.replace(/\/\d+px-/, '/800px-');
      images = hi !== orig ? [hi, orig] : [orig];
      thumbUrl = orig; // URL original siempre funciona
    }
    STATE.imageCache[place.id] = images;
    if (thumbUrl) showThumbInEl(thumbEl, thumbUrl, place.name);
  } catch (_) {
    STATE.imageCache[place.id] = STATE.imageCache[place.id] || [];
  }
}

function renderPlaceCard(place) {
  const card = el('div', {
    class: 'event-card',
    style: '--type-color: #8ec59a;',
    onclick: () => openPlaceDetailModal(place)
  });
  card.appendChild(el('div', { class: 'accent-bar' }));

  // Thumbnail en vez del icono genérico
  const thumb = el('div', { class: 'place-thumb', 'data-place-id': place.id });
  const cachedImgs = STATE.imageCache[place.id];
  if (cachedImgs && cachedImgs.length) {
    showThumbInEl(thumb, cachedImgs[cachedImgs.length - 1], place.name);
  } else {
    thumb.textContent = '📍';
  }
  card.appendChild(thumb);

  const body = el('div', { class: 'body' });

  if (place._dist !== undefined) {
    body.appendChild(el('div', { class: 'time' }, fmtDistance(place._dist)));
  }

  body.appendChild(el('div', { class: 'activity' }, place.name));
  if (place.address) {
    body.appendChild(el('div', { class: 'place' }, place.address));
  }

  const meta_row = el('div', { class: 'place-meta' });
  meta_row.appendChild(el('span', { class: 'tag', style: '--type-color: #8ec59a;' }, place.city || ''));
  if (place.duration_min) {
    meta_row.appendChild(el('span', { class: 'dist-chip' }, `⏱ ${fmtDuration(parseInt(place.duration_min))}`));
  }

  if (place.lat && place.lng) {
    const distText = STATE.userLocation
      ? ` · ${fmtDistance(haversine(STATE.userLocation.lat, STATE.userLocation.lng, place.lat, place.lng))}`
      : '';
    const mapBtn = el('a', {
      class: 'map-btn',
      href: `https://www.google.com/maps?q=${place.lat},${place.lng}`,
      target: '_blank', rel: 'noopener',
      onclick: (ev) => ev.stopPropagation()
    });
    mapBtn.innerHTML = `<svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Mapa${distText}`;
    meta_row.appendChild(mapBtn);
  }

  body.appendChild(meta_row);

  if (place.description) {
    const preview = place.description.length > 110
      ? place.description.substring(0, 110) + '…'
      : place.description;
    body.appendChild(el('div', { class: 'notes' }, preview));
  }

  card.appendChild(body);
  return card;
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
    onclick: () => openDetailModal(e)
  });
  card.appendChild(el('div', { class: 'accent-bar' }));

  // Botón editar (esquina superior derecha)
  const editBtn = el('button', {
    class: 'card-edit-btn',
    title: 'Editar evento',
    onclick: (ev) => { ev.stopPropagation(); openEditModal(e); }
  });
  editBtn.innerHTML = '<svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>';
  card.appendChild(editBtn);
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

  // Botón Google Maps + distancia si el lugar tiene coordenadas en el catálogo
  const placeObj = findPlaceForEvent(e);
  if (placeObj && placeObj.lat && placeObj.lng) {
    const mapUrl = `https://www.google.com/maps?q=${placeObj.lat},${placeObj.lng}`;
    const distText = STATE.userLocation
      ? ` · ${fmtDistance(haversine(STATE.userLocation.lat, STATE.userLocation.lng, placeObj.lat, placeObj.lng))}`
      : '';
    const mapBtn = el('a', {
      class: 'map-btn',
      href: mapUrl,
      target: '_blank',
      rel: 'noopener',
      onclick: (ev) => ev.stopPropagation()
    });
    mapBtn.innerHTML = `<svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Mapa${distText}`;
    meta_row.appendChild(mapBtn);
  }

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
// MODAL DETALLE
// ============================================================
function closeDetailModal() {
  $('#detail-modal').classList.remove('show');
  STATE.detailEvent = null;
  dmImages = [];
  dmCurrentImg = 0;
  const img = $('#dm-img');
  img.src = '';
  img.classList.remove('loaded');
}

async function openDetailModal(e) {
  STATE.detailEvent = e;
  if (!STATE.places.length) await loadPlaces();
  const meta = TYPE_META[e.type] || TYPE_META['Otro'];
  const happening = isHappeningNow(e);

  // Icono y tipo
  $('#dm-icon-wrap').textContent = meta.icon;
  const tag = $('#dm-type-tag');
  tag.textContent = e.type || 'Otro';
  tag.style.setProperty('--type-color', meta.color);
  $('#dm-now-badge').style.display = happening ? '' : 'none';

  // Título
  $('#dm-activity').textContent = e.activity || '(Sin nombre)';

  // Hora
  let timeText = '';
  if (e.start_time && e.end_time && e.start_date === e.end_date) {
    timeText = `${fmtTime(e.start_time)} — ${fmtTime(e.end_time)}`;
  } else if (e.start_time) {
    timeText = fmtTime(e.start_time);
    if (e.end_date && e.end_date !== e.start_date) timeText += ` · hasta ${fmtDate(e.end_date)} ${fmtTime(e.end_time)}`;
  }
  const timeRow = $('#dm-time-row');
  if (timeText) { $('#dm-time-text').textContent = timeText; timeRow.style.display = ''; }
  else { timeRow.style.display = 'none'; }

  // Lugar
  const placeRow = $('#dm-place-row');
  if (e.place && e.place !== e.activity) { $('#dm-place-text').textContent = e.place; placeRow.style.display = ''; }
  else { placeRow.style.display = 'none'; }

  // Costo
  const costRow = $('#dm-cost-row');
  if (e.cost) { $('#dm-cost-text').textContent = e.cost; costRow.style.display = ''; }
  else { costRow.style.display = 'none'; }

  // Notas
  const notesRow = $('#dm-notes-row');
  if (e.notes) { $('#dm-notes-text').textContent = e.notes; notesRow.style.display = ''; }
  else { notesRow.style.display = 'none'; }

  // URL reserva
  const urlBtn = $('#dm-url-btn');
  if (e.url) { urlBtn.href = e.url; urlBtn.style.display = ''; }
  else { urlBtn.style.display = 'none'; }

  // Lugar del catálogo: intentar por place_id, luego por nombre exacto, luego por contención
  let placeObj = e.place_id ? STATE.places.find(p => p.id == e.place_id) : null;
  if (!placeObj) {
    placeObj = findPlace(e.place) || findPlace(e.activity) || null;
  }
  if (!placeObj && STATE.places.length) {
    const act = (e.activity || '').toLowerCase().trim();
    const plc = (e.place || '').toLowerCase().trim();
    placeObj = STATE.places.find(p => {
      const n = p.name.toLowerCase();
      if (n.length <= 3) return false;
      // catálogo en evento (ej. "coliseo" en "coliseo, foro y palatino")
      if (act.includes(n) || plc.includes(n)) return true;
      // evento en catálogo (ej. "montmartre" en "barrio de montmartre")
      // umbral > 7 para no matchear con nombres de ciudad sueltos ("París", "Roma")
      if (act.length > 7 && n.includes(act)) return true;
      if (plc.length > 7 && n.includes(plc)) return true;
      return false;
    }) || null;
  }
  const descSection = $('#dm-desc-section');
  if (placeObj && placeObj.description) {
    $('#dm-desc-text').textContent = placeObj.description;
    const durRow = $('#dm-dur-row');
    if (placeObj.duration_min) { $('#dm-dur-text').textContent = `Visita estimada: ${fmtDuration(parseInt(placeObj.duration_min))}`; durRow.style.display = ''; }
    else { durRow.style.display = 'none'; }
    const addrRow = $('#dm-addr-row');
    if (placeObj.address) { $('#dm-addr-text').textContent = placeObj.address; addrRow.style.display = ''; }
    else { addrRow.style.display = 'none'; }
    descSection.style.display = '';
  } else {
    descSection.style.display = 'none';
  }

  // Botón Mapa con distancia
  const mapBtn = $('#dm-map-btn');
  if (placeObj && placeObj.lat && placeObj.lng) {
    mapBtn.href = `https://www.google.com/maps?q=${placeObj.lat},${placeObj.lng}`;
    const distText = STATE.userLocation
      ? ` · ${fmtDistance(haversine(STATE.userLocation.lat, STATE.userLocation.lng, placeObj.lat, placeObj.lng))}`
      : '';
    mapBtn.innerHTML = `<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Mapa${distText}`;
    mapBtn.style.display = '';
  } else { mapBtn.style.display = 'none'; }

  // Ocultar editar cuando se abre desde "Lugares cercanos" (sin id de evento)
  $('#dm-edit-btn').style.display = (e.id !== null && e.id !== undefined) ? '' : 'none';

  $('#detail-modal').classList.add('show');

  // Carrusel de imágenes (async)
  $('#dm-carousel').style.display = 'none';
  dmImages = [];
  dmCurrentImg = 0;
  if (placeObj) await loadDetailImages(placeObj);
}

async function loadDetailImages(place) {
  const cacheKey = place.id;
  if (STATE.imageCache[cacheKey] !== undefined) {
    applyDetailImages(STATE.imageCache[cacheKey]);
    return;
  }

  let images = [];
  // Imágenes almacenadas en BD
  if (place.images) {
    try { images = JSON.parse(place.images).filter(Boolean); } catch (_) {}
  }

  // Si no hay imágenes almacenadas, buscar en Wikipedia
  if (!images.length && place.wikipedia_title) {
    const carousel = $('#dm-carousel');
    carousel.style.display = '';
    $('#dm-spinner').style.display = '';
    try {
      const r = await fetch(
        `https://en.wikipedia.org/api/rest_v1/page/summary/${encodeURIComponent(place.wikipedia_title)}`,
        { signal: AbortSignal.timeout ? AbortSignal.timeout(6000) : undefined }
      );
      if (r.ok) {
        const data = await r.json();
        if (data.thumbnail && data.thumbnail.source) {
          const original = data.thumbnail.source;
          // Intentar 800px; si falla onerror volverá al original
          const highRes = original.replace(/\/\d+px-/, '/800px-');
          images = highRes !== original ? [highRes, original] : [original];
        }
      }
    } catch (_) {}
    $('#dm-spinner').style.display = 'none';
  }

  STATE.imageCache[cacheKey] = images;
  applyDetailImages(images);
}

function applyDetailImages(images) {
  dmImages = images.filter(Boolean);
  dmCurrentImg = 0;
  const carousel = $('#dm-carousel');
  if (!dmImages.length) { carousel.style.display = 'none'; return; }
  carousel.style.display = '';
  renderDmCarousel();
}

function renderDmCarousel() {
  const img = $('#dm-img');
  const prev = $('#dm-prev');
  const next = $('#dm-next');
  const dots = $('#dm-dots');
  const spinner = $('#dm-spinner');

  spinner.style.display = 'none';
  img.style.opacity = '';   // limpiar cualquier inline style residual
  img.classList.remove('loaded');
  img.src = '';

  if (!dmImages.length) { $('#dm-carousel').style.display = 'none'; return; }

  // Dots
  dots.innerHTML = '';
  if (dmImages.length > 1) {
    dmImages.forEach((_, i) => {
      const d = el('span', { class: 'dm-dot' + (i === dmCurrentImg ? ' active' : ''), onclick: () => { dmCurrentImg = i; renderDmCarousel(); } });
      dots.appendChild(d);
    });
  }

  prev.style.display = dmImages.length > 1 ? '' : 'none';
  next.style.display = dmImages.length > 1 ? '' : 'none';

  img.onload = () => img.classList.add('loaded');
  img.onerror = () => {
    // Imagen fallida: intentar siguiente o esconder
    if (dmCurrentImg < dmImages.length - 1) {
      dmCurrentImg++;
      renderDmCarousel();
    } else {
      $('#dm-carousel').style.display = 'none';
    }
  };
  img.src = dmImages[dmCurrentImg];
}

$('#dm-prev').addEventListener('click', () => {
  dmCurrentImg = (dmCurrentImg - 1 + dmImages.length) % dmImages.length;
  renderDmCarousel();
});
$('#dm-next').addEventListener('click', () => {
  dmCurrentImg = (dmCurrentImg + 1) % dmImages.length;
  renderDmCarousel();
});
$('#dm-close-btn').addEventListener('click', closeDetailModal);
$('#detail-modal').addEventListener('click', (ev) => { if (ev.target === $('#detail-modal')) closeDetailModal(); });
$('#dm-edit-btn').addEventListener('click', () => {
  const e = STATE.detailEvent;
  if (!e) return;
  closeDetailModal();
  openEditModal(e);
});

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
  $('#place-info-panel').style.display = 'none';
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
  updateDateSelect(autoCity);
  $('#f_start_date').value = initDate; // restaurar después de poblar el select
  updateActivityList();
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
  updatePlaceInfo(e.place || '');
  $('#f_type').value = e.type || 'Actividad';
  $('#f_start_date').value = e.start_date || '';
  setTimeSelect('f_start_time', e.start_time || '');
  $('#f_duration').value = '';          // duración vacía al editar
  $('#f_end_date').value = e.end_date || '';   // preservar fin existente
  $('#f_end_time').value = e.end_time || '';
  $('#f_city').value = e.city || '';
  updatePlacesList(e.city || '');
  updateDateSelect(e.city || '');
  $('#f_start_date').value = e.start_date || '';
  updateActivityList();
  $('#f_cost').value = e.cost || '';
  $('#f_notes').value = e.notes || '';
  $('#f_url').value = e.url || '';
  $('#f_tentative').checked = !!parseInt(e.tentative);
  openModal();
}

$('#addBtn').addEventListener('click', openNewModal);
$('#cancelBtn').addEventListener('click', closeModal);
$('#modal').addEventListener('click', (e) => { if (e.target === $('#modal')) closeModal(); });

// Al elegir fecha: recalcular fin (ciudad ya está fija por el select de fechas)
$('#f_start_date').addEventListener('change', applyDuration);
// Al cambiar hora o duración: recalcular fin
$('#f_start_time').addEventListener('change', applyDuration);
$('#f_duration').addEventListener('change', applyDuration);
// Al cambiar ciudad: filtrar fechas + actualizar lugares + actualizar sugerencias
$('#f_city').addEventListener('change', () => {
  const city = $('#f_city').value;
  updatePlacesList(city);
  updateDateSelect(city);
  updateActivityList();
});
// Al elegir lugar o tipo: actualizar sugerencias de actividad + info del lugar
$('#f_place').addEventListener('input', () => {
  updateActivityList();
  updatePlaceInfo($('#f_place').value);
});
$('#f_place').addEventListener('change', () => {
  updateActivityList();
  updatePlaceInfo($('#f_place').value);
});
$('#f_type').addEventListener('change', updateActivityList);

$('#saveBtn').addEventListener('click', async () => {
  const btn = $('#saveBtn'); btn.disabled = true;
  const placeName = $('#f_place').value.trim();
  const placeObj  = findPlace(placeName);
  const data = {
    activity:   $('#f_activity').value.trim(),
    place:      placeName,
    type:       $('#f_type').value,
    start_date: $('#f_start_date').value,
    start_time: $('#f_start_time').value,
    end_date:   $('#f_end_date').value,
    end_time:   $('#f_end_time').value,
    city:       $('#f_city').value.trim(),
    cost:       $('#f_cost').value.trim(),
    notes:      $('#f_notes').value.trim(),
    url:        $('#f_url').value.trim(),
    tentative:  $('#f_tentative').checked ? 1 : 0,
    place_id:   placeObj ? placeObj.id : null
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

$('#exportBtn').addEventListener('click', async () => {
  try {
    const r = await api('list');
    // Formato idéntico a seed.json — se puede usar para actualizar el repo
    const seed = r.events.map(e => ({
      start_date: e.start_date || '',
      start_time: e.start_time || '',
      end_date:   e.end_date   || '',
      end_time:   e.end_time   || '',
      place:      e.place      || '',
      activity:   e.activity   || '',
      type:       e.type       || 'Actividad',
      cost:       e.cost       || '',
      notes:      e.notes      || '',
      url:        e.url        || '',
      city:       e.city       || '',
      tentative:  parseInt(e.tentative)  || 0,
      sort_order: parseInt(e.sort_order) || 0,
    }));
    const json = JSON.stringify(seed, null, 2);
    const blob = new Blob([json], { type: 'application/json' });
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');
    a.href     = url;
    a.download = `itinerario-backup-${STATE.today || new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    toast(`${seed.length} eventos exportados`);
  } catch (err) {
    toast('Error al exportar');
  }
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
// GEOLOCALIZACIÓN Y LUGARES CERCANOS
// ============================================================
function requestLocation(onSuccess) {
  if (!navigator.geolocation) {
    toast('Geolocalización no disponible en este navegador');
    return;
  }
  navigator.geolocation.getCurrentPosition(
    (pos) => {
      STATE.userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
      $('#nearbyBtn').classList.add('location-active');
      if (onSuccess) onSuccess();
      else render(); // actualizar distancias en tarjetas
    },
    (err) => {
      if (err.code === 1) toast('Permiso de ubicación denegado');
      else toast('No se pudo obtener la ubicación');
      if (onSuccess) onSuccess(); // mostrar modal sin distancias
    },
    { enableHighAccuracy: false, timeout: 10000, maximumAge: 120000 }
  );
}

function silentLocationRequest() {
  if (!navigator.geolocation || STATE.userLocation) return;
  navigator.geolocation.getCurrentPosition(
    (pos) => {
      STATE.userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
      $('#nearbyBtn').classList.add('location-active');
      render();
    },
    () => { /* silencioso */ },
    { enableHighAccuracy: false, timeout: 5000, maximumAge: 300000 }
  );
}

function openPlaceDetailModal(place) {
  openDetailModal({
    id: null,
    activity: place.name,
    place: place.address || '',
    type: 'Actividad',
    start_date: null, start_time: null,
    end_date: null, end_time: null,
    cost: null, notes: null, url: null,
    city: place.city,
    place_id: place.id
  });
}

async function showNearbyModal() {
  if (!STATE.places.length) await loadPlaces();

  let places = STATE.places.filter(p => p.lat && p.lng);
  let title, subtitle;
  let allFar = false;

  if (STATE.userLocation) {
    const { lat, lng } = STATE.userLocation;
    places = places.map(p => ({ ...p, _dist: haversine(lat, lng, p.lat, p.lng) }));
    places.sort((a, b) => a._dist - b._dist);
    const nearest = places[0]?._dist ?? Infinity;
    allFar = nearest > 100;
    if (allFar) {
      title = 'Lugares de interés';
      subtitle = `Todos los sitios están a más de 100 km. Estos son los más destacados del viaje:`;
      places.sort((a, b) => (b.duration_min || 0) - (a.duration_min || 0));
    } else {
      const nearby = places.filter(p => p._dist <= 100).length;
      title = 'Lugares cercanos';
      subtitle = `${nearby} lugar${nearby !== 1 ? 'es' : ''} a menos de 100 km de ti`;
    }
  } else {
    title = 'Lugares cercanos';
    subtitle = 'Obteniendo tu ubicación…';
    places.sort((a, b) => (b.duration_min || 0) - (a.duration_min || 0));
  }

  $('#nearby-title').textContent = title;
  $('#nearby-sub').textContent = subtitle;

  const list = $('#nearby-list');
  list.innerHTML = '';

  places.slice(0, 25).forEach(place => {
    const item = el('div', { class: 'nearby-item', onclick: () => {
      $('#nearby-modal').classList.remove('show');
      openPlaceDetailModal(place);
    }});

    const info = el('div', { class: 'nearby-info' },
      el('div', { class: 'nearby-name' }, place.name),
      el('div', { class: 'nearby-city' }, place.city),
      el('div', { class: 'nearby-desc' }, place.description || '')
    );

    item.appendChild(info);

    if (place._dist !== undefined) {
      const far = place._dist > 100;
      const distEl = el('div', { class: 'nearby-dist' + (far ? ' far' : '') },
        fmtDistance(place._dist)
      );
      item.appendChild(distEl);
    }

    list.appendChild(item);
  });

  $('#nearby-modal').classList.add('show');

  if (!STATE.userLocation) {
    requestLocation(() => showNearbyModal());
  }
}

$('#nearbyBtn').addEventListener('click', () => showNearbyModal());
$('#nearby-modal').addEventListener('click', (ev) => {
  if (ev.target === $('#nearby-modal')) $('#nearby-modal').classList.remove('show');
});

// ============================================================
// TAB BAR
// ============================================================
function setActiveTab(tab) {
  STATE.activeTab = tab;
  $('#tab-itinerario').classList.toggle('active', tab === 'itinerario');
  $('#tab-lugares').classList.toggle('active', tab === 'lugares');
  render();
}
$('#tab-itinerario').addEventListener('click', () => setActiveTab('itinerario'));
$('#tab-lugares').addEventListener('click', () => {
  setActiveTab('lugares');
  if (!STATE.userLocation) silentLocationRequest();
});

// ============================================================
// INIT
// ============================================================
tryRestoreSession();
</script>
</body>
</html>
