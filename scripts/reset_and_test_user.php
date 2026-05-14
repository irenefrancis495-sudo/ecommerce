<?php
// Usage: php scripts/reset_and_test_user.php username newpassword
if ($argc < 3) {
    echo "Usage: php scripts/reset_and_test_user.php username newpassword\n";
    exit(2);
}
$username = $argv[1];
$newpass = $argv[2];

require __DIR__ . '/../config/bootstrap.php';
$db = $GLOBALS['db'] ?? null;
if (!$db) {
    echo "Could not get DB connection from bootstrap.\n";
    exit(3);
}

$hash = password_hash($newpass, PASSWORD_BCRYPT);
try {
    $db->executeStatement('UPDATE users SET password = ? WHERE username = ?', [$hash, $username]);
} catch (Exception $e) {
    echo "DB update failed: " . $e->getMessage() . "\n";
    exit(4);
}

$row = $db->fetchAssociative('SELECT password FROM users WHERE username = ?', [$username]);
if (!$row) {
    echo "User not found after update.\n";
    exit(5);
}
$ok = password_verify($newpass, $row['password']);
if ($ok) {
    echo "Password successfully updated and verified for user: $username\n";
    exit(0);
} else {
    echo "Password update failed verification for user: $username\n";
    exit(6);
}
