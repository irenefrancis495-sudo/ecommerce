<?php

use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = 'Dotenv\Dotenv'::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$connectionParams = [
    'driver'   => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
    'host'     => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'port'     => $_ENV['DB_PORT'] ?? '3306',
    'dbname'   => $_ENV['DB_NAME'] ?? 'field_teaching',
    'user'     => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? '',
];

if (($connectionParams['driver'] ?? '') === 'pdo_sqlite') {
    $connectionParams['path'] = __DIR__ . '/' . ($_ENV['DB_PATH'] ?? 'db.sqlite');
}

$db = 'Doctrine\DBAL\DriverManager'::getConnection($connectionParams);
