<?php
// Login processing endpoint (form-friendly and AJAX-aware)
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Controller\UserController;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$username = trim((string)($_POST['username'] ?? ''));
$password = (string)($_POST['password'] ?? '');
$next = trim((string)($_POST['next'] ?? '/home'));

if ($username === '' || $password === '') {
    $payload = ['success' => false, 'message' => 'Username and password are required'];
    echo json_encode($payload);
    exit;
}

$controller = new UserController();
$result = $controller->login($username, $password);

// If request is AJAX (XHR) or Accepts JSON, return JSON
$isXhr = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
$acceptsJson = strpos(strtolower($_SERVER['HTTP_ACCEPT'] ?? ''), 'application/json') !== false;

if ($isXhr || $acceptsJson) {
    // If controller didn't provide redirect, include a sensible default
    if (!isset($result['redirect'])) {
        $result['redirect'] = $result['success'] ? $next : null;
    }
    echo json_encode($result);
    exit;
}

// Non-AJAX: redirect on success, otherwise set a session flash and redirect back to login
if (!empty($result['success'])) {
    $redirect = $result['redirect'] ?? $next;
    header('Location: ' . $redirect);
    exit;
} else {
    $_SESSION['login_error'] = $result['message'] ?? 'Login failed';
    header('Location: /login');
    exit;
}
