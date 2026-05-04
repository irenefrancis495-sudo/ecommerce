<?php
require_once __DIR__ . '/../../config/bootstrap.php';

use Mpemba\Controller\UserController;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<script>window.location.href="/admin/login";</script>';
    return;
}

$login = trim((string) ($_POST['login'] ?? $_POST['email'] ?? ''));
$password = trim((string) ($_POST['password'] ?? ''));

$userController = new UserController();
$result = $userController->loginAdmin($login, $password);

if ($result && $result['success']) {
    echo '<script>window.location.href="/admin/index";</script>';
    return;
}

$_SESSION['auth_error'] = 'Invalid credentials';
echo '<script>window.location.href="/admin/login";</script>';
return;
