<?php
require_once __DIR__ . '/_customer_permissions.php';
customerRequireLogin();

require_once __DIR__ . '/../config/bootstrap.php';
use Mpemba\Utils\Utility;
use Mpemba\Utils\ActivityLogger;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/cart.php');
    exit;
}

$productId = (int) ($_POST['product_id'] ?? 0);
$action = $_POST['action'] ?? '';
$qty = max(0, (int) ($_POST['qty'] ?? 1));

if ($productId <= 0) {
    header('Location: /cart');
    exit;
}

$userId = $_SESSION['user']['id'];

if ($action === 'increase') {
    // Get current quantity and increase
    $cartItems = Utility::getCartItems($userId);
    $currentQty = 0;
    foreach ($cartItems as $item) {
        if ($item['product_id'] == $productId) {
            $currentQty = $item['quantity'];
            break;
        }
    }
    $newQty = $currentQty + 1;
    Utility::updateCartItem($userId, $productId, $newQty);
    ActivityLogger::logUpdateCartItem($userId, $productId, $currentQty, $newQty);
} elseif ($action === 'decrease') {
    // Get current quantity and decrease
    $cartItems = Utility::getCartItems($userId);
    $currentQty = 0;
    foreach ($cartItems as $item) {
        if ($item['product_id'] == $productId) {
            $currentQty = $item['quantity'];
            break;
        }
    }
    $newQty = max(0, $currentQty - 1);
    if ($newQty <= 0) {
        Utility::removeFromCart($userId, $productId);
        ActivityLogger::logRemoveFromCart($userId, $productId);
    } else {
        Utility::updateCartItem($userId, $productId, $newQty);
        ActivityLogger::logUpdateCartItem($userId, $productId, $currentQty, $newQty);
    }
} elseif ($qty <= 0) {
    // remove
    Utility::removeFromCart($userId, $productId);
    ActivityLogger::logRemoveFromCart($userId, $productId);
} else {
    Utility::updateCartItem($userId, $productId, $qty);
    ActivityLogger::logUpdateCartItem($userId, $productId, $qty, $qty);
}

header('Location: /cart');
exit;
