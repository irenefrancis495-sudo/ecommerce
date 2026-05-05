<?php
// Simple autoloader for Mpemba namespace
spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $class = str_replace('Mpemba\\', '', $class);
    $class = str_replace('\\', '/', $class);

    $file = __DIR__ . '/../' . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Start session with a shared cookie path so auth sessions work across the storefront and API endpoints.
$cookieParams = session_get_cookie_params();
session_set_cookie_params([
    'lifetime' => $cookieParams['lifetime'],
    'path' => '/',
    'domain' => $cookieParams['domain'],
    'secure' => $cookieParams['secure'],
    'httponly' => $cookieParams['httponly'],
    'samesite' => $cookieParams['samesite'] ?? 'Lax',
]);
session_start();
?>