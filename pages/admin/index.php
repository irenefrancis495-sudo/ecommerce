<?php
ini_set('display_errors', 0);
error_reporting(0);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /admin/login.php');
    exit;
}

require_once __DIR__ . '/../../data/mock_data.php';
$stats = get_stats();
$topSelling = get_top_selling();
$customers = get_customers();
$orders = get_orders();
$revenue = get_revenue_series();
$products = json_decode(file_get_contents(__DIR__ . '/../../data/products.json'), true) ?: [];
$lowStockCount = count(array_filter($products, fn($product) => (int) ($product['stock_quantity'] ?? 0) < 10));
?>


<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 z-50 flex flex-col py-6 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 font-epilogue font-bold text-sm tracking-tight shadow-2xl">
<div class="px-6 mb-10 flex items-center gap-3">
<div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
<span class="material-symbols-outlined text-xl">admin_panel_settings</span>
</div>
<span class="text-xl font-bold font-epilogue text-white">Mpemba Admin</span>
</div>
<nav class="flex-1 px-4 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 text-white font-bold border-r-4 border-blue-400 bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl" href="index.php">
<span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-300 hover:scale-105" href="products.php">
<span class="material-symbols-outlined">inventory_2</span>
                Products
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-300 hover:scale-105" href="orders.php">
<span class="material-symbols-outlined">shopping_cart</span>
                Orders
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-300 hover:scale-105" href="customers.php">
<span class="material-symbols-outlined">people</span>
                Customers
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-300 hover:scale-105" href="reports.php">
<span class="material-symbols-outlined">query_stats</span>
                Reports
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-300 hover:scale-105" href="#">
<span class="material-symbols-outlined">settings</span>
                Settings
            </a>
</nav>
<div class="px-6 pt-6 mt-auto bg-slate-800/50 py-4 flex items-center gap-3 rounded-lg mx-4">
<img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover ring-2 ring-blue-400" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=80&h=80&fit=crop&crop=center" />
<div class="overflow-hidden">
<p class="text-xs font-bold truncate text-white">Admin Avatar</p>
<p class="text-[10px] text-slate-400 truncate">Marketplace Controller</p>
</div>
</div>
</aside>
<!-- Main Content Canvas -->
<main class="ml-64 min-h-screen relative bg-gradient-to-br from-slate-50 via-blue-50/30 to-purple-50/30">
<!-- TopNavBar Component -->
<header class="sticky top-0 w-full z-40 bg-white/90 backdrop-blur-xl flex items-center justify-between px-8 py-4 border-b border-slate-200/20 shadow-lg">
<div class="flex items-center gap-6 w-1/2">
<div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-blue-500 transition-all rounded-full overflow-hidden shadow-sm">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
<input class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-full text-sm focus:ring-0 focus:border-blue-500 placeholder-slate-400" placeholder="Search analytics or orders..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="p-3 text-slate-600 hover:bg-slate-100 hover:text-blue-600 rounded-full transition-all duration-200 hover:scale-110">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="p-3 text-slate-600 hover:bg-slate-100 hover:text-blue-600 rounded-full transition-all duration-200 hover:scale-110">
<span class="material-symbols-outlined">help_outline</span>
</button>
<a href="index.php" class="p-3 text-slate-600 hover:bg-slate-100 hover:text-blue-600 rounded-full transition-all duration-200 hover:scale-110">
<span class="material-symbols-outlined">refresh</span>
</a>
<div class="h-8 w-[1px] bg-slate-300 mx-2"></div>
<div class="relative group">
<div class="flex items-center gap-3 cursor-pointer hover:bg-slate-50 rounded-lg px-3 py-2 transition-colors">
<span class="font-manrope text-sm font-semibold text-slate-700">Administrator</span>
<img alt="Administrator Profile" class="w-8 h-8 rounded-full ring-2 ring-blue-200" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=80&h=80&fit=crop&crop=center" />
<div class="absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
<a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 rounded-t-xl transition-colors">
<span class="material-symbols-outlined mr-2 text-base">person</span>
Profile
</a>
<a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
<span class="material-symbols-outlined mr-2 text-base">settings</span>
Settings
</a>
<a href="logout.php" class="block px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl transition-colors">
<span class="material-symbols-outlined mr-2 text-base">logout</span>
Logout
</a>
</div>
</div>
</div>
</header>
<section class="p-8 space-y-12 max-w-7xl mx-auto">
<!-- Dashboard Header -->
<div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
<div class="max-w-2xl">
<span class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 text-xs font-bold uppercase tracking-wider rounded-full mb-4">
<span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
System Overview
</span>
<h1 class="text-4xl md:text-5xl font-black font-display bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent leading-tight">Marketplace Operations</h1>
<p class="mt-4 text-slate-600 text-lg max-w-xl">A polished command center for catalog management, order insight, and inventory health.</p>
</div>
<div class="flex flex-wrap items-center gap-3">
<a href="products.php" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
<span class="material-symbols-outlined text-base">inventory_2</span>
Add Product
</a>
<button class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 hover:border-slate-300 transition-all duration-300 hover:scale-105 shadow-sm">
<span class="material-symbols-outlined text-base">download</span>
Export Report
</button>
</div>
</div>
<!-- Summary Grid -->
<div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
<div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-xl shadow-blue-500/25 hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 hover:scale-[1.02]">
<div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
<div class="relative flex items-center justify-between gap-4">
<div>
<p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-100">Total Orders</p>
<h3 class="mt-4 text-3xl font-black"><?php echo number_format($stats[0]['val'] ?? 0); ?></h3>
</div>
<div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
<span class="material-symbols-outlined text-xl">shopping_cart</span>
</div>
</div>
<div class="relative mt-4 text-sm text-blue-100">Order volume across the catalog and fulfillment flow.</div>
</div>
<div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 text-white shadow-xl shadow-emerald-500/25 hover:shadow-2xl hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-[1.02]">
<div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
<div class="relative flex items-center justify-between gap-4">
<div>
<p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-100">Revenue</p>
<h3 class="mt-4 text-3xl font-black">$<?php echo number_format($stats[2]['val'] ?? 0); ?></h3>
</div>
<div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
<span class="material-symbols-outlined text-xl">payments</span>
</div>
</div>
<div class="relative mt-4 text-sm text-emerald-100">Net revenue performance for the current period.</div>
</div>
<div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white shadow-xl shadow-purple-500/25 hover:shadow-2xl hover:shadow-purple-500/40 transition-all duration-300 hover:scale-[1.02]">
<div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
<div class="relative flex items-center justify-between gap-4">
<div>
<p class="text-xs font-bold uppercase tracking-[0.3em] text-purple-100">Products</p>
<h3 class="mt-4 text-3xl font-black"><?php echo number_format(count($products)); ?></h3>
</div>
<div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
<span class="material-symbols-outlined text-xl">inventory_2</span>
</div>
</div>
<div class="relative mt-4 text-sm text-purple-100">Active products in your marketplace catalog.</div>
</div>
<div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-orange-500 to-orange-600 p-6 text-white shadow-xl shadow-orange-500/25 hover:shadow-2xl hover:shadow-orange-500/40 transition-all duration-300 hover:scale-[1.02]">
<div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
<div class="relative flex items-center justify-between gap-4">
<div>
<p class="text-xs font-bold uppercase tracking-[0.3em] text-orange-100">Low Stock</p>
<h3 class="mt-4 text-3xl font-black"><?php echo $lowStockCount; ?></h3>
</div>
<div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
<span class="material-symbols-outlined text-xl">warning</span>
</div>
</div>
<div class="relative mt-4 text-sm text-orange-100">Products that need a restock review.</div>
</div>
</div>
<!-- Main Analytics & Activity Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
<!-- Growth Chart (Asymmetric Composition) -->
<div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/20 border border-slate-200/50">
<div class="flex items-center justify-between mb-8">
<h2 class="text-2xl font-black font-display bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Sales Growth Performance</h2>
<div class="flex items-center gap-3">
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-gradient-to-r from-blue-500 to-purple-500"></span>
<span class="text-sm font-semibold text-slate-600">Last 30 Days</span>
</div>
<button class="text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">View Details →</button>
</div>
</div>
<div class="h-64 flex items-end justify-between gap-2 relative mb-6">
<!-- Modern gradient chart bars -->
<div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-lg h-[40%] hover:from-blue-300 hover:to-blue-400 transition-all duration-300 cursor-pointer"></div>
<div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-lg h-[65%] hover:from-blue-300 hover:to-blue-400 transition-all duration-300 cursor-pointer"></div>
<div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-lg h-[55%] hover:from-blue-300 hover:to-blue-400 transition-all duration-300 cursor-pointer"></div>
<div class="w-full bg-gradient-to-t from-blue-400 to-blue-500 rounded-t-lg h-[90%] transition-all duration-300 shadow-lg shadow-blue-500/30"></div>
<div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-lg h-[75%] hover:from-blue-300 hover:to-blue-400 transition-all duration-300 cursor-pointer"></div>
<div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-lg h-[60%] hover:from-blue-300 hover:to-blue-400 transition-all duration-300 cursor-pointer"></div>
<div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-lg h-[85%] hover:from-blue-300 hover:to-blue-400 transition-all duration-300 cursor-pointer"></div>
<div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-lg h-[50%] hover:from-blue-300 hover:to-blue-400 transition-all duration-300 cursor-pointer"></div>
<div class="w-full bg-gradient-to-t from-slate-200 to-slate-300 rounded-t-lg h-[70%] hover:from-blue-300 hover:to-blue-400 transition-all duration-300 cursor-pointer"></div>
<div class="w-full bg-gradient-to-t from-purple-400 to-purple-500 rounded-t-lg h-[100%] transition-all duration-300 shadow-lg shadow-purple-500/30"></div>
<!-- Trend line overlay -->
<svg class="absolute inset-0 w-full h-full pointer-events-none" preserveaspectratio="none" viewbox="0 0 1000 100">
<path d="M0,80 Q250,20 500,50 T1000,10" fill="none" stroke="url(#gradient)" stroke-width="3" stroke-linecap="round"/>
<defs>
<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
<stop offset="0%" style="stop-color:#3b82f6;stop-opacity:0.8" />
<stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:0.8" />
</linearGradient>
</defs>
</svg>
</div>
<div class="grid grid-cols-5 mt-4 text-xs font-bold text-slate-500 text-center uppercase tracking-wider">
<span>Week 1</span>
<span>Week 2</span>
<span>Week 3</span>
<span>Week 4</span>
<span>Current</span>
</div>
</div>
<!-- Recent Activity (Editorial Feed) -->
<div class="space-y-6">
<h2 class="text-2xl font-black font-display bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent mb-6">Recent Activity</h2>
<div class="space-y-0 relative">
<!-- Timeline Line -->
<div class="absolute left-6 top-4 bottom-4 w-[1px] bg-gradient-to-b from-blue-200 to-purple-200"></div>
<!-- Activity Items -->
<div class="relative pl-14 pb-8 group">
<div class="absolute left-4 top-1 w-4 h-4 rounded-full border-2 border-blue-500 bg-white transition-all duration-300 group-hover:bg-blue-500 group-hover:scale-110 shadow-lg shadow-blue-500/30"></div>
<div class="p-6 bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-200/50 hover:shadow-xl hover:shadow-slate-200/60 transition-all duration-300 hover:scale-[1.02]">
<p class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">2 minutes ago</p>
<p class="text-lg font-bold text-slate-800 mb-1">New Vendor Application</p>
<p class="text-sm text-slate-600 mb-4">Artisan Ceramics Ltd. applied for storefront access.</p>
<div class="flex gap-3">
<button class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-full transition-colors duration-200">Review</button>
</div>
</div>
</div>
<div class="relative pl-14 pb-8 group">
<div class="absolute left-4 top-1 w-4 h-4 rounded-full border-2 border-emerald-500 bg-white transition-all duration-300 group-hover:bg-emerald-500 group-hover:scale-110 shadow-lg shadow-emerald-500/30"></div>
<div class="p-6 bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-200/50 hover:shadow-xl hover:shadow-slate-200/60 transition-all duration-300 hover:scale-[1.02]">
<p class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">1 hour ago</p>
<p class="text-lg font-bold text-slate-800 mb-1">High Value Order #8921</p>
<p class="text-sm text-slate-600">Bulk order processed: $12,400.00 by Corporate Gifting.</p>
</div>
</div>
<div class="relative pl-14 group">
<div class="absolute left-4 top-1 w-4 h-4 rounded-full border-2 border-orange-500 bg-white transition-all duration-300 group-hover:bg-orange-500 group-hover:scale-110 shadow-lg shadow-orange-500/30"></div>
<div class="p-6 bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-200/50 hover:shadow-xl hover:shadow-slate-200/60 transition-all duration-300 hover:scale-[1.02]">
<p class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">4 hours ago</p>
<p class="text-lg font-bold text-slate-800 mb-1">Inventory Alert</p>
<p class="text-sm text-slate-600">5 items are below safety stock levels in "Home & Living".</p>
</div>
</div>
</div>
<button class="w-full py-4 text-sm font-bold text-blue-600 border border-blue-200 rounded-xl hover:bg-blue-50 transition-all duration-300 hover:scale-[1.02] shadow-sm">
View Full Audit Log →
</button>
</div>
</div>
<!-- Top Selling Products -->
<div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/20 border border-slate-200/50">
<h2 class="text-2xl font-black font-display bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent mb-6">Top Selling Products</h2>
<div class="space-y-4">
<?php if (!empty($topSelling)): ?>
<?php foreach ($topSelling as $product): ?>
<div class="flex items-center gap-4 p-5 bg-gradient-to-r from-slate-50 to-white rounded-2xl hover:from-blue-50 hover:to-purple-50 transition-all duration-300 hover:scale-[1.02] border border-slate-200/50 hover:border-blue-200/50 shadow-sm hover:shadow-md">
<img class="w-16 h-16 rounded-xl object-cover shadow-sm" src="<?php echo htmlspecialchars($product['img'] ?? 'https://images.unsplash.com/photo-1513708927376-8d6b8f92ca5c?w=640&fit=crop&crop=faces'); ?>" alt="<?php echo htmlspecialchars($product['name'] ?? 'Top product'); ?>">
<div class="flex-1">
<h3 class="font-bold text-slate-800 text-lg"><?php echo htmlspecialchars($product['name'] ?? 'Unnamed product'); ?></h3>
<p class="text-sm text-slate-500"><?php echo number_format($product['qty'] ?? 0); ?> units sold</p>
</div>
<div class="text-right">
<p class="font-bold text-slate-800 text-lg">$<?php echo number_format($product['price'] ?? 0); ?></p>
<div class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">
<span class="material-symbols-outlined text-sm">trending_up</span>
Top performer
</div>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="p-8 rounded-2xl bg-slate-50 text-center text-slate-500 border-2 border-dashed border-slate-200">
<div class="material-symbols-outlined text-4xl text-slate-300 mb-2">inventory_2</div>
<p class="text-sm">No top selling products available yet.</p>
</div>
<?php endif; ?>
</div>
</div>
</div>
<!-- Strategic Insights Section -->
<div class="bg-gradient-to-br from-blue-600 via-purple-600 to-blue-700 p-12 rounded-3xl overflow-hidden relative text-white shadow-2xl shadow-blue-500/25">
<div class="absolute top-0 right-0 w-1/3 h-full overflow-hidden opacity-10">
<img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=1200&h=800&fit=crop&crop=center" />
</div>
<div class="relative z-10 max-w-xl">
<div class="flex items-center gap-3 mb-4">
<span class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-sm text-xs font-bold uppercase tracking-wider rounded-full">
<span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
Strategic Insights
</span>
</div>
<h3 class="text-3xl font-black font-display mb-4 leading-tight">Marketplace Intelligence</h3>
<p class="text-blue-100 mb-8 font-medium text-lg">Your marketplace reached a new milestone in customer retention this week. Review the quarterly expansion plan for upcoming regional vendor onboarding.</p>
<a class="inline-flex items-center gap-3 text-white font-bold hover:gap-5 transition-all duration-300 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full hover:bg-white/30" href="reports.php">
Deep Dive into Analytics
<span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
</div>
</section>
</main>

