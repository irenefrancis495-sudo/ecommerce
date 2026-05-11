<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'shipping';

function readJsonArray(string $path): array {
    if (!file_exists($path)) {
        return [];
    }

    $decoded = json_decode((string) file_get_contents($path), true);
    return is_array($decoded) ? $decoded : [];
}

$orders = readJsonArray(__DIR__ . '/../../data/orders.json');
usort($orders, function ($a, $b) {
    $idA = (int) ($a['id'] ?? 0);
    $idB = (int) ($b['id'] ?? 0);
    return $idB <=> $idA;
});

$totalOrders = count($orders);
$inTransit = 0;
$delivered = 0;
$pending = 0;
$shippingRevenue = 0.0;

foreach ($orders as $order) {
    $status = strtolower((string) ($order['status'] ?? 'pending'));
    $shippingRevenue += (float) ($order['shipping_cost'] ?? 0);

    if (in_array($status, ['shipped', 'on_delivery', 'processing'], true)) {
        $inTransit++;
    } elseif (in_array($status, ['delivered', 'completed'], true)) {
        $delivered++;
    } else {
        $pending++;
    }
}

$displayOrders = array_slice($orders, 0, 20);

function shippingStatusPill(string $status): string {
    $status = strtolower($status);

    if (in_array($status, ['delivered', 'completed'], true)) {
        return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold"><span class="material-symbols-outlined text-[14px]">check_circle</span>Delivered</span>';
    }

    if (in_array($status, ['shipped', 'on_delivery', 'processing'], true)) {
        return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-[11px] font-bold"><span class="material-symbols-outlined text-[14px]">local_shipping</span>In Transit</span>';
    }

    return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold"><span class="material-symbols-outlined text-[14px]">schedule</span>Pending</span>';
}
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

  .admin-topbar {
    border-bottom: 1px solid rgba(255, 255, 255, 0.7);
    box-shadow: 0 12px 28px -24px rgba(15, 23, 42, 0.35);
  }

  .admin-main { width: calc(100% - 16rem); }
  .admin-content { position: relative; z-index: 1; }

  @media (max-width: 1024px) {
    .admin-topbar { position: static; left: auto; right: auto; width: 100%; margin: 0 1rem 1rem; border-radius: 1rem; }
    .admin-main { width: 100%; margin-left: 0; }
    .admin-content { padding-top: 1.25rem; }
  }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <h2 class="font-black text-primary text-xl tracking-tight flex items-center gap-2">
        <span class="material-symbols-outlined">local_shipping</span>
        Shipping Operations
      </h2>
    </div>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications">
        <span class="material-symbols-outlined">notifications</span>
        <?php if ($notificationCount > 0): ?>
          <span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span>
        <?php endif; ?>
      </a>
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
      <section class="rounded-3xl bg-white/80 border border-white/65 shadow-xl shadow-slate-300/25 p-7">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
          <div>
            <p class="text-[11px] tracking-[0.24em] uppercase text-slate-500 font-bold mb-2">Logistics Overview</p>
            <h3 class="text-3xl font-black text-primary tracking-tight mb-2">Shipping Command Center</h3>
            <p class="text-slate-500 max-w-2xl">Monitor package movement, pending fulfillment, and delivery completion using live order records.</p>
          </div>
          <div class="flex gap-3">
            <a href="/admin/orders" class="rounded-2xl bg-primary text-white px-5 py-2.5 text-sm font-bold hover:opacity-95 transition-opacity">Open Orders</a>
            <a href="/admin/reports" class="rounded-2xl bg-white border border-slate-200 px-5 py-2.5 text-sm font-bold text-primary hover:bg-slate-50 transition-colors">View Analytics</a>
          </div>
        </div>
      </section>

      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <p class="text-xs uppercase tracking-wide text-slate-400 font-bold">Total Shipments</p>
          <p class="text-3xl font-black text-primary mt-2"><?php echo number_format($totalOrders); ?></p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <p class="text-xs uppercase tracking-wide text-slate-400 font-bold">In Transit</p>
          <p class="text-3xl font-black text-blue-600 mt-2"><?php echo number_format($inTransit); ?></p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <p class="text-xs uppercase tracking-wide text-slate-400 font-bold">Delivered</p>
          <p class="text-3xl font-black text-emerald-600 mt-2"><?php echo number_format($delivered); ?></p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <p class="text-xs uppercase tracking-wide text-slate-400 font-bold">Shipping Revenue</p>
          <p class="text-3xl font-black text-amber-600 mt-2">$<?php echo number_format($shippingRevenue, 2); ?></p>
        </div>
      </div>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h4 class="text-lg font-black text-primary tracking-tight">Recent Shipping Queue</h4>
          <span class="text-xs text-slate-500 font-semibold">Showing <?php echo count($displayOrders); ?> of <?php echo $totalOrders; ?></span>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50/70 text-slate-500 text-xs uppercase tracking-wider">
                <th class="px-6 py-3 font-bold">Order</th>
                <th class="px-6 py-3 font-bold">Customer</th>
                <th class="px-6 py-3 font-bold">Status</th>
                <th class="px-6 py-3 font-bold">Shipping</th>
                <th class="px-6 py-3 font-bold">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($displayOrders)): ?>
                <tr>
                  <td class="px-6 py-10 text-center text-slate-500" colspan="5">No shipping records found.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($displayOrders as $order): ?>
                  <?php
                    $orderNumber = (string) ($order['order_number'] ?? ('ORD-' . (int) ($order['id'] ?? 0)));
                    $customer = trim((string) ($order['user_name'] ?? '')); 
                    if ($customer === '') {
                        $customer = trim((string) ($order['user_email'] ?? 'Guest Customer'));
                    }
                    $status = (string) ($order['status'] ?? 'pending');
                  ?>
                  <tr class="border-t border-slate-100 hover:bg-slate-50/60 transition-colors">
                    <td class="px-6 py-4 font-semibold text-slate-800"><?php echo htmlspecialchars($orderNumber); ?></td>
                    <td class="px-6 py-4 text-slate-600"><?php echo htmlspecialchars($customer); ?></td>
                    <td class="px-6 py-4"><?php echo shippingStatusPill($status); ?></td>
                    <td class="px-6 py-4 font-semibold text-slate-700">$<?php echo number_format((float) ($order['shipping_cost'] ?? 0), 2); ?></td>
                    <td class="px-6 py-4 font-bold text-primary">$<?php echo number_format((float) ($order['total'] ?? 0), 2); ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>
</div>
