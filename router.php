<?php
// Simple router for PHP built-in server

$requestUri = $_SERVER["REQUEST_URI"];

// Handle uploads directory
if (preg_match('#^/uploads/(.+)$#', $requestUri, $matches)) {
    $uploadFile = __DIR__ . '/uploads/' . $matches[1];
    if (file_exists($uploadFile) && is_file($uploadFile)) {
        $mimeType = mime_content_type($uploadFile);
        header('Content-Type: ' . $mimeType);
        header('Cache-Control: public, max-age=31536000');
        readfile($uploadFile);
        exit();
    } else {
        http_response_code(404);
        echo 'File not found';
        exit();
    }
}

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