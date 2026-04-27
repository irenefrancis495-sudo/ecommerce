<?php
use Mpemba\Entity\Product;
require_once __DIR__ . '/../../data/mock_data.php';
require_once __DIR__ . '/_auth.php';
// $products = get_products();
$products = Product::getProducts();

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Products - Admin</title>
  <link rel="stylesheet" href="/Mpemba/css/admin.css">
  <script defer src="/Mpemba/js/admin.js"></script>
</head>
<body class="admin-app">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <div class="main">
    <header class="topbar"><h1>Products</h1><a class="btn" href="index.php">Back</a></header>
    <section class="panel">
      <h2>Product List</h2>
      <table class="table">
        <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($products as $p): ?>
          <tr>
            <td><?= $p['id']; ?></td>
            <td><?= htmlspecialchars($p['name']); ?></td>
            <td><?= htmlspecialchars($p['category']); ?></td>
            <td>$<?= number_format($p['price'],2); ?></td>
            <td><?= (int)$p['stock']; ?></td>
            <td><a href="#" class="link">Edit</a> | <a href="#" class="link danger">Delete</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </div>
</body>
</html>
