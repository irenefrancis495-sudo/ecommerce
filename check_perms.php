<?php
require_once __DIR__ . '/config/bootstrap.php';
use Mpemba\Utils\Database;
$perms = Database::getRolePermissions();
var_dump($perms);
?>