<?php
// Admin routing shim for URLs like /admin/index, /admin/orders, /admin/login
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

// Normalize request path relative to /admin
$path = trim(parse_url($requestUri, PHP_URL_PATH), '/');
$segments = explode('/', $path);
$adminIndex = array_search('admin', $segments, true);
if ($adminIndex !== false) {
    $segments = array_slice($segments, $adminIndex + 1);
}

$page = implode('/', $segments);
if ($page === '' || $page === 'admin') {
    $page = 'index';
}

// Map pretty route to pages/admin file
$target = __DIR__ . '/../pages/admin/' . $page . '.php';

if (file_exists($target)) {
    include $target;
    return;
}

http_response_code(404);
echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Admin Page Not Found</title></head><body><h1>404 Admin Page Not Found</h1><p>The requested admin page could not be found.</p></body></html>';
