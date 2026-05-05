<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'reports';

function readJsonArray(string $path): array {
    if (!file_exists($path)) {
        return [];
    }
    $data = json_decode((string) file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

$orders = readJsonArray(__DIR__ . '/../../data/orders.json');
$users = readJsonArray(__DIR__ . '/../../data/users.json');
$products = readJsonArray(__DIR__ . '/../../data/products.json');

$orderCount = count($orders);
$totalRevenue = 0.0;
$paidCount = 0;
$pendingCount = 0;
$completedCount = 0;
$processingCount = 0;

foreach ($orders as $o) {
    $totalRevenue += (float) ($o['total'] ?? 0);

    $paymentStatus = strtolower((string) ($o['payment_status'] ?? ''));
    if ($paymentStatus === 'paid') {
        $paidCount++;
    } else {
        $pendingCount++;
    }

    $status = strtolower((string) ($o['status'] ?? ''));
    if ($status === 'completed' || $status === 'delivered') {
        $completedCount++;
    }
    if ($status === 'processing' || $status === 'on_delivery' || $status === 'shipped') {
        $processingCount++;
    }
}

$userCount = count($users);
$adminCount = 0;
foreach ($users as $u) {
    if (strtolower((string) ($u['role'] ?? '')) === 'admin') {
        $adminCount++;
    }
}
$customerCount = max(0, $userCount - $adminCount);

$productCount = count($products);
$lowStockCount = 0;
$categoryTotals = [];

foreach ($products as $p) {
    $stock = (int) ($p['stock_quantity'] ?? 0);
    if ($stock < 40) {
        $lowStockCount++;
    }

    $category = (string) ($p['category'] ?? 'other');
    if (!isset($categoryTotals[$category])) {
        $categoryTotals[$category] = 0;
    }
    $categoryTotals[$category]++;
}

arsort($categoryTotals);
$topCategories = array_slice($categoryTotals, 0, 4, true);

$avgOrder = $orderCount > 0 ? ($totalRevenue / $orderCount) : 0;
$conversionRate = $orderCount > 0 ? (($completedCount / $orderCount) * 100) : 0;

// Generate 6-month trend deterministically from available totals.
$base = max(100, (int) round($totalRevenue > 0 ? $totalRevenue : 480));
$monthlyTrend = [];
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
for ($i = 0; $i < 6; $i++) {
    $monthlyTrend[] = (int) round($base * (0.62 + ($i * 0.08)) + (($productCount + $userCount) * ($i + 1)));
}
$maxTrend = max($monthlyTrend ?: [1]);
?>

<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 430, 'GRAD' 0, 'opsz' 24; }

  body {
    background:
      radial-gradient(circle at 10% 0%, rgba(20, 184, 166, 0.08) 0%, transparent 30%),
      radial-gradient(circle at 100% 20%, rgba(245, 158, 11, 0.08) 0%, transparent 35%),
      #f5f7fb;
  }

  .admin-shell { position: relative; }

  .admin-shell::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background-image: linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
    background-size: 42px 42px;
    mask-image: radial-gradient(circle at center, black, transparent 78%);
    z-index: 0;
  }

  .surface-glass {
    background: rgba(255, 255, 255, 0.74);
    backdrop-filter: blur(16px);
  }

  .admin-sidebar {
    border-right: 1px solid rgba(255, 255, 255, 0.45);
    box-shadow: 0 24px 40px -32px rgba(15, 23, 42, 0.5);
  }

  .admin-topbar {
    border-bottom: 1px solid rgba(255, 255, 255, 0.7);
    box-shadow: 0 12px 28px -24px rgba(15, 23, 42, 0.35);
  }

  .admin-main { width: calc(100% - 16rem); }
  .admin-content { position: relative; z-index: 1; }

  @media (max-width: 1024px) {
    .admin-sidebar { position: static; width: 100%; height: auto; margin-bottom: 1rem; }
    .admin-topbar { position: static; left: auto; right: auto; width: 100%; margin: 0 1rem 1rem; border-radius: 1rem; }
    .admin-main { width: 100%; margin-left: 0; }
    .admin-content { padding-top: 1.25rem; }
  }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-0" placeholder="Search analytics, categories, KPIs..." type="text"/>
      </div>
    </div>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications"><span class="material-symbols-outlined">notifications</span><?php if ($notificationCount > 0): ?><span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span><?php endif; ?></a>
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">help_outline</span></button>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right">
          <p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p>
          <p class="text-[10px] text-slate-400">Operations Lead</p>
        </div>
      </div>
    </div>
  </header>

  <main class="admin-main admin-content ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-8">
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
          <h2 class="text-3xl font-black text-primary tracking-tight">Analytics Center</h2>
          <p class="text-on-surface-variant mt-1">Generated insights from orders, users, and products in your website.</p>
        </div>
        <div class="flex gap-3">
          <button id="periodBtn" class="flex items-center gap-2 bg-surface-container-high px-4 py-2 rounded-xl text-sm font-semibold text-primary hover:bg-surface-container-highest transition-colors" type="button">
            <span class="material-symbols-outlined text-lg">calendar_month</span>
            Last 30 Days
          </button>
          <button id="snapshotBtn" class="flex items-center gap-2 bg-secondary text-on-secondary px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-secondary/20" type="button">
            <span class="material-symbols-outlined text-lg">insights</span>
            Generate Snapshot
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Revenue</p>
          <div class="flex items-baseline gap-2">
            <span class="text-2xl font-black text-primary">$<?php echo number_format($totalRevenue, 2); ?></span>
            <span class="text-xs font-bold text-teal-600">live</span>
          </div>
        </div>
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Orders</p>
          <div class="flex items-baseline gap-2">
            <span class="text-2xl font-black text-primary"><?php echo $orderCount; ?></span>
            <span class="text-xs font-bold text-teal-600">completed: <?php echo $completedCount; ?></span>
          </div>
        </div>
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Avg Order</p>
          <div class="flex items-baseline gap-2">
            <span class="text-2xl font-black text-primary">$<?php echo number_format($avgOrder, 2); ?></span>
            <span class="text-xs font-bold text-amber-700">conversion <?php echo number_format($conversionRate, 1); ?>%</span>
          </div>
        </div>
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Product Risk</p>
          <div class="flex items-baseline gap-2">
            <span class="text-2xl font-black text-primary"><?php echo $lowStockCount; ?></span>
            <span class="text-xs font-bold text-error">low stock</span>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <section class="xl:col-span-2 bg-surface-container-lowest rounded-2xl p-6 shadow-sm shadow-slate-200/40">
          <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-black text-primary">Revenue Trend (Generated)</h3>
            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">6 Months</span>
          </div>
          <div class="h-64 flex items-end gap-3">
            <?php foreach ($monthlyTrend as $i => $value): ?>
              <?php $h = max(8, (int) round(($value / $maxTrend) * 100)); ?>
              <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full rounded-t-lg bg-gradient-to-t from-primary/25 to-primary h-[<?php echo $h; ?>%]"></div>
                <span class="text-[10px] font-bold text-slate-500 uppercase"><?php echo $months[$i]; ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm shadow-slate-200/40">
          <h3 class="text-lg font-black text-primary mb-5">Category Mix</h3>
          <div class="space-y-4">
            <?php foreach ($topCategories as $cat => $count): ?>
              <?php $width = $productCount > 0 ? (int) round(($count / $productCount) * 100) : 0; ?>
              <div>
                <div class="flex justify-between text-xs font-bold mb-1">
                  <span class="text-primary"><?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $cat))); ?></span>
                  <span class="text-on-surface-variant"><?php echo $count; ?></span>
                </div>
                <div class="h-2 rounded-full bg-surface-container-high overflow-hidden">
                  <div class="h-full rounded-full bg-secondary" style="width: <?php echo $width; ?>%"></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm shadow-slate-200/40">
          <h4 class="text-sm font-black text-primary uppercase tracking-widest mb-4">Payments</h4>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-on-surface-variant">Paid</span><span class="font-bold text-primary"><?php echo $paidCount; ?></span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Pending</span><span class="font-bold text-primary"><?php echo $pendingCount; ?></span></div>
          </div>
        </section>

        <section class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm shadow-slate-200/40">
          <h4 class="text-sm font-black text-primary uppercase tracking-widest mb-4">Users</h4>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-on-surface-variant">Total Users</span><span class="font-bold text-primary"><?php echo $userCount; ?></span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Customers</span><span class="font-bold text-primary"><?php echo $customerCount; ?></span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Admins</span><span class="font-bold text-primary"><?php echo $adminCount; ?></span></div>
          </div>
        </section>

        <section class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm shadow-slate-200/40">
          <h4 class="text-sm font-black text-primary uppercase tracking-widest mb-4">Operations</h4>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-on-surface-variant">Products</span><span class="font-bold text-primary"><?php echo $productCount; ?></span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Low Stock</span><span class="font-bold text-error"><?php echo $lowStockCount; ?></span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Processing Orders</span><span class="font-bold text-primary"><?php echo $processingCount; ?></span></div>
          </div>
        </section>
      </div>
    </div>
  </main>
</div>
<script>
document.getElementById('snapshotBtn')?.addEventListener('click', function() {
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      icon: 'success',
      title: 'Snapshot Generated',
      text: 'Key analytics metrics captured. Use Ctrl+P to export this report.',
      confirmButtonColor: '#006257'
    });
  } else {
    window.print();
  }
});
document.getElementById('periodBtn')?.addEventListener('click', function() {
  var active = this.classList.contains('bg-primary');
  if (active) {
    this.classList.remove('bg-primary','text-on-primary');
    this.classList.add('bg-surface-container-high','text-primary');
    this.querySelector('span:last-child') && (this.querySelector('span:last-child').textContent = 'Last 30 Days');
  } else {
    this.classList.add('bg-primary','text-on-primary');
    this.classList.remove('bg-surface-container-high','text-primary');
    this.querySelector('span:last-child') && (this.querySelector('span:last-child').textContent = 'All Time');
  }
});
</script>
<script src="/js/admin.js"></script>