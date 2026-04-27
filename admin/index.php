<?php
require_once __DIR__ . '/../data/mock_data.php';
require_once __DIR__ . '/_auth.php';
$stats = get_stats();
$top = get_top_selling();
$orders = get_orders();
$products = get_products();
$customers = get_customers();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Dashboard - Mpemba</title>
  <link rel="stylesheet" href="/Mpemba/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script defer src="/Mpemba/js/admin.js"></script>
</head>
<body class="admin-app">
  <?php include __DIR__ . '/_sidebar.php' ?? ''; ?>
  <div class="main">
    <header class="topbar">
      <h1>Dashboard</h1>
      <div class="top-actions">
        <span class="user">Hello, <?php echo htmlspecialchars($_SESSION['admin_user']['name']); ?></span>
        <a class="btn small" href="logout.php">Logout</a>
      </div>
    </header>

    <section class="cards">
      <?php foreach ($stats as $s): ?>
      <div class="card">
        <div class="card-left">
          <i class="fas <?php echo $s['icon']; ?> icon"></i>
        </div>
        <div class="card-body">
          <div class="card-value"><?php echo is_numeric($s['val']) ? number_format($s['val']) : htmlspecialchars($s['val']); ?></div>
          <div class="card-label"><?php echo htmlspecialchars($s['label']); ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </section>

    <section class="grid">
      <div class="panel">
        <h2>Revenue (12 months)</h2>
        <canvas id="revenueChart" height="140"></canvas>
      </div>
      <div class="panel">
        <h2>Top Selling</h2>
        <ul class="list">
          <?php foreach ($top as $t): ?>
          <li>
            <img src="<?php echo $t['img']; ?>" alt=""/>
            <div><?php echo htmlspecialchars($t['name']); ?></div>
            <div class="muted"><?php echo (int)$t['qty']; ?></div>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>

    <section class="panel">
      <h2>Recent Orders</h2>
      <table class="table">
        <thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
          <tr>
            <td><?php echo $o['id']; ?></td>
            <td><?php echo htmlspecialchars($o['customer']); ?></td>
            <td>$<?php echo number_format($o['total'],2); ?></td>
            <td><?php echo htmlspecialchars($o['status']); ?></td>
            <td><?php echo htmlspecialchars($o['date']); ?></td>
            <td><a href="orders.php?id=<?php echo $o['id']; ?>" class="link">View</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

  </div>
  <script>window.__ADMIN_API = '/Mpemba/api/admin_data.php';</script>
</body>
</html>
