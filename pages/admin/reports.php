<?php
require_once __DIR__ . '/../../data/mock_data.php';
require_once __DIR__ . '/_auth.php';
$revenue = get_revenue_series();
$stats = get_stats();
$orders = get_orders();
$customers = get_customers();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Reports - Admin</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&amp;family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          "colors": {
            "surface-container-lowest": "#ffffff",
            "surface-container-low": "#f2f4f6",
            "on-background": "#191c1e",
            "surface-dim": "#d9dadc",
            "on-tertiary-fixed": "#221b00",
            "tertiary-container": "#c9a900",
            "secondary-fixed": "#ffdcc3",
            "on-tertiary-container": "#4c3f00",
            "secondary-container": "#ffa454",
            "inverse-primary": "#96ceeb",
            "on-error": "#ffffff",
            "primary": "#003345",
            "surface-bright": "#f8f9fb",
            "on-secondary": "#ffffff",
            "on-primary-fixed": "#001f2b",
            "surface-container-high": "#e7e8ea",
            "tertiary-fixed": "#ffe16d",
            "on-error-container": "#93000a",
            "on-secondary-fixed-variant": "#6e3900",
            "inverse-on-surface": "#f0f1f3",
            "outline-variant": "#c0c7cd",
            "surface": "#f8f9fb",
            "error": "#ba1a1a",
            "surface-container": "#edeef0",
            "inverse-surface": "#2e3133",
            "background": "#f8f9fb",
            "outline": "#71787d",
            "error-container": "#ffdad6",
            "on-tertiary": "#ffffff",
            "primary-fixed-dim": "#96ceeb",
            "primary-fixed": "#bfe8ff",
            "on-surface-variant": "#40484c",
            "secondary-fixed-dim": "#ffb77d",
            "secondary": "#904d00",
            "primary-container": "#004b63",
            "on-primary-fixed-variant": "#044d65",
            "on-secondary-container": "#713b00",
            "surface-variant": "#e1e2e5",
            "on-primary": "#ffffff",
            "surface-container-highest": "#e1e2e5",
            "surface-tint": "#2a657e",
            "on-secondary-fixed": "#2f1500",
            "on-tertiary-fixed-variant": "#544600",
            "tertiary": "#705d00",
            "on-primary-container": "#83bad6",
            "on-surface": "#191c1e",
            "tertiary-fixed-dim": "#e9c400"
          },
          "borderRadius": {
            "DEFAULT": "0.25rem",
            "lg": "0.5rem",
            "xl": "0.75rem",
            "full": "9999px"
          },
          "fontFamily": {
            "headline": ["Epilogue"],
            "body": ["Manrope"],
            "label": ["Manrope"]
          }
        },
      },
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
  </style>
</head>
<body class="bg-surface">
<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 z-50 flex flex-col py-6 bg-slate-50 dark:bg-slate-950 font-epilogue font-bold text-sm tracking-tight">
<div class="px-6 mb-10 flex items-center gap-3">
<div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-on-primary">
<span class="material-symbols-outlined text-lg" data-icon="token">token</span>
</div>
<span class="text-xl font-bold font-epilogue text-cyan-950 dark:text-cyan-50">Mpemba Admin</span>
</div>
<nav class="flex-1 px-4 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="index.php">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                Dashboard
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="products.php">
<span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                Products
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="orders.php">
<span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
                Orders
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="customers.php">
<span class="material-symbols-outlined" data-icon="people">people</span>
                Customers
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-cyan-900 dark:text-cyan-50 font-bold border-r-4 border-cyan-800 dark:border-cyan-400 bg-slate-200/50 dark:bg-slate-800/50 transition-transform duration-300 scale-102" href="reports.php">
<span class="material-symbols-outlined" data-icon="query_stats">query_stats</span>
                Reports
            </a>
</nav>
<div class="px-6 pt-6 mt-auto bg-slate-100/50 dark:bg-slate-900/50 py-4 flex items-center gap-3">
<img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=80&h=80&fit=crop&crop=center" />
<div class="overflow-hidden">
<p class="text-xs font-bold truncate">Admin Avatar</p>
<p class="text-[10px] text-slate-500 truncate">Marketplace Controller</p>
</div>
</div>
</aside>

<!-- Main Content -->
<main class="ml-64 min-h-screen bg-surface">
<!-- TopNavBar Component -->
<header class="sticky top-0 w-full z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl flex items-center justify-between px-8 py-4 border-b border-slate-200/10 shadow-sm shadow-slate-200/50 dark:shadow-none">
<div class="flex items-center gap-6 w-1/2">
<div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-cyan-800 transition-all rounded-full overflow-hidden">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
<input class="w-full pl-12 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none text-sm focus:ring-0" placeholder="Search reports..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="px-6 py-3 bg-primary text-on-primary rounded-lg text-sm font-bold flex items-center gap-2 transition-transform hover:scale-102">
<span class="material-symbols-outlined text-sm">download</span>
                        Export Report
                    </button>
</div>
</header>

<section class="p-8 space-y-8">
<!-- Header -->
<div class="flex items-end justify-between">
<div>
<span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">Analytics & Reports</span>
<h1 class="text-4xl font-black font-display text-primary leading-tight">Business Intelligence</h1>
<p class="text-on-surface-variant mt-2">Track performance metrics, revenue trends, and customer insights</p>
</div>
<div class="flex gap-4">
<select class="px-4 py-2 bg-surface-container border border-outline rounded-lg text-sm">
<option value="30">Last 30 Days</option>
<option value="90">Last 90 Days</option>
<option value="365">Last Year</option>
</select>
</div>
</div>

<!-- Key Metrics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
<div class="bg-surface-container-lowest p-6 rounded-xl">
<h3 class="text-sm font-medium text-outline mb-2">Total Revenue</h3>
<p class="text-2xl font-bold text-primary">$<?php echo number_format($stats[2]['val']); ?></p>
<div class="mt-2 flex items-center gap-2 text-xs font-bold text-green-600">
<span class="material-symbols-outlined text-sm">trending_up</span>
+15.3% vs last period
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl">
<h3 class="text-sm font-medium text-outline mb-2">Total Orders</h3>
<p class="text-2xl font-bold text-primary"><?php echo number_format($stats[0]['val']); ?></p>
<div class="mt-2 flex items-center gap-2 text-xs font-bold text-green-600">
<span class="material-symbols-outlined text-sm">trending_up</span>
+8.7% vs last period
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl">
<h3 class="text-sm font-medium text-outline mb-2">Avg Order Value</h3>
<p class="text-2xl font-bold text-primary">$<?php echo number_format(array_sum(array_column($orders, 'total')) / count($orders), 2); ?></p>
<div class="mt-2 flex items-center gap-2 text-xs font-bold text-blue-600">
<span class="material-symbols-outlined text-sm">trending_flat</span>
+2.1% vs last period
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl">
<h3 class="text-sm font-medium text-outline mb-2">Customer Growth</h3>
<p class="text-2xl font-bold text-primary"><?php echo count($customers); ?></p>
<div class="mt-2 flex items-center gap-2 text-xs font-bold text-green-600">
<span class="material-symbols-outlined text-sm">trending_up</span>
+12.4% vs last period
</div>
</div>
</div>

<!-- Revenue Chart -->
<div class="bg-surface-container-lowest rounded-2xl p-8">
<h2 class="text-2xl font-bold text-primary mb-6">Revenue Trends</h2>
<div class="h-64">
<canvas id="revenueChart"></canvas>
</div>
</div>

<!-- Additional Reports -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
<!-- Top Products -->
<div class="bg-surface-container-lowest rounded-2xl p-6">
<h3 class="text-xl font-bold text-primary mb-4">Top Performing Products</h3>
<div class="space-y-4">
<?php
$topSelling = get_top_selling();
foreach ($topSelling as $product): ?>
<div class="flex items-center justify-between p-4 bg-surface-container rounded-lg">
<div class="flex items-center gap-4">
<img class="w-12 h-12 rounded-lg object-cover" src="<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
<div>
<h4 class="font-medium text-primary"><?php echo htmlspecialchars($product['name']); ?></h4>
<p class="text-sm text-on-surface-variant"><?php echo number_format($product['qty']); ?> units sold</p>
</div>
</div>
<div class="text-right">
<p class="font-bold text-primary">$<?php echo number_format($product['price']); ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>

<!-- Order Status Breakdown -->
<div class="bg-surface-container-lowest rounded-2xl p-6">
<h3 class="text-xl font-bold text-primary mb-4">Order Status Distribution</h3>
<div class="space-y-4">
<?php
$statusCounts = array_count_values(array_column($orders, 'status'));
$totalOrders = count($orders);
foreach ($statusCounts as $status => $count): ?>
<div class="flex items-center justify-between">
<div class="flex items-center gap-3">
<span class="w-3 h-3 rounded-full bg-<?php echo $status === 'delivered' ? 'green' : ($status === 'on_delivery' ? 'blue' : ($status === 'cancelled' ? 'red' : 'gray')); ?>-500"></span>
<span class="text-sm font-medium text-primary capitalize"><?php echo str_replace('_', ' ', $status); ?></span>
</div>
<div class="flex items-center gap-2">
<span class="text-sm font-bold text-primary"><?php echo $count; ?></span>
<span class="text-xs text-on-surface-variant">(<?php echo round(($count / $totalOrders) * 100); ?>%)</span>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</section>
</main>

<script>
const revenueData = <?php echo json_encode($revenue); ?>;
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: revenueData.map((_, i) => `Month ${i + 1}`),
        datasets: [{
            label: 'Revenue ($)',
            data: revenueData,
            borderColor: '#003345',
            backgroundColor: 'rgba(0, 51, 69, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value;
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
</body>
</html>
