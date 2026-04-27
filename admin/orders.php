<?php
require_once __DIR__ . '/../data/mock_data.php';
require_once __DIR__ . '/_auth.php';
$orders = get_orders();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Orders - Admin</title>
  <link rel="stylesheet" href="/Mpemba/css/admin.css">
</head>
<body class="admin-app">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <div class="main">
    <header class="topbar"><h1>Orders</h1><a class="btn" href="index.php">Back</a></header>
    <section class="panel">
      <h2>Orders</h2>
      <table class="table">
        <thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
          <tr>
            <td><?php echo $o['id']; ?></td>
            <td><?php echo htmlspecialchars($o['customer']); ?></td>
            <td>$<?php echo number_format($o['total'],2); ?></td>
            <td><?php echo htmlspecialchars($o['status']); ?></td>
            <td><?php echo htmlspecialchars($o['date']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </div>
</body>
</html>
