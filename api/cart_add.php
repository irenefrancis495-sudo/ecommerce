<?php
/**
 * POST /api/cart_add.php
 * Adds a product to the logged-in user's cart and returns a JSON response.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../utils/Utility.php';

use Mpemba\Entity\Product;
use Mpemba\Utils\Utility;
use Mpemba\Utils\ActivityLogger;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'You must be logged in to add items to the cart.']);
    exit;
}

$input = json_decode((string) file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST;
}

$productId = max(0, (int) ($input['product_id'] ?? $input['id'] ?? 0));
$quantity = max(1, (int) ($input['quantity'] ?? $input['qty'] ?? 1));

if ($productId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product selected.']);
    exit;
}

$product = Product::getProductById($productId);
if (empty($product) || !is_array($product)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Product not found.']);
    exit;
}

$userId = (int) $_SESSION['user']['id'];
try {
    $added = Utility::addToCart($userId, $productId, $quantity);
    if (!$added) {
        throw new RuntimeException('Unable to update cart.');
    }

    ActivityLogger::logAddToCart($userId, $productId, $quantity);
    echo json_encode(['success' => true, 'message' => 'Product added to cart.', 'product_id' => $productId, 'quantity' => $quantity]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to add item to cart.', 'error' => $e->getMessage()]);
}
