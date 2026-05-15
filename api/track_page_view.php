<?php
/**
 * POST /api/track_page_view.php
 * Tracks page views
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

$page = trim((string) ($data['page'] ?? ''));
$referrer = trim((string) ($data['referrer'] ?? $_SERVER['HTTP_REFERER'] ?? null));

if (empty($page)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Page required']);
    exit;
}

$userId = null;
if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
    $userId = (int) $_SESSION['user']['id'];
}

$success = ActivityLogger::logPageView($userId, $page, $referrer);

echo json_encode(['success' => $success, 'message' => $success ? 'Page view tracked' : 'Failed to track page view']);
