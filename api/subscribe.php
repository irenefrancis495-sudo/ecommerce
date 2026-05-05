<?php
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$email = trim(strtolower($input['email'] ?? $_POST['email'] ?? ''));

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

$file        = __DIR__ . '/../data/subscribers.json';
$subscribers = json_decode(file_get_contents($file), true) ?: [];

// Check for duplicate
foreach ($subscribers as $s) {
    if (strtolower($s['email']) === $email) {
        echo json_encode(['success' => false, 'message' => 'This email is already subscribed. Thank you!']);
        exit;
    }
}

$subscribers[] = [
    'id'         => count($subscribers) + 1,
    'email'      => $email,
    'subscribed_at' => date('Y-m-d H:i:s'),
    'source'     => htmlspecialchars($input['source'] ?? $_POST['source'] ?? 'website', ENT_QUOTES, 'UTF-8'),
];

file_put_contents($file, json_encode($subscribers, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'You\'re subscribed! Welcome to the Mpemba community.']);
