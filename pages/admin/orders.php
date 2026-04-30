<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /admin/login.php');
    exit;
}

require_once __DIR__ . '/../../data/mock_data.php';
$orders = get_orders();
$customers = get_customers();
?>

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
<a class="flex items-center gap-3 px-4 py-3 text-cyan-900 dark:text-cyan-50 font-bold border-r-4 border-cyan-800 dark:border-cyan-400 bg-slate-200/50 dark:bg-slate-800/50 transition-transform duration-300 scale-102" href="orders.php">
<span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
                Orders
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="customers.php">
<span class="material-symbols-outlined" data-icon="people">people</span>
                Customers
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="reports.php">
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
<input class="w-full pl-12 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none text-sm focus:ring-0" placeholder="Search orders..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<select class="px-4 py-2 bg-surface-container border border-outline rounded-lg text-sm">
<option value="">All Status</option>
<option value="pending">Pending</option>
<option value="processing">Processing</option>
<option value="shipped">Shipped</option>
<option value="delivered">Delivered</option>
<option value="cancelled">Cancelled</option>
</select>
</div>
</header>

<section class="p-8 space-y-8">
<!-- Header -->
<div class="flex items-end justify-between">
<div>
<span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">Order Management</span>
<h1 class="text-4xl font-black font-display text-primary leading-tight">Orders Overview</h1>
<p class="text-on-surface-variant mt-2">Track and manage customer orders, update statuses, and process shipments</p>
</div>
<div class="flex gap-4">
<span class="px-4 py-2 bg-surface-container text-on-surface-variant rounded-lg text-sm font-medium">
<?php echo count($orders); ?> orders total
</span>
</div>
</div>

<!-- Order Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
<div class="bg-surface-container-lowest p-6 rounded-xl">
<h3 class="text-sm font-medium text-outline mb-2">Total Orders</h3>
<p class="text-2xl font-bold text-primary"><?php echo count($orders); ?></p>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl">
<h3 class="text-sm font-medium text-outline mb-2">Pending Orders</h3>
<p class="text-2xl font-bold text-yellow-600"><?php echo count(array_filter($orders, fn($o) => $o['status'] === 'pending')); ?></p>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl">
<h3 class="text-sm font-medium text-outline mb-2">Delivered Orders</h3>
<p class="text-2xl font-bold text-green-600"><?php echo count(array_filter($orders, fn($o) => $o['status'] === 'delivered')); ?></p>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl">
<h3 class="text-sm font-medium text-outline mb-2">Cancelled Orders</h3>
<p class="text-2xl font-bold text-red-600"><?php echo count(array_filter($orders, fn($o) => $o['status'] === 'cancelled')); ?></p>
</div>
</div>

<!-- Orders Table -->
<div class="bg-surface-container-lowest rounded-2xl overflow-hidden">
<div class="p-6 border-b border-surface-container-highest">
<h2 class="text-xl font-bold text-primary">Recent Orders</h2>
</div>
<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-surface-container-highest">
<tr>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Order ID</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Customer</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Total</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Status</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Date</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container-highest">
<?php foreach ($orders as $order): ?>
<tr class="hover:bg-surface-container transition-colors">
<td class="px-6 py-4 font-bold text-primary">#<?php echo $order['id']; ?></td>
<td class="px-6 py-4">
<div>
<h3 class="font-medium text-primary"><?php echo htmlspecialchars($order['customer']); ?></h3>
<p class="text-sm text-on-surface-variant">Customer ID: <?php echo rand(1000, 9999); ?></p>
</div>
</td>
<td class="px-6 py-4 font-bold text-primary">
$<?php echo number_format($order['total'], 2); ?>
</td>
<td class="px-6 py-4">
<?php
$statusColors = [
    'delivered' => 'bg-green-100 text-green-800',
    'on_delivery' => 'bg-blue-100 text-blue-800',
    'cancelled' => 'bg-red-100 text-red-800',
    'pending' => 'bg-gray-100 text-gray-800'
];
$status = $order['status'];
$colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
?>
<span class="px-3 py-1 <?php echo $colorClass; ?> rounded-full text-xs font-medium capitalize">
<?php echo str_replace('_', ' ', $status); ?>
</span>
</td>
<td class="px-6 py-4 text-sm text-on-surface-variant">
<?php echo htmlspecialchars($order['date']); ?>
</td>
<td class="px-6 py-4">
<div class="flex gap-2">
<button class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" title="View Details">
<span class="material-symbols-outlined text-sm">visibility</span>
</button>
<button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Update Status">
<span class="material-symbols-outlined text-sm">edit</span>
</button>
<button class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Print Invoice">
<span class="material-symbols-outlined text-sm">print</span>
</button>
</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</section>
</main>