<?php
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Entity\Product;

header('Content-Type: application/json');

$itemsPerPage = max(1, (int) ($_GET['itemsPerPage'] ?? 12));
$page = max(1, (int) ($_GET['page'] ?? 1));
// Pass through category and search via $_GET so Product::getAllProducts reads them
// Temporarily inject page and itemsPerPage into $_GET for Product::getAllProducts
$_GET['page'] = $page;
$origPage = $_GET['page'] ?? null;

$productsData = Product::getAllProducts($itemsPerPage);

echo json_encode([
    'success' => true,
    'products' => $productsData['products'] ?? [],
    'total' => $productsData['total'] ?? 0,
    'pages' => $productsData['pages'] ?? 1,
    'page' => $page,
    'itemsPerPage' => $itemsPerPage
]);
