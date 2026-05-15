<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../utils/Utility.php';

use Mpemba\Utils\Utility;

if (session_status() === PHP_SESSION_NONE) session_start();

// Must be logged in
if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    $_SESSION['checkout_error'] = 'You must be logged in to checkout.';
    header('Location: /login?next=%2Fpayment-methods');
    exit;
}

$userId = (int) $_SESSION['user']['id'];
$cartItems = Utility::getCartItems($userId);

if (empty($cartItems)) {
    $_SESSION['checkout_error'] = 'Your cart is empty.';
    header('Location: /cart');
    exit;
}

// Prepare cart data for API
$apiCart = array_map(function($item) {
    return [
        'id' => $item['product_id'],
        'price' => $item['price'],
        'qty' => $item['quantity'],
        'name' => $item['name'],
        'image' => $item['image']
    ];
}, $cartItems);

// Call the checkout API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/checkout.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'cart' => $apiCart,
    'payment_method' => $_POST['payment_method'] ?? 'card'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Cookie: ' . session_name() . '=' . session_id()
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

if ($result && $result['success']) {
    $_SESSION['checkout_success'] = 'Order placed successfully! Order number: ' . $result['order_number'];
    header('Location: /order-status?order=' . $result['order_number']);
    exit;
} else {
    $_SESSION['checkout_error'] = $result['message'] ?? 'Failed to process order.';
    header('Location: /cart');
    exit;
}
