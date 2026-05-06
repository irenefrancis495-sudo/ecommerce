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

function commentsRequestValue(array $data, string $key, $default = '') {
    return $data[$key] ?? $_POST[$key] ?? $default;
}

function commentsHandleImageUpload(?array $file): ?string {
    if (!$file || (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE)) {
        return null;
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        Database::respondError('Image upload failed. Please try again.', 400);
        exit;
    }

    $maxSize = 5 * 1024 * 1024;
    if (($file['size'] ?? 0) > $maxSize) {
        Database::respondError('Image too large. Maximum 5 MB.', 400);
        exit;
    }

    $imgInfo = @getimagesize($file['tmp_name']);
    if ($imgInfo === false) {
        Database::respondError('Invalid file. Only image files are allowed.', 400);
        exit;
    }

    $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
    if (!in_array($imgInfo[2], $allowedTypes, true)) {
        Database::respondError('Invalid image type. Only JPEG, PNG, WebP, or GIF are allowed.', 400);
        exit;
    }

    $extMap = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG  => 'png',
        IMAGETYPE_GIF  => 'gif',
        IMAGETYPE_WEBP => 'webp',
    ];

    $uploadDir = __DIR__ . '/../uploads/feedback/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $extMap[$imgInfo[2]];
    $destPath = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        Database::respondError('Failed to save image. Please try again.', 500);
        exit;
    }

    return '/uploads/feedback/' . $filename;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (commentsRequestValue($data, 'action', '') === 'reply') {
        if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            Database::respondError('Unauthorized. Admin access only.', 401);
            exit;
        }

        $commentId  = (int) commentsRequestValue($data, 'id', 0);
        $replyText  = trim((string) commentsRequestValue($data, 'reply', ''));
        $replyImage = commentsHandleImageUpload($_FILES['image'] ?? null);

        if ($commentId <= 0 || ($replyText === '' && $replyImage === null)) {
            Database::respondError('Please provide a valid comment and reply content.', 400);
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
                $sanitized               = htmlspecialchars($replyText, ENT_QUOTES, 'UTF-8');
                $comment['reply']        = $sanitized;
                $comment['status']       = 'replied';
                $comment['replied_at']   = date('Y-m-d H:i:s');
                $comment['replied_by']   = $_SESSION['admin_user']['name'] ?? 'Admin';
                $comment['reply_image']  = $replyImage;

                // Append to conversation thread
                if (!isset($comment['thread'])) {
                    $comment['thread'] = [];
                }
                $comment['thread'][] = [
                    'from'    => 'admin',
                    'message' => $sanitized,
                    'image'   => $replyImage,
                    'at'      => $comment['replied_at'],
                    'by'      => $comment['replied_by'],
                ];

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

    // ── Customer reply-back ───────────────────────────────────────────────
    if (commentsRequestValue($data, 'action', '') === 'customer_reply') {
        if (empty($_SESSION['user'])) {
            Database::respondError('Please log in to reply.', 401);
            exit;
        }

        $commentId  = (int) commentsRequestValue($data, 'id', 0);
        $replyText  = trim((string) commentsRequestValue($data, 'reply', ''));
        $replyImage = commentsHandleImageUpload($_FILES['image'] ?? null);

        if ($commentId <= 0 || ($replyText === '' && $replyImage === null)) {
            Database::respondError('Please provide a reply message or image.', 400);
            exit;
        }

        $comments      = file_exists($commentsFile) ? (json_decode(file_get_contents($commentsFile), true) ?: []) : [];
        $customerEmail = strtolower(trim((string) ($_SESSION['user']['email'] ?? '')));
        $found         = false;
        $updatedComment = null;

        foreach ($comments as &$comment) {
            if (isset($comment['id']) && (int) $comment['id'] === $commentId) {
                // Security: ensure this feedback belongs to the logged-in customer
                if (strtolower(trim((string) ($comment['email'] ?? ''))) !== $customerEmail) {
                    Database::respondError('Forbidden.', 403);
                    exit;
                }

                // Migrate legacy single reply into thread
                if (!isset($comment['thread'])) {
                    $comment['thread'] = [];
                    if (!empty($comment['reply'])) {
                        $comment['thread'][] = [
                            'from'    => 'admin',
                            'message' => $comment['reply'],
                            'image'   => $comment['reply_image'] ?? null,
                            'at'      => $comment['replied_at'] ?? $comment['created_at'] ?? date('Y-m-d H:i:s'),
                            'by'      => $comment['replied_by'] ?? 'Admin',
                        ];
                    }
                }

                $comment['thread'][] = [
                    'from'    => 'customer',
                    'message' => htmlspecialchars($replyText, ENT_QUOTES, 'UTF-8'),
                    'image'   => $replyImage,
                    'at'      => date('Y-m-d H:i:s'),
                ];
                $comment['status'] = 'customer_replied';
                $updatedComment    = $comment;
                $found             = true;
                break;
            }
        }
        unset($comment);

        if (!$found) {
            Database::respondError('Comment not found.', 404);
            exit;
        }

        if (file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT)) === false) {
            Database::respondError('Unable to save reply.', 500);
            exit;
        }

        Database::respondJson('success', ['comment' => $updatedComment], 'Reply sent successfully.');
        exit;
    }

    // Support both JSON body and multipart/form-data (file upload)
    $name    = trim((string) commentsRequestValue($data, 'name', ''));
    $email   = trim((string) commentsRequestValue($data, 'email', ''));
    $message = trim((string) commentsRequestValue($data, 'message', ''));

    if ($name === '' || $email === '' || $message === '') {
        Database::respondError('Please enter name, email, and message.', 400);
        exit;
    }

    if (!Database::isValidEmail($email)) {
        Database::respondError('Please enter a valid email.', 400);
        exit;
    }

    // ── Image upload (optional) ───────────────────────────────────────────
    $imagePath = commentsHandleImageUpload($_FILES['image'] ?? null);

    $comments = [];
    if (file_exists($commentsFile)) {
        $comments = json_decode(file_get_contents($commentsFile), true) ?: [];
    }

    $newId = 1;
    foreach ($comments as $comment) {
        $newId = max($newId, (int) ($comment['id'] ?? 0) + 1);
    }

    $newComment = [
        'id'         => $newId,
        'name'       => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
        'email'      => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
        'message'    => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
        'image'      => $imagePath,
        'status'     => 'new',
        'created_at' => date('Y-m-d H:i:s'),
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
