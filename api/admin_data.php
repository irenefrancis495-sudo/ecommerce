<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../data/mock_data.php';

$out = [
    'stats' => get_stats(),
    'top' => get_top_selling(),
    'customers' => get_customers(),
    'orders' => get_orders(),
    'revenue' => get_revenue_series(),
];

echo json_encode($out, JSON_PRETTY_PRINT);
