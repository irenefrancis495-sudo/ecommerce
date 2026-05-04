<?php
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Utils\Database;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$commentsFile = __DIR__ . '/../data/customer_comments.json';
$inputBody = file_get_contents('php://input');
$data = json_decode($inputBody, true) ?: [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($data['name'] ?? ''));
    $email = trim((string) ($data['email'] ?? ''));
    $message = trim((string) ($data['message'] ?? ''));

    if ($name === '' || $email === '' || $message === '') {
        Database::respondError('Please enter your name, email, and message.', 400);
        exit;
    }

    if (!Database::isValidEmail($email)) {
        Database::respondError('Please enter a valid email address.', 400);
        exit;
    }

    $comments = [];
    if (file_exists($commentsFile)) {
        $comments = json_decode(file_get_contents($commentsFile), true) ?: [];
    }

    $newId = 1;
    foreach ($comments as $comment) {
        if (isset($comment['id']) && (int) $comment['id'] >= $newId) {
            $newId = (int) $comment['id'] + 1;
        }
    }

    $newComment = [
        'id' => $newId,
        'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
        'email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
        'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
        'status' => 'new',
        'created_at' => date('Y-m-d H:i:s')
    ];

    $comments[] = $newComment;

    if (file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT)) === false) {
        Database::respondError('Unable to save your feedback at this time.', 500);
        exit;
    }

    Database::respondJson('success', ['comment' => $newComment], 'Thank you for your feedback.');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        Database::respondError('Unauthorized access. Admin login required.', 401);
        exit;
    }

    $comments = [];
    if (file_exists($commentsFile)) {
        $comments = json_decode(file_get_contents($commentsFile), true) ?: [];
    }

    usort($comments, function ($a, $b) {
        return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
    });

    Database::respondJson('success', ['comments' => $comments], 'Customer feedback loaded.');
    exit;
}

Database::respondError('Unsupported request method.', 405);
