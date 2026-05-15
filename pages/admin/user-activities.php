<?php 
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Utils\Utility;
use Mpemba\Utils\ActivityLogger;

// Check admin access
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /admin/login');
    exit;
}

$adminId = (int) $_SESSION['user']['id'];
$userId = (int) ($_GET['user_id'] ?? 0);

// If user_id provided, show that user's activities
if ($userId > 0) {
    $activities = ActivityLogger::getUserActivities($userId, 100);
    $stats = ActivityLogger::getUserActivityStats($userId, '30');
    
    // Get user info
    $userQuery = "SELECT id, username, email, created_at FROM users WHERE id = ?";
    $conn = $GLOBALS['db'];
    $userResult = $conn->executeQuery($userQuery, [$userId]);
    $user = $userResult->fetchAssociative();
} else {
    $activities = [];
    $stats = [];
    $user = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Activities - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .activity-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .activity-login { background-color: #dbeafe; color: #1e40af; }
        .activity-logout { background-color: #fee2e2; color: #991b1b; }
        .activity-add_to_cart { background-color: #dbeafe; color: #1e40af; }
        .activity-remove_from_cart { background-color: #fed7aa; color: #7c2d12; }
        .activity-update_cart { background-color: #fcd34d; color: #78350f; }
        .activity-checkout { background-color: #d1fae5; color: #065f46; }
        .activity-view_product { background-color: #e9d5ff; color: #581c87; }
        .activity-page_view { background-color: #e0e7ff; color: #312e81; }
        .activity-search { background-color: #fce7f3; color: #831843; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">📊 User Activities</h1>
            <p class="text-gray-600 mt-2">Track and monitor user behavior and interactions</p>
        </div>

        <?php if ($user): ?>
        <div class="bg-white rounded-lg shadow mb-8 p-6">
            <div class="mb-4">
                <a href="/admin/user-activities" class="text-blue-600 hover:text-blue-800">← Back to User List</a>
            </div>
            
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-600">Username</div>
                    <div class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($user['username']) ?></div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-600">Email</div>
                    <div class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($user['email']) ?></div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-600">Member Since</div>
                    <div class="text-lg font-semibold text-gray-900"><?= (new DateTime($user['created_at']))->format('M d, Y') ?></div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-600">Total Activities (30d)</div>
                    <div class="text-lg font-semibold text-gray-900"><?= count($activities) ?></div>
                </div>
            </div>

            <?php if (!empty($stats)): ?>
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Activity Summary (Last 30 Days)</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <?php foreach ($stats as $stat): ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600 capitalize"><?= str_replace('_', ' ', htmlspecialchars($stat['activity'])) ?></div>
                        <div class="text-2xl font-bold text-gray-900"><?= $stat['count'] ?></div>
                        <div class="text-xs text-gray-500">Last: <?= (new DateTime($stat['last_activity']))->format('M d, h:i A') ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activities</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Activity</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Entity</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Data</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">IP Address</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($activities as $activity): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <span class="activity-badge activity-<?= htmlspecialchars($activity['activity']) ?>">
                                    <?= str_replace('_', ' ', htmlspecialchars($activity['activity'])) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <?php if ($activity['entity_type']): ?>
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                        <?= htmlspecialchars($activity['entity_type']) ?> #<?= $activity['entity_id'] ?? 'N/A' ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <?php if ($activity['data']): ?>
                                    <code class="bg-gray-100 px-2 py-1 rounded"><?= htmlspecialchars(substr($activity['data'], 0, 50)) ?>...</code>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs"><?= htmlspecialchars($activity['ip_address']) ?></td>
                            <td class="px-4 py-3 text-gray-600 text-xs"><?= (new DateTime($activity['created_at']))->format('M d, h:i A') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (empty($activities)): ?>
            <div class="text-center py-8">
                <p class="text-gray-500">No activities recorded yet</p>
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="bg-white rounded-lg shadow p-8">
            <div class="text-center">
                <p class="text-gray-600 mb-4">📌 Select a user to view their activities</p>
                <form method="GET" class="max-w-md mx-auto flex gap-2">
                    <input type="number" name="user_id" placeholder="Enter user ID" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg" required>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">View Activities</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
