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

$input = json_decode((string) file_get_contents('php://input'), true) ?: [];
$action = (string) ($input['action'] ?? ($_GET['action'] ?? ''));

$file = __DIR__ . '/../data/products.json';
$products = [];
if (file_exists($file)) {
    $d = json_decode((string) file_get_contents($file), true);
    if (is_array($d)) {
        $products = $d;
    }
}

$validStatuses   = ['active', 'inactive'];
$validCategories = [
    'atelier-electronics',
    'heritage-fashion',
    'natural-beauty',
    'lifestyle-essentials',
    'sanctuary-home',
];

if ($action === 'delete') {
    $id = (int) ($input['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }
    $products = array_values(array_filter($products, static fn($p) => (int) ($p['id'] ?? 0) !== $id));
    file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo json_encode(['status' => 'success']);
    exit;
}

if ($action === 'update') {
    $id = (int) ($input['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }
    $found = false;
    foreach ($products as &$p) {
        if ((int) ($p['id'] ?? 0) !== $id) {
            continue;
        }
        if (isset($input['name'])) {
            $name = trim((string) $input['name']);
            if ($name !== '') {
                $p['name'] = $name;
            }
        }
        if (isset($input['price'])) {
            $price = (float) $input['price'];
            if ($price >= 0) {
                $p['price'] = $price;
            }
        }
        if (isset($input['stock_quantity'])) {
            $stock = (int) $input['stock_quantity'];
            if ($stock >= 0) {
                $p['stock_quantity'] = $stock;
            }
        }
        if (isset($input['status']) && in_array($input['status'], $validStatuses, true)) {
            $p['status'] = $input['status'];
        }
        if (isset($input['category']) && in_array($input['category'], $validCategories, true)) {
            $p['category'] = $input['category'];
        }
        $found = true;
        break;
    }
    unset($p);
    if ($found) {
        file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
    exit;
}

if ($action === 'list') {
    echo json_encode(['status' => 'success', 'products' => $products]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Unknown action']);
