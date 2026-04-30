<?php

use Mpemba\Utils\Router;

require __DIR__ . '/config/bootstrap.php';
global $entityManager;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Router::getPathName() ?></title>
    <link href="styles.css" rel="stylesheet">
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/sweetalert2/sweetalert2.all.min.js"></script>
    <link href="assets/DataTables/datatables.min.css" rel="stylesheet">
    
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php

Router::load()
?>


<script src="assets/DataTables/datatables.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>


</body>
</html>
