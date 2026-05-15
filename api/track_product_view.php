<?php
/**
 * POST /api/track_product_view.php
 * Tracks product views
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Utils\ActivityLogger;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode((string) file_get_contents('php://input'), true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$productId = (int) ($data['product_id'] ?? 0);
if ($productId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

$userId = null;
if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
    $userId = (int) $_SESSION['user']['id'];
}

$success = ActivityLogger::logProductView($productId, $userId);

echo json_encode(['success' => $success, 'message' => $success ? 'Product view tracked' : 'Failed to track product view']);
