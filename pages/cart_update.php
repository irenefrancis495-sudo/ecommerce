<?php
require_once __DIR__ . '/../config/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/cart.php');
    exit;
}

$productId = (int) ($_POST['product_id'] ?? 0);
$qty = max(0, (int) ($_POST['qty'] ?? 1));

if ($productId <= 0) {
    header('Location: /cart');
    exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($qty <= 0) {
    // remove
    unset($_SESSION['cart'][$productId]);
} else {
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['qty'] = $qty;
    }
}

header('Location: /cart');
exit;
