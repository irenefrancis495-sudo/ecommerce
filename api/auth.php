<?php
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Controller\UserController;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$action = $_GET['action'] ?? '';

$userController = new UserController();

try {
    switch ($action) {
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Method not allowed', 405);
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $username = trim($data['username'] ?? '');
            $password = $data['password'] ?? '';

            if (empty($username) || empty($password)) {
                throw new Exception('Username and password are required', 400);
            }

            $result = $userController->login($username, $password);

            if ($result['success']) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(401);
                echo json_encode($result);
            }
            break;

        case 'register':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Method not allowed', 405);
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $username = trim($data['username'] ?? '');
            $email = trim($data['email'] ?? '');
            $password = $data['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                throw new Exception('All fields are required', 400);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format', 400);
            }

            if (strlen($password) < 6) {
                throw new Exception('Password must be at least 6 characters', 400);
            }

            $result = $userController->register($username, $email, $password);

            if ($result['success']) {
                http_response_code(201);
                echo json_encode($result);
            } else {
                http_response_code(400);
                echo json_encode($result);
            }
            break;

        case 'logout':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Method not allowed', 405);
            }

            $result = $userController->logout();
            echo json_encode($result);
            break;

        case 'check':
            $user = $userController->getCurrentUser();
            if ($user) {
                echo json_encode(['success' => true, 'user' => $user]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Not logged in']);
            }
            break;

        default:
            throw new Exception('Invalid action', 400);
    }
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>