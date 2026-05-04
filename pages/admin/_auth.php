<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin_logged_in'])) {
    echo '<script>window.location.href="/admin/login";</script>';
    return;
}

require_once __DIR__ . '/_permissions.php';
adminEnforcePagePermission();
