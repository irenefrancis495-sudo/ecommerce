<?php
// Creates the database named in .env and imports schema from database_schema.sql
$root = __DIR__ . '/..';
$envFile = $root . '/.env';
$schemaFile = $root . '/database_schema.sql';

function parseEnv($path) {
    $result = [];
    if (!file_exists($path)) return $result;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2) + [1 => '']);
        $result[$k] = $v;
    }
    return $result;
}

$env = parseEnv($envFile);
$driver = $env['DB_DRIVER'] ?? 'pdo_mysql';
$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$dbName = $env['DB_NAME'] ?? 'ecommerce';
$user = $env['DB_USER'] ?? 'root';
$pass = $env['DB_PASSWORD'] ?? '';

if ($driver !== 'pdo_mysql') {
    echo "Only MySQL (pdo_mysql) is supported by this helper script. Current driver: {$driver}\n";
    exit(1);
}

try {
    $dsn = "mysql:host={$host};port={$port}";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connected to MySQL at {$host}:{$port}\n";

    // Create database if not exists
    $createSql = "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($createSql);
    echo "Database `{$dbName}` ensured.\n";
    // Select the created database so subsequent CREATE TABLE statements run in it
    $pdo->exec("USE `{$dbName}`");
    echo "Using database `{$dbName}` for schema import.\n";

    if (!file_exists($schemaFile)) {
        echo "Schema file not found: {$schemaFile}\n";
        exit(1);
    }

    $schema = file_get_contents($schemaFile);
    // Remove/create database and use lines from schema to avoid conflicts
    $schema = preg_replace('/CREATE DATABASE IF NOT EXISTS\s+[`\"]?\w+[`\"]?;?/i', '', $schema);
    $schema = preg_replace('/USE\s+[`\"]?\w+[`\"]?;?/i', '', $schema);

    // Replace any leftover named db occurrences (mpemba_db) with target name
    $schema = str_replace('mpemba_db', $dbName, $schema);

    // Execute statements one by one
    $statements = preg_split('/;\s*\n/', $schema);
    $count = 0;
    foreach ($statements as $stmt) {
        $s = trim($stmt);
        if ($s === '') continue;
        try {
            $pdo->exec($s);
            $count++;
        } catch (Exception $e) {
            echo "Failed to execute statement: " . substr($s, 0, 120) . "...\nError: " . $e->getMessage() . "\n";
        }
    }

    echo "Imported schema statements executed: {$count}\n";
    echo "Done.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
