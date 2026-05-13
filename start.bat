@echo off
REM ============================================================
REM start.bat — Levanta la app de itinerario localmente (Windows)
REM Uso: doble click o desde CMD: start.bat
REM ============================================================

setlocal enabledelayedexpansion
cd /d "%~dp0"

set PORT=8080
set HOST=0.0.0.0

REM --- Verificar PHP ---
where php >nul 2>nul
if errorlevel 1 (
    echo [X] PHP no esta instalado o no esta en PATH
    echo     Descargalo de: https://windows.php.net/download/
    pause
    exit /b 1
)

for /f "tokens=2" %%v in ('php -v ^| findstr /b "PHP"') do (
    set PHP_VERSION=%%v
    goto :phpdone
)
:phpdone
echo [OK] PHP !PHP_VERSION! detectado

REM --- Verificar pdo_sqlite ---
php -m | findstr /i "pdo_sqlite" >nul
if errorlevel 1 (
    echo [X] Falta el modulo pdo_sqlite en PHP
    echo     Edita php.ini y descomenta: extension=pdo_sqlite
    pause
    exit /b 1
)
echo [OK] pdo_sqlite disponible

REM --- Verificar archivos ---
if not exist "config.php" ( echo [X] Falta config.php & pause & exit /b 1 )
if not exist "api.php" ( echo [X] Falta api.php & pause & exit /b 1 )
if not exist "index.php" ( echo [X] Falta index.php & pause & exit /b 1 )
echo [OK] Archivos del proyecto encontrados

REM --- Inicializar BD si no existe ---
if not exist "itinerario.db" (
    if not exist "init.php" ( echo [X] Falta itinerario.db e init.php ^& pause ^& exit /b 1 )
    if not exist "seed.json" ( echo [X] Falta itinerario.db y seed.json ^& pause ^& exit /b 1 )
    echo [!] Inicializando base de datos...
    php -r "$_SERVER['REQUEST_METHOD']='GET'; ob_start(); require 'init.php'; $out=ob_get_clean(); preg_match('/Cargados.*?<strong>(\d+) eventos/', $out, $m); echo '   -> Cargados ' . ($m[1] ?? '?') . ' eventos' . PHP_EOL;"
    echo [OK] Base de datos lista
) else (
    for /f %%c in ('php -r "$db=new PDO('sqlite:itinerario.db'); echo $db->query('SELECT COUNT(*) FROM events')->fetchColumn();"') do set COUNT=%%c
    echo [OK] Base de datos existente con !COUNT! eventos
)

REM --- Detectar IP local ---
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /R /C:"IPv4.*: 192\." /C:"IPv4.*: 10\."') do (
    set LOCAL_IP=%%a
    set LOCAL_IP=!LOCAL_IP: =!
    goto :ipdone
)
:ipdone

echo.
echo =====================================================
echo   Itinerario - Servidor local
echo =====================================================
echo.
echo   Local:    http://localhost:%PORT%
if defined LOCAL_IP echo   Red:      http://!LOCAL_IP!:%PORT%   ^<- abre este desde el celular
echo.
echo   Clave compartida: (la que pusiste en config.php)
echo.
echo   Para detener: Ctrl+C
echo =====================================================
echo.

REM --- Abrir navegador ---
start "" http://localhost:%PORT%

REM --- Arrancar PHP ---
php -S %HOST%:%PORT%
