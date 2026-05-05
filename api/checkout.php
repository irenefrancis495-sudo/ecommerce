<?php
/**
 * POST /api/checkout.php
 * Places an order for the currently logged-in customer.
 * Saves to data/orders.json and data/order_items.json.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// ── Load existing data ────────────────────────────────────────────────────────
$ordersFile     = __DIR__ . '/../data/orders.json';
$orderItemsFile = __DIR__ . '/../data/order_items.json';

$orders = [];
if (file_exists($ordersFile)) {
    $d = json_decode((string) file_get_contents($ordersFile), true);
    if (is_array($d)) $orders = $d;
}

$orderItems = [];
if (file_exists($orderItemsFile)) {
    $d = json_decode((string) file_get_contents($orderItemsFile), true);
    if (is_array($d)) $orderItems = $d;
}

// ── Generate IDs and order number ────────────────────────────────────────────
$newOrderId = count($orders) > 0
    ? max(array_column($orders, 'id')) + 1
    : 1;

$orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad((string) $newOrderId, 3, '0', STR_PAD_LEFT);

// ── Build order record ────────────────────────────────────────────────────────
$userId = (int) $_SESSION['user']['id'];
$customerName = trim((string) (($_SESSION['user']['first_name'] ?? '') . ' ' . ($_SESSION['user']['last_name'] ?? '')));
if ($customerName === '') {
    $customerName = trim((string) ($_SESSION['user']['username'] ?? $_SESSION['user']['email'] ?? 'Customer'));
}
$customerEmail = trim((string) ($_SESSION['user']['email'] ?? ''));

$newOrder = [
    'id'             => $newOrderId,
    'order_number'   => $orderNumber,
    'user_id'        => $userId,
    'user_name'      => $customerName,
    'user_email'     => $customerEmail,
    'status'         => 'processing',
    'payment_status' => 'paid',
    'payment_method' => $paymentMethod,
    'subtotal'       => round($subtotal, 2),
    'tax'            => $tax,
    'shipping_cost'  => $shipping,
    'total'          => $total,
    'created_at'     => date('Y-m-d H:i:s'),
];

$orders[] = $newOrder;

// ── Build order item records ──────────────────────────────────────────────────
$nextItemId = count($orderItems) > 0
    ? max(array_column($orderItems, 'id')) + 1
    : 1;

foreach ($cartItems as $item) {
    $price = (float) ($item['price'] ?? 0);
    $qty   = max(1, (int) ($item['qty'] ?? 1));
    $orderItems[] = [
        'id'         => $nextItemId++,
        'order_id'   => $newOrderId,
        'product_id' => (int) ($item['id'] ?? 0),
        'name'       => trim((string) ($item['name'] ?? '')),
        'image'      => (string) ($item['image'] ?? ''),
        'quantity'   => $qty,
        'unit_price' => $price,
        'subtotal'   => round($price * $qty, 2),
    ];
}

// ── Persist data ──────────────────────────────────────────────────────────────
$saved = file_put_contents(
        $ordersFile,
        json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    ) !== false;

$savedItems = file_put_contents(
        $orderItemsFile,
        json_encode($orderItems, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    ) !== false;

if (!$saved || !$savedItems) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save order. Please try again.']);
    exit;
}

echo json_encode([
    'success'      => true,
    'message'      => 'Order placed successfully.',
    'order_id'     => $newOrderId,
    'order_number' => $orderNumber,
    'total'        => $total,
]);
