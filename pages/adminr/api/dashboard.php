<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../data/mock_data.php';

$payload = [
    'stats' => get_stats(),
    'top_selling' => get_top_selling(),
];

echo json_encode($payload);

?>
