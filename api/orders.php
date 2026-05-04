<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Not authorized']);
    exit;
}

header('Content-Type: application/json');

$input  = json_decode((string) file_get_contents('php://input'), true) ?: [];
$action = (string) ($input['action'] ?? ($_GET['action'] ?? ''));

$file   = __DIR__ . '/../data/orders.json';
$orders = [];
if (file_exists($file)) {
    $d = json_decode((string) file_get_contents($file), true);
    if (is_array($d)) {
        $orders = $d;
    }
}

$validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'];

if ($action === 'update_status') {
    $id     = (int) ($input['id'] ?? 0);
    $status = strtolower(trim((string) ($input['status'] ?? '')));

    if ($id <= 0 || !in_array($status, $validStatuses, true)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }

    $found = false;
    foreach ($orders as &$o) {
        if ((int) ($o['id'] ?? 0) === $id) {
            $o['status'] = $status;
            $found        = true;
            break;
        }
    }
    unset($o);

    if ($found) {
        file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order not found']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Unknown action']);
