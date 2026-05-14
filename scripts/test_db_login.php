<?php
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Utils\Database;
use Mpemba\Controller\UserController;

$users = Database::getUsers();
echo "Users count: " . count($users) . PHP_EOL;

if (count($users) === 0) {
    $pwd = 'TestPass1';
    $new = [
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => password_hash($pwd, PASSWORD_DEFAULT),
        'role' => 'user'
    ];

    $id = Database::insertUserToDb($new);
    echo "Inserted id: " . var_export($id, true) . PHP_EOL;

    $created = Database::getUserByLogin('testuser');
    echo "Created user: " . ($created['username'] ?? 'N/A') . " id=" . ($created['id'] ?? 'N/A') . PHP_EOL;

    $c = new UserController();
    $res = $c->login('testuser', $pwd);
    echo "Login result: " . json_encode($res) . PHP_EOL;
} else {
    foreach ($users as $u) {
        echo "- " . ($u['id'] ?? '?') . " | " . ($u['username'] ?? ($u['email'] ?? 'no-id')) . PHP_EOL;
    }
    echo "(No automatic login attempted when users exist.)" . PHP_EOL;
}
