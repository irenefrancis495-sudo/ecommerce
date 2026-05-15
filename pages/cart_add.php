<?php
require_once __DIR__ . '/_customer_permissions.php';
customerRequireLogin();

require_once __DIR__ . '/../config/bootstrap.php';
use Mpemba\Entity\Product;
use Mpemba\Utils\Utility;
use Mpemba\Utils\ActivityLogger;

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

$userId = $_SESSION['user']['id'];
Utility::addToCart($userId, $productId, $qty);

// Log the activity
ActivityLogger::logAddToCart($userId, $productId, $qty);

// redirect back where request came from, default to products
$referer = $_SERVER['HTTP_REFERER'] ?? '/products';
header('Location: ' . $referer);
exit;
