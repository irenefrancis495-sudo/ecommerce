<?php
require_once 'config/bootstrap.php';
session_start();

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$path = preg_replace('#^api\.php/?#', '', $path);
$segments = array_values(array_filter(explode('/', $path)));
$resource = $segments[0] ?? '';
$id = $segments[1] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

switch ($resource) {
    case 'orders':
        if ($method === 'GET' && $id) {
            Mpemba\Controller\OrderController::show($id);
        } elseif ($method === 'GET') {
            Mpemba\Controller\OrderController::index();
        } elseif ($method === 'POST') {
            Mpemba\Controller\OrderController::store();
        } elseif ($method === 'PUT' && $id) {
            Mpemba\Controller\OrderController::updateStatus($id);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
    case 'login':
        if ($method === 'POST') {
            Mpemba\Controller\UserController::login();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
    case 'logout':
        if ($method === 'POST') {
            Mpemba\Controller\UserController::logout();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
    case 'register':
        if ($method === 'POST') {
            Mpemba\Controller\UserController::register();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
    case 'user':
        if ($method === 'GET') {
            Mpemba\Controller\UserController::current();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
?>