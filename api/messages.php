<?php
require_once __DIR__ . '/../config/bootstrap.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$payload = json_decode((string) file_get_contents('php://input'), true) ?: [];
$action  = (string) ($payload['action'] ?? '');
$file    = __DIR__ . '/../data/contact_messages.json';

// ── Admin reply ──────────────────────────────────────────────────────────────
if ($action === 'reply') {
    if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Admin access only.']);
        exit;
    }

    $messageId = (int) ($payload['id'] ?? 0);
    $replyText = trim((string) ($payload['reply'] ?? ''));

    if ($messageId <= 0 || $replyText === '') {
        http_response_code(422);
        echo json_encode(['status' => 'error', 'message' => 'Please provide a valid message and reply text.']);
        exit;
    }

    $messages       = file_exists($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
    $updatedMessage = null;

    foreach ($messages as &$message) {
        if ((int) ($message['id'] ?? 0) === $messageId) {
            $sanitized                = htmlspecialchars($replyText, ENT_QUOTES, 'UTF-8');
            $message['reply']         = $sanitized;
            $message['status']        = 'replied';
            $message['replied_at']    = date('Y-m-d H:i:s');
            $message['replied_by']    = $_SESSION['admin_user']['name'] ?? 'Admin';

            // Append to conversation thread
            if (!isset($message['thread'])) {
                $message['thread'] = [];
            }
            $message['thread'][] = [
                'from'    => 'admin',
                'message' => $sanitized,
                'at'      => $message['replied_at'],
                'by'      => $message['replied_by'],
            ];

            $updatedMessage = $message;
            break;
        }
    }
    unset($message);

    if ($updatedMessage === null) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Message not found.']);
        exit;
    }

    if (file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT)) === false) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Unable to save reply right now.']);
        exit;
    }

    echo json_encode(['status' => 'success', 'message' => 'Reply saved successfully.', 'data' => $updatedMessage]);
    exit;
}

// ── Customer reply-back ───────────────────────────────────────────────────────
if ($action === 'customer_reply') {
    if (empty($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Please log in to reply.']);
        exit;
    }

    $messageId   = (int) ($payload['id'] ?? 0);
    $replyText   = trim((string) ($payload['reply'] ?? ''));

    if ($messageId <= 0 || $replyText === '') {
        http_response_code(422);
        echo json_encode(['status' => 'error', 'message' => 'Please provide a reply message.']);
        exit;
    }

    $messages      = file_exists($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
    $customerEmail = strtolower(trim((string) ($_SESSION['user']['email'] ?? '')));
    $updatedMessage = null;

    foreach ($messages as &$message) {
        if ((int) ($message['id'] ?? 0) === $messageId) {
            // Security: ensure this message belongs to the logged-in customer
            if (strtolower(trim((string) ($message['email'] ?? ''))) !== $customerEmail) {
                http_response_code(403);
                echo json_encode(['status' => 'error', 'message' => 'Forbidden.']);
                exit;
            }

            // Migrate legacy single reply into thread if thread not yet created
            if (!isset($message['thread'])) {
                $message['thread'] = [];
                if (!empty($message['reply'])) {
                    $message['thread'][] = [
                        'from'    => 'admin',
                        'message' => $message['reply'],
                        'at'      => $message['replied_at'] ?? $message['created_at'] ?? date('Y-m-d H:i:s'),
                        'by'      => $message['replied_by'] ?? 'Admin',
                    ];
                }
            }

            $message['thread'][] = [
                'from'    => 'customer',
                'message' => htmlspecialchars($replyText, ENT_QUOTES, 'UTF-8'),
                'at'      => date('Y-m-d H:i:s'),
            ];
            $message['status']   = 'customer_replied';
            $updatedMessage      = $message;
            break;
        }
    }
    unset($message);

    if ($updatedMessage === null) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Message not found.']);
        exit;
    }

    if (file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT)) === false) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Unable to save reply.']);
        exit;
    }

    echo json_encode(['status' => 'success', 'message' => 'Reply sent successfully.', 'data' => $updatedMessage]);
    exit;
}

http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Unsupported action']);