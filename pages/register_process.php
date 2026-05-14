<?php
require_once __DIR__ . '/../config/bootstrap.php';
use Mpemba\Controller\UserController;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /register');
    exit;
}

$username = trim((string)($_POST['username'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$password = (string)($_POST['password'] ?? '');

if ($username === '' || $email === '' || $password === '') {
    $_SESSION['register_error'] = 'All fields are required.';
    header('Location: /register');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = 'Invalid email address.';
    header('Location: /register');
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['register_error'] = 'Password must be at least 6 characters.';
    header('Location: /register');
    exit;
}

$controller = new UserController();
$result = $controller->register($username, $email, $password);

if (!empty($result['success'])) {
    header('Location: /home');
    exit;
} else {
    $_SESSION['register_error'] = $result['message'] ?? 'Registration failed.';
    header('Location: /register');
    exit;
}
