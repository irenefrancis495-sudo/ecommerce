<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/bootstrap.php';
use Mpemba\Entity\Product;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /products');
    exit;
}

$productId = (int) ($_POST['product_id'] ?? 0);
$qty = max(1, (int) ($_POST['qty'] ?? 1));

if ($productId <= 0) {
    header('Location: /products');
    exit;
}

$p = Product::getProductById($productId);
if (!$p) {
    header('Location: /products');
    exit;
}

// initialize cart in session
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$key = (int) $p['id'];
if (!isset($_SESSION['cart'][$key])) {
    $_SESSION['cart'][$key] = [
        'id' => $key,
        'name' => $p['name'],
        'price' => (float) $p['price'],
        'image' => $p['image_url'] ?? '',
        'qty' => $qty
    ];
} else {
    $_SESSION['cart'][$key]['qty'] = max(1, $_SESSION['cart'][$key]['qty'] + $qty);
}

// redirect back where request came from, default to products
$referer = $_SERVER['HTTP_REFERER'] ?? '/products';
header('Location: ' . $referer);
exit;
