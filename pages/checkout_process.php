<?php
require_once __DIR__ . '/../config/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Must be logged in
if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    $_SESSION['checkout_error'] = 'You must be logged in to checkout.';
    header('Location: /login?next=%2Fpayment-methods');
    exit;
}

$cartItems = $_SESSION['cart'] ?? [];
if (empty($cartItems) || !is_array($cartItems)) {
    $_SESSION['checkout_error'] = 'Your cart is empty.';
    header('Location: /cart');
    exit;
}

// Calculate totals
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

// Persist orders to data files (legacy JSON storage)
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

$newOrderId = count($orders) > 0 ? max(array_column($orders, 'id')) + 1 : 1;
$orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad((string) $newOrderId, 3, '0', STR_PAD_LEFT);

$userId = (int) $_SESSION['user']['id'];
$customerName = trim((string) (($_SESSION['user']['first_name'] ?? '') . ' ' . ($_SESSION['user']['last_name'] ?? '')));
if ($customerName === '') $customerName = trim((string) ($_SESSION['user']['username'] ?? $_SESSION['user']['email'] ?? 'Customer'));
$customerEmail = trim((string) ($_SESSION['user']['email'] ?? ''));

// Accept payment details from POST (payment-methods form) or session
$postedPaymentMethod = trim((string) ($_POST['payment_method'] ?? ''));
$postedMobileAccount = trim((string) ($_POST['mobile_account'] ?? ''));

$paymentMethod = $postedPaymentMethod ?: ($_SESSION['payment']['method'] ?? 'unknown');
$paymentAccount = $postedMobileAccount ?: ($_SESSION['payment']['account'] ?? '');

$newOrder = [
    'id' => $newOrderId,
    'order_number' => $orderNumber,
    'user_id' => $userId,
    'user_name' => $customerName,
    'user_email' => $customerEmail,
    'status' => 'processing',
    'payment_status' => 'paid',
    'payment_method' => $paymentMethod,
    'payment_account' => $paymentAccount,
    'subtotal' => round($subtotal, 2),
    'tax' => $tax,
    'shipping_cost' => $shipping,
    'total' => $total,
    'created_at' => date('Y-m-d H:i:s')
];

$orders[] = $newOrder;

$nextItemId = count($orderItems) > 0 ? max(array_column($orderItems, 'id')) + 1 : 1;
foreach ($cartItems as $item) {
    $price = (float) ($item['price'] ?? 0);
    $qty   = max(1, (int) ($item['qty'] ?? 1));
    $orderItems[] = [
        'id' => $nextItemId++,
        'order_id' => $newOrderId,
        'product_id' => (int) ($item['id'] ?? 0),
        'name' => trim((string) ($item['name'] ?? '')),
        'image' => (string) ($item['image'] ?? ''),
        'quantity' => $qty,
        'unit_price' => $price,
        'subtotal' => round($price * $qty, 2),
    ];
}

$saved = file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) !== false;
$savedItems = file_put_contents($orderItemsFile, json_encode($orderItems, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) !== false;

if (!$saved || !$savedItems) {
    $_SESSION['checkout_error'] = 'Failed to save order. Please try again.';
    header('Location: /cart');
    exit;
}

// clear cart
unset($_SESSION['cart']);

$_SESSION['checkout_success'] = 'Order placed successfully. Order #: ' . $orderNumber;
header('Location: /order-status?order=' . urlencode($orderNumber));
exit;
