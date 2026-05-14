<?php
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Controller\UserController;
use Mpemba\Utils\Database;

$username = 'regtest_' . time();
$email = 'regtest+' . time() . '@example.com';
$password = 'RegPass123';

// Clean up existing test user in DB/JSON
$existing = Database::getUserByLogin($username);
if ($existing) {
    // If DB-backed, try deleting via SQL
    try {
        $GLOBALS['db']->executeStatement('DELETE FROM users WHERE username = ?', [$username]);
    } catch (Exception $e) {
        // ignore
    }
    // also remove from JSON if present
    $usersFile = __DIR__ . '/../data/users.json';
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true) ?: [];
        $users = array_values(array_filter($users, fn($u) => ($u['username'] ?? '') !== $username));
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    }
}


$foundBefore = Database::getUserByLogin($username);
echo "Lookup before register: " . json_encode($foundBefore) . PHP_EOL;

$controller = new UserController();
$result = $controller->register($username, $email, $password);

echo "Register result: " . json_encode($result) . PHP_EOL;

$created = Database::getUserByLogin($username);
if (!$created) {
    echo "Failed to locate created user.\n";
    exit(1);
}

echo "Stored user id: " . ($created['id'] ?? 'N/A') . PHP_EOL;
echo "Stored password hash: " . ($created['password'] ?? 'N/A') . PHP_EOL;

// Verify the hash
$stored = (string) ($created['password'] ?? '');
if (password_verify($password, $stored)) {
    echo "Password verification: OK\n";
} else {
    echo "Password verification: FAILED\n";
}

// Try login via controller
$loginRes = $controller->login($username, $password);
echo "Login attempt result: " . json_encode($loginRes) . PHP_EOL;

// Cleanup: remove test user
try {
    $GLOBALS['db']->executeStatement('DELETE FROM users WHERE username = ?', [$username]);
    echo "Cleanup: removed DB user if present.\n";
} catch (Exception $e) {
}
$usersFile = __DIR__ . '/../data/users.json';
if (file_exists($usersFile)) {
    $users = json_decode(file_get_contents($usersFile), true) ?: [];
    $users = array_values(array_filter($users, fn($u) => ($u['username'] ?? '') !== $username));
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    echo "Cleanup: removed JSON user if present.\n";
}
