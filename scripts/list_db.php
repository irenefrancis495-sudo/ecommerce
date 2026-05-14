<?php
require_once __DIR__ . '/../config/bootstrap.php';

try {
    $tables = $GLOBALS['db']->executeQuery('SHOW TABLES')->fetchAllAssociative();
    echo "Tables:\n";
    foreach ($tables as $t) {
        echo reset($t) . "\n";
    }

    echo "\nUsers:\n";
    $rows = $GLOBALS['db']->executeQuery('SELECT id,username,email,role FROM users')->fetchAllAssociative();
    foreach ($rows as $r) {
        echo ($r['id'] ?? '?') . ' | ' . ($r['username'] ?? '') . ' | ' . ($r['email'] ?? '') . ' | ' . ($r['role'] ?? '') . "\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
