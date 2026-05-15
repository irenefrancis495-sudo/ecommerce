<?php
/**
 * GET /api/cart_count.php
 * Returns the total number of items in the user's cart.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../utils/Utility.php';

use Mpemba\Utils\Utility;

header('Content-Type: application/json');

if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in', 'count' => 0]);
    exit;
}

$userId = (int) $_SESSION['user']['id'];
$cartItems = Utility::getCartItems($userId);
$count = array_sum(array_column($cartItems, 'quantity'));

echo json_encode(['success' => true, 'count' => $count]);