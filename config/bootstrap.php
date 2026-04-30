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

// Start session
session_start();
?>