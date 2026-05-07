<?php
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Utils\Database;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$action = $_GET['action'] ?? '';

if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    Database::respondError('Unauthorized access. Admin login required.', 401);
    exit;
}

$inputBody = file_get_contents('php://input');
$data = json_decode($inputBody, true) ?: [];

switch ($action) {
    case 'add':
        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $firstName = trim($data['first_name'] ?? '');
        $lastName = trim($data['last_name'] ?? '');
        $password = $data['password'] ?? '';
        $role = trim($data['role'] ?? 'user');

        require_once __DIR__ . '/../pages/admin/_permissions.php';
        $availableRoles = array_keys(adminLoadRolePermissions());

        if (!$username || !$email || !$password) {
            Database::respondError('Username, email, and password are required.', 400);
            exit;
        }

        if (!Database::isValidEmail($email)) {
            Database::respondError('Please provide a valid email address.', 400);
            exit;
        }

        if (!Database::isValidPassword($password)) {
            Database::respondError('Password must be at least 6 characters.', 400);
            exit;
        }

        $users = Database::getUsers();
        foreach ($users as $user) {
            if (strtolower($user['username']) === strtolower($username)) {
                Database::respondError('Username already exists.', 409);
                exit;
            }
            if (strtolower($user['email']) === strtolower($email)) {
                Database::respondError('Email already exists.', 409);
                exit;
            }
        }

        $newId = 1;
        foreach ($users as $user) {
            $newId = max($newId, (int) $user['id'] + 1);
        }

        $allowedRoles = array_merge(['admin'], $availableRoles);
        $newUser = [
            'id' => $newId,
            'name' => trim($firstName . ' ' . $lastName) ?: $username,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => in_array(strtolower($role), $allowedRoles, true) ? strtolower($role) : 'user',
            'joined' => date('Y-m-d'),
            'orders' => 0,
            'spend' => 0,
            'status' => 'active',
            'initials' => strtoupper(substr($username, 0, 2))
        ];

        $users[] = $newUser;
        if (!Database::saveUsers($users)) {
            Database::respondError('Failed to save new user.', 500);
            exit;
        }

        Database::respondJson('success', ['user' => $newUser], 'User added successfully.');
        break;

    case 'delete':
        $id = (int) ($data['id'] ?? 0);
        if ($id <= 0) {
            Database::respondError('Valid user ID is required.', 400);
            exit;
        }

        $users = Database::getUsers();
        $deleted = false;
        $updatedUsers = [];

        foreach ($users as $user) {
            if ((int) $user['id'] === $id) {
                if (isset($user['role']) && $user['role'] === 'admin') {
                    Database::respondError('Admin accounts cannot be deleted here.', 403);
                    exit;
                }
                $deleted = true;
                continue;
            }
            $updatedUsers[] = $user;
        }

        if (!$deleted) {
            Database::respondError('User not found or cannot be deleted.', 404);
            exit;
        }

        if (!Database::saveUsers($updatedUsers)) {
            Database::respondError('Unable to delete user.', 500);
            exit;
        }

        Database::respondJson('success', null, 'User deleted successfully.');
        break;

    default:
        Database::respondError('Invalid action specified.', 400);
        break;
}
