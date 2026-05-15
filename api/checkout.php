<?php
/**
 * POST /api/checkout.php
 * Places an order for the currently logged-in customer.
 * Saves to database.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../utils/Utility.php';

use Mpemba\Utils\Utility;
use Mpemba\Utils\ActivityLogger;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Must be logged in as a customer
if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'You must be logged in to checkout.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$input = json_decode((string) file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request body.']);
    exit;
}

$cartItems     = $input['cart'] ?? [];
$paymentMethod = trim((string) ($input['payment_method'] ?? 'unknown'));

if (empty($cartItems) || !is_array($cartItems)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
    exit;
}

// ── Calculate totals ──────────────────────────────────────────────────────────
$subtotal = 0.0;
$itemCount = 0;
foreach ($cartItems as $item) {
    $price = (float) ($item['price'] ?? 0);
    $qty   = max(1, (int) ($item['qty'] ?? 1));
    $subtotal += $price * $qty;
    $itemCount += $qty;
}
$shipping = $subtotal > 0 ? 24.00 : 0.00;
$tax      = round($subtotal * 0.07, 2);
$total    = round($subtotal + $shipping + $tax, 2);

// ── Generate order number ─────────────────────────────────────────────────────
$userId = (int) $_SESSION['user']['id'];
$orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad((string) $userId, 3, '0', STR_PAD_LEFT) . '-' . time();

// ── Create order in DB ────────────────────────────────────────────────────────
$orderData = [
    'order_number' => $orderNumber,
    'user_id'      => $userId,
    'total'        => $total,
    'tax'          => $tax,
    'shipping'     => $shipping,
    'status'       => 'processing',
];

$orderId = Utility::createOrder($orderData);
if (!$orderId) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to create order. Please try again.']);
    exit;
}

// ── Create order items in DB ──────────────────────────────────────────────────
foreach ($cartItems as $item) {
    $price = (float) ($item['price'] ?? 0);
    $qty   = max(1, (int) ($item['qty'] ?? 1));
    $itemData = [
        'product_id' => (int) ($item['id'] ?? 0),
        'quantity'   => $qty,
        'price'      => $price,
    ];

    if (!Utility::createOrderItem($orderId, $itemData)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to save order items. Please try again.']);
        exit;
    }
}

// ── Clear cart ────────────────────────────────────────────────────────────────
Utility::clearCart($userId);

// ── Log checkout activity ─────────────────────────────────────────────────────
ActivityLogger::logCheckout($userId, $orderId, $total);

echo json_encode([
    'success'      => true,
    'message'      => 'Order placed successfully.',
    'order_number' => $orderNumber,
    'order_id'     => $orderId,
    'total'        => $total,
]);
