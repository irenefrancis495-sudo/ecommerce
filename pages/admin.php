<?php
use Mpemba\Utils\Utility;
$results = Utility::safeQuery("SELECT * FROM user");
print_r($results);
echo "<h3>Admin Dashboard</h3>";
echo "<p>Use the Utility class for database operations.</p>";
