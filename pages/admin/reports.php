<?php
require_once __DIR__ . '/../data/mock_data.php';
require_once __DIR__ . '/_auth.php';
$revenue = get_revenue_series();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Reports - Admin</title>
  <link rel="stylesheet" href="/Mpemba/css/admin.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script defer src="/Mpemba/js/admin.js"></script>
</head>
<body class="admin-app">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <div class="main">
    <header class="topbar"><h1>Reports</h1><a class="btn" href="index.php">Back</a></header>
    <section class="panel">
      <h2>Revenue Report</h2>
      <canvas id="reportRevenue" height="120"></canvas>
    </section>
  </div>
  <script>window.__REPORT_DATA = <?php echo json_encode($revenue); ?>;</script>
</body>
</html>
