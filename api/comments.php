<?php
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Utils\Database;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$commentsFile = __DIR__ . '/../data/customer_comments.json';
$inputBody = file_get_contents('php://input');
$data = json_decode($inputBody, true) ?: [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($data['action']) && $data['action'] === 'reply') {
        if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            Database::respondError('Unauthorized. Admin access only.', 401);
            exit;
        }

        $commentId = (int) ($data['id'] ?? 0);
        $replyText = trim((string) ($data['reply'] ?? ''));

        if ($commentId <= 0 || $replyText === '') {
            Database::respondError('Please provide a valid comment and reply text.', 400);
            exit;
        }

        $comments = [];
        if (file_exists($commentsFile)) {
            $comments = json_decode(file_get_contents($commentsFile), true) ?: [];
        }

        $found = false;
        $updatedComment = null;
        foreach ($comments as &$comment) {
            if (isset($comment['id']) && (int) $comment['id'] === $commentId) {
                $comment['reply'] = htmlspecialchars($replyText, ENT_QUOTES, 'UTF-8');
                $comment['status'] = 'replied';
                $comment['replied_at'] = date('Y-m-d H:i:s');
                $comment['replied_by'] = $_SESSION['admin_user']['name'] ?? 'Admin';
                $updatedComment = $comment;
                $found = true;
                break;
            }
        }
        unset($comment);

        if (!$found || $updatedComment === null) {
            Database::respondError('Comment not found.', 404);
            exit;
        }

        if (file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT)) === false) {
            Database::respondError('Unable to save reply at this time.', 500);
            exit;
        }

        Database::respondJson('success', ['comment' => $updatedComment], 'Reply saved successfully.');
        exit;
    }

    $name = trim((string) ($data['name'] ?? ''));
    $email = trim((string) ($data['email'] ?? ''));
    $message = trim((string) ($data['message'] ?? ''));

    if ($name === '' || $email === '' || $message === '') {
        Database::respondError('Please enter name, email, and message.', 400);
        exit;
    }

    if (!Database::isValidEmail($email)) {
        Database::respondError('Please enter a valid email.', 400);
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
    $comments = [];
    if (file_exists($commentsFile)) {
        $comments = json_decode(file_get_contents($commentsFile), true) ?: [];
    }

    if (!empty($_GET['email'])) {
        $email = trim((string) $_GET['email']);
        if (!Database::isValidEmail($email)) {
            Database::respondError('Please provide a valid email address.', 400);
            exit;
        }

        $filtered = array_filter($comments, function ($comment) use ($email) {
            return isset($comment['email']) && strtolower($comment['email']) === strtolower($email);
        });

        usort($filtered, function ($a, $b) {
            return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
        });

        Database::respondJson('success', ['comments' => array_values($filtered)], 'Feedback found for this email.');
        exit;
    }

    if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        Database::respondError('Unauthorized. Admin access only.', 401);
        exit;
    }

    usort($comments, function ($a, $b) {
        return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
    });

    Database::respondJson('success', ['comments' => $comments], 'Customer feedback loaded.');
    exit;
}

Database::respondError('Unsupported request method.', 405);
