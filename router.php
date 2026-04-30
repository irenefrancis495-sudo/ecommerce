<?php
// Simple router for PHP built-in server

$requestUri = $_SERVER["REQUEST_URI"];

// Handle API requests
if (preg_match('#^/api/([^?]+)#', $requestUri, $matches)) {
    $apiFile = __DIR__ . '/api/' . $matches[1];
    if (file_exists($apiFile)) {
        include $apiFile;
        exit(); // Stop execution after serving API
    }
}

// Handle static files
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg)$/', $requestUri)) {
    return false; // serve the requested resource as-is
} else {
    include __DIR__ . '/index.php';
}
?>