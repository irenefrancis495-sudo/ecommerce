<?php
require_once __DIR__ . '/../../config/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdminSession = !empty($_SESSION['admin_logged_in']) || strtolower($_SESSION['user']['role'] ?? '') === 'admin';
if (!$isAdminSession) {
    echo '<script>window.location.href="/admin/login";</script>';
    return;
}

require_once __DIR__ . '/_permissions.php';
adminEnforcePagePermission();
