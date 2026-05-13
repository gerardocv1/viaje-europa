#!/usr/bin/env bash
# ============================================================
# start.sh — Levanta la app de itinerario localmente
# Uso: ./start.sh
# ============================================================

set -e

# --- Configuración ---
PORT=8080
HOST=0.0.0.0   # 0.0.0.0 = accesible desde el celular en la misma WiFi
                # cambiar a 127.0.0.1 para solo localhost
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# --- Colores ---
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
BOLD='\033[1m'
NC='\033[0m'

cd "$SCRIPT_DIR"

# --- Verificar PHP ---
if ! command -v php &> /dev/null; then
    echo -e "${RED}✗ PHP no está instalado o no está en PATH${NC}"
    echo "  Instálalo con:"
    echo "    macOS:  brew install php"
    echo "    Linux:  sudo apt install php-cli php-sqlite3"
    exit 1
fi

PHP_VERSION=$(php -v | head -1 | awk '{print $2}')
echo -e "${GREEN}✓${NC} PHP $PHP_VERSION detectado"

# --- Verificar pdo_sqlite ---
if ! php -m | grep -qi "pdo_sqlite"; then
    echo -e "${RED}✗ Falta el módulo pdo_sqlite${NC}"
    echo "  Instálalo con:"
    echo "    macOS:  ya viene con PHP de Homebrew"
    echo "    Linux:  sudo apt install php-sqlite3"
    exit 1
fi
echo -e "${GREEN}✓${NC} pdo_sqlite disponible"

# --- Verificar archivos ---
for f in config.php api.php index.php; do
    if [ ! -f "$f" ]; then
        echo -e "${RED}✗ Falta el archivo: $f${NC}"
        exit 1
    fi
done
echo -e "${GREEN}✓${NC} Archivos del proyecto encontrados"

# --- Inicializar BD si no existe ---
if [ ! -f "itinerario.db" ]; then
    if [ ! -f "init.php" ] || [ ! -f "seed.json" ]; then
        echo -e "${YELLOW}⚠${NC}  No existe itinerario.db y faltan init.php/seed.json para crearla."
        echo "   Si es la primera vez, asegúrate de tener init.php y seed.json en esta carpeta."
        exit 1
    fi
    echo -e "${YELLOW}⚠${NC}  No existe itinerario.db — inicializando..."
    php -r "
        \$_SERVER['REQUEST_METHOD'] = 'GET';
        ob_start();
        require 'init.php';
        \$out = ob_get_clean();
        if (strpos(\$out, 'Cargados') !== false) {
            preg_match('/Cargados.*?<strong>(\d+) eventos/', \$out, \$m);
            echo \"   → Cargados \" . (\$m[1] ?? '?') . \" eventos\\n\";
        } else {
            echo \$out;
            exit(1);
        }
    "
    echo -e "${GREEN}✓${NC} Base de datos lista"
else
    EVENT_COUNT=$(php -r "
        \$db = new PDO('sqlite:itinerario.db');
        echo \$db->query('SELECT COUNT(*) FROM events')->fetchColumn();
    " 2>/dev/null || echo "?")
    echo -e "${GREEN}✓${NC} Base de datos existente con $EVENT_COUNT eventos"
fi

# --- Verificar que el puerto esté libre ---
if command -v lsof &> /dev/null; then
    if lsof -Pi :$PORT -sTCP:LISTEN -t >/dev/null 2>&1; then
        echo -e "${RED}✗ El puerto $PORT está en uso${NC}"
        echo "  Mata el proceso con: lsof -ti:$PORT | xargs kill"
        echo "  O edita este script y cambia PORT a otro número."
        exit 1
    fi
fi

# --- Detectar IP local para acceso desde celular ---
LOCAL_IP=""
if [[ "$OSTYPE" == "darwin"* ]]; then
    LOCAL_IP=$(ipconfig getifaddr en0 2>/dev/null || ipconfig getifaddr en1 2>/dev/null || echo "")
elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
    LOCAL_IP=$(hostname -I 2>/dev/null | awk '{print $1}' || echo "")
fi

# --- Mostrar info y arrancar ---
echo ""
echo -e "${BOLD}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BOLD}  Itinerario — Servidor local${NC}"
echo -e "${BOLD}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""
echo -e "  Local:    ${BLUE}http://localhost:$PORT${NC}"
if [ -n "$LOCAL_IP" ]; then
    echo -e "  Red:      ${BLUE}http://$LOCAL_IP:$PORT${NC}   ${YELLOW}← abre este desde el celular${NC}"
fi
echo ""
echo -e "  ${YELLOW}Clave compartida:${NC} (la que pusiste en config.php)"
echo ""
echo -e "  Para detener: Ctrl+C"
echo -e "${BOLD}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# --- Intentar abrir el navegador ---
URL="http://localhost:$PORT"
(sleep 1.2 && {
    if [[ "$OSTYPE" == "darwin"* ]]; then
        open "$URL" 2>/dev/null
    elif command -v xdg-open &> /dev/null; then
        xdg-open "$URL" 2>/dev/null
    fi
}) &

# --- Arrancar el servidor PHP ---
exec php -S $HOST:$PORT
