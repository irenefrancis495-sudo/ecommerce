<?php
session_start();
// Simple admin authentication (replace with DB in production)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php'); exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Hard-coded admin user (change for production)
$adminUser = [
    'email' => 'admin@mpemba.local',
    // password: Admin@123 (bcrypt)
    'password_hash' => password_hash('Admin@123', PASSWORD_DEFAULT),
    'name' => 'Site Admin'
];

if (strtolower($email) === strtolower($adminUser['email']) && password_verify($password, $adminUser['password_hash'])) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = ['email'=>$adminUser['email'],'name'=>$adminUser['name']];
    header('Location: index.php'); exit;
}

// invalid
$_SESSION['auth_error'] = 'Invalid credentials';
header('Location: login.php'); exit;
