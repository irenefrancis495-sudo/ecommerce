<?php
require_once __DIR__ . '/_customer_permissions.php';
customerRequireLogin();

require_once __DIR__ . '/../config/bootstrap.php';
use Mpemba\Utils\Utility;
use Mpemba\Utils\ActivityLogger;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /cart');
    exit;
}

$productId = (int) ($_POST['product_id'] ?? 0);

if ($productId > 0) {
    $userId = $_SESSION['user']['id'];
    Utility::removeFromCart($userId, $productId);
    
    // Log the activity
    ActivityLogger::logRemoveFromCart($userId, $productId);
}

header('Location: /cart');
exit;
