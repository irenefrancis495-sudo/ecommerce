<?php
// Simple admin authentication (replace with DB in production)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<script>window.location.href="/admin/login";</script>';
    return;
}

$login = trim((string) ($_POST['login'] ?? $_POST['email'] ?? ''));
$password = trim((string) ($_POST['password'] ?? ''));

// Hard-coded admin user (change for production)
$adminUser = [
    'username' => 'admin',
    'email' => 'admin@mpemba.local',
    'password' => 'Admin@123',
    'name' => 'Site Admin'
];

$loginNormalized = strtolower($login);
$isValidLogin = $loginNormalized === strtolower($adminUser['email']) || $loginNormalized === strtolower($adminUser['username']);

$isValidPassword = hash_equals($adminUser['password'], $password) || strcasecmp($adminUser['password'], $password) === 0;

if ($isValidLogin && $isValidPassword) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = ['email'=>$adminUser['email'],'name'=>$adminUser['name']];
    echo '<script>window.location.href="/admin/index";</script>';
    return;
}

// invalid
$_SESSION['auth_error'] = 'Invalid credentials';
echo '<script>window.location.href="/admin/login";</script>';
return;
