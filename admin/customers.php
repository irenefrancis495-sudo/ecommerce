<?php
require_once __DIR__ . '/../data/mock_data.php';
require_once __DIR__ . '/_auth.php';
$customers = get_customers();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Customers - Admin</title>
  <link rel="stylesheet" href="/Mpemba/css/admin.css">
</head>
<body class="admin-app">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <div class="main">
    <header class="topbar"><h1>Customers</h1><a class="btn" href="index.php">Back</a></header>
    <section class="panel">
      <h2>Customer List</h2>
      <table class="table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Joined</th></tr></thead>
        <tbody>
          <?php foreach ($customers as $c): ?>
          <tr>
            <td><?php echo $c['id']; ?></td>
            <td><?php echo htmlspecialchars($c['name']); ?></td>
            <td><?php echo htmlspecialchars($c['email']); ?></td>
            <td><?php echo htmlspecialchars($c['joined']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </div>
</body>
</html>
