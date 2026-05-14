<?php
require_once __DIR__ . '/../config/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /cart');
    exit;
}

$productId = (int) ($_POST['product_id'] ?? 0);

if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
    unset($_SESSION['cart'][$productId]);
}

header('Location: /cart');
exit;
