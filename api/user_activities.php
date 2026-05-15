<?php
/**
 * GET /api/user_activities.php
 * Returns user's activity history
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Utils\ActivityLogger;

header('Content-Type: application/json');

// Must be logged in
if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$userId = (int) $_SESSION['user']['id'];
$limit = (int) ($_GET['limit'] ?? 50);
$offset = (int) ($_GET['offset'] ?? 0);

$limit = min($limit, 100); // Cap at 100 per request

$activities = ActivityLogger::getUserActivities($userId, $limit, $offset);
$stats = ActivityLogger::getUserActivityStats($userId, $_GET['period'] ?? '7');

echo json_encode([
    'success' => true,
    'activities' => $activities,
    'stats' => $stats,
    'limit' => $limit,
    'offset' => $offset
]);
