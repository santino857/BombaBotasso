<?php

// Ajustar nombres de script para que el enrutador y base_url de CodeIgniter reconozcan la raíz
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF']    = '/index.php';

// Cargar variables desde el archivo 'env' si no existe '.env' (ya que .env suele ignorarse en git)
$envFile = __DIR__ . '/../env';
if (!file_exists(__DIR__ . '/../.env') && file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if (getenv($key) === false) {
                putenv("{$key}={$value}");
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
}

// Requerir el controlador frontal público de CodeIgniter 4
require __DIR__ . '/../public/index.php';
