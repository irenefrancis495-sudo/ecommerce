<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';
$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'orders';

// Load data from JSON files
function readJsonArray(string $path): array {
    if (!file_exists($path)) {
        return [];
    }
    $data = json_decode((string) file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

$orders = readJsonArray(__DIR__ . '/../../data/orders.json');
$users = readJsonArray(__DIR__ . '/../../data/users.json');
$orderItems = readJsonArray(__DIR__ . '/../../data/order_items.json');

// Create user lookup
$userLookup = [];
foreach ($users as $user) {
    $userLookup[$user['id']] = $user;
}

// Calculate statistics
$orderCount = count($orders);
$totalRevenue = 0.0;
$paidCount = 0;
$pendingCount = 0;
$completedCount = 0;
$processingCount = 0;

foreach ($orders as $order) {
    $totalRevenue += (float) ($order['total'] ?? 0);

    $paymentStatus = strtolower((string) ($order['payment_status'] ?? ''));
    if ($paymentStatus === 'paid') {
        $paidCount++;
    } else {
        $pendingCount++;
    }

    $status = strtolower((string) ($order['status'] ?? ''));
    if ($status === 'completed' || $status === 'delivered') {
        $completedCount++;
    }
    if ($status === 'processing' || $status === 'on_delivery' || $status === 'shipped') {
        $processingCount++;
    }
}

// Sort orders by ID descending (newest first)
usort($orders, function($a, $b) {
    return (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0);
});
?>

<style>
    body { font-family: 'Manrope', sans-serif; }
    h1, h2, h3, .headline { font-family: 'Epilogue', sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

    body {
        background:
            radial-gradient(circle at 10% 0%, rgba(20, 184, 166, 0.08) 0%, transparent 30%),
            radial-gradient(circle at 100% 20%, rgba(245, 158, 11, 0.08) 0%, transparent 35%),
            #f5f7fb;
    }

    .admin-shell {
        position: relative;
    }

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

    .admin-main {
        width: calc(100% - 16rem);
    }

    .admin-content {
        position: relative;
        z-index: 1;
    }

    @media (max-width: 1024px) {
        .admin-sidebar {
            position: static;
            width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }

        .admin-topbar {
            position: static;
            left: auto;
            right: auto;
            width: 100%;
            margin: 0 1rem 1rem;
            border-radius: 1rem;
        }

        .admin-main {
            width: 100%;
            margin-left: 0;
        }

        .admin-content {
            padding-top: 1.25rem;
        }
    }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
    <!-- SideNavBar -->
    <?php require_once __DIR__ . '/_sidebar.php'; ?>

    <!-- TopNavBar -->
    <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
        <div class="flex items-center gap-6 w-1/2">
            <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input id="ordSearch" class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm font-['Manrope'] focus:ring-0" placeholder="Search orders, customers..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications">
                <span class="material-symbols-outlined">notifications</span>
                <?php if ($notificationCount > 0): ?>
                <span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span>
                <?php endif; ?>
            </a>
            <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button">
                <span class="material-symbols-outlined">help_outline</span>
            </button>
            <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
                <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
                <div class="text-right">
                    <p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p>
                    <p class="text-[10px] text-slate-400">Operations Lead</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="admin-main ml-64 min-h-screen">
        <div class="admin-content pt-24 p-8">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black text-primary tracking-tight font-headline flex items-center gap-2">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings:'FILL' 1">shopping_cart</span>
                        Order Management
                    </h2>
                    <p class="text-slate-500 mt-2 font-body">Track, manage, and process your transactions</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex bg-white border border-slate-200 rounded-lg p-1 gap-0.5">
                        <button data-filter="all" class="ord-filter-tab px-3.5 py-1.5 rounded-md text-xs font-bold bg-primary text-white shadow-sm transition-all" type="button">All Orders</button>
                        <button data-filter="pending" class="ord-filter-tab px-3.5 py-1.5 rounded-md text-xs font-bold text-slate-600 hover:text-primary hover:bg-slate-50 transition-all" type="button">Pending</button>
                        <button data-filter="shipped" class="ord-filter-tab px-3.5 py-1.5 rounded-md text-xs font-bold text-slate-600 hover:text-primary hover:bg-slate-50 transition-all" type="button">Shipped</button>
                    </div>
                    <button id="last30DaysBtn" class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-lg text-sm font-semibold text-primary hover:bg-slate-50 transition-all" type="button">
                        <span class="material-symbols-outlined text-base">calendar_month</span>
                        Last 30 Days
                    </button>
                    <button id="exportOrdersBtn" class="flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-6 py-2 rounded-lg text-sm font-bold shadow-lg shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/30 transition-all" type="button">
                        <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">download</span>
                        Export
                    </button>
                </div>
            </div>

            <!-- KPI Cards -->
            <style>
                .kpi-card { transition: transform .18s ease, box-shadow .18s ease; }
                .kpi-card:hover { transform: translateY(-3px); box-shadow: 0 20px 36px -18px rgba(15,23,42,.16); }
            </style>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-blue-600 text-2xl" style="font-variation-settings:'FILL' 1">shopping_cart</span>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-primary leading-none"><?php echo number_format($orderCount); ?></p>
                        <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Total Orders</p>
                    </div>
                </div>
                <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-emerald-600 text-2xl" style="font-variation-settings:'FILL' 1">trending_up</span>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-emerald-600 leading-none">$<?php echo number_format($totalRevenue, 0); ?></p>
                        <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Revenue</p>
                    </div>
                </div>
                <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-purple-600 text-2xl" style="font-variation-settings:'FILL' 1">paid</span>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-purple-600 leading-none"><?php echo number_format($paidCount); ?></p>
                        <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Paid</p>
                    </div>
                </div>
                <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-teal-600 text-2xl" style="font-variation-settings:'FILL' 1">check_circle</span>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-teal-600 leading-none"><?php echo number_format($completedCount); ?></p>
                        <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Completed</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Order ID</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Amount</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Payment</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Shipment</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="material-symbols-outlined text-5xl text-slate-300">shopping_cart</span>
                                        <p class="text-sm font-medium text-slate-600">No orders found</p>
                                        <p class="text-xs text-slate-500">Orders will appear here once customers place them.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                <?php
                                    $userId = $order['user_id'] ?? 0;
                                    $user = $userLookup[$userId] ?? null;
                                    $customerName = trim((string) ($order['user_name'] ?? ''));
                                    if ($customerName === '' && $user) {
                                        $customerName = trim((string) (($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')));
                                    }
                                    if ($customerName === '' && $user) {
                                        $customerName = (string) ($user['username'] ?? '');
                                    }
                                    if ($customerName === '') {
                                        $customerName = 'Unknown Customer';
                                    }
                                    $customerEmail = (string) ($order['user_email'] ?? ($user['email'] ?? ''));
                                    $customerInitials = strtoupper(substr($customerName, 0, 1) . substr(strrchr(' ' . $customerName, ' '), 1, 1));

                                    $orderNumber = $order['order_number'] ?? 'ORD-' . ($order['id'] ?? '000');
                                    $total = (float) ($order['total'] ?? 0);
                                    $paymentStatus = strtolower($order['payment_status'] ?? '');
                                    $orderStatus = strtolower($order['status'] ?? '');
                                    $createdDate = !empty($order['created_at'])
                                        ? date('M d, Y', strtotime((string) $order['created_at']))
                                        : 'N/A';
                                ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group ord-row"
                                    data-status="<?php echo htmlspecialchars($orderStatus); ?>"
                                    data-id="<?php echo (int)($order['id'] ?? 0); ?>"
                                    data-order-no="<?php echo htmlspecialchars($orderNumber); ?>"
                                    data-customer="<?php echo htmlspecialchars(strtolower($customerName)); ?>"
                                    data-customer-label="<?php echo htmlspecialchars($customerName); ?>"
                                    data-total="$<?php echo number_format($total, 2); ?>"
                                    data-payment="<?php echo htmlspecialchars($paymentStatus); ?>"
                                    data-email="<?php echo htmlspecialchars($customerEmail); ?>"
                                    data-date="<?php echo htmlspecialchars($createdDate); ?>"
                                    data-created-at="<?php echo htmlspecialchars((string)($order['created_at'] ?? '')); ?>">
                                    <td class="px-6 py-4"><span class="text-sm font-black text-primary">#<?php echo htmlspecialchars($orderNumber); ?></span></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-500 to-primary flex items-center justify-center text-white text-xs font-black"><?php echo htmlspecialchars($customerInitials); ?></div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars($customerName); ?></p>
                                                <p class="text-[11px] text-slate-500"><?php echo htmlspecialchars($customerEmail); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600"><?php echo htmlspecialchars($createdDate); ?></td>
                                    <td class="px-6 py-4 text-sm font-black text-primary">$<?php echo number_format($total, 2); ?></td>
                                    <td class="px-6 py-4 ord-payment-cell">
                                        <?php if ($paymentStatus === 'paid'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Paid</span>
                                        <?php elseif ($paymentStatus === 'pending'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-orange-50 text-orange-700 text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-orange-600"></span> Pending</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-red-50 text-red-700 text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Failed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 ord-status-cell">
                                        <?php if ($orderStatus === 'completed' || $orderStatus === 'delivered'): ?>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-teal-50 text-teal-700 text-[11px] font-bold"><span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">local_shipping</span> Delivered</span>
                                        <?php elseif ($orderStatus === 'processing' || $orderStatus === 'shipped' || $orderStatus === 'on_delivery'): ?>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-[11px] font-bold"><span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">package_2</span> <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $orderStatus))); ?></span>
                                        <?php elseif ($orderStatus === 'pending'): ?>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-amber-50 text-amber-700 text-[11px] font-bold"><span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">schedule</span> Pending</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-[11px] font-bold"><span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">block</span> On Hold</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button class="ord-details text-[11px] font-bold text-primary uppercase tracking-widest hover:text-teal-700 transition-colors"
                                            type="button"
                                            data-id="<?php echo (int)($order['id'] ?? 0); ?>"
                                            data-order-no="<?php echo htmlspecialchars($orderNumber); ?>"
                                            data-customer="<?php echo htmlspecialchars($customerName); ?>"
                                            data-email="<?php echo htmlspecialchars($customerEmail); ?>"
                                            data-total="$<?php echo number_format($total, 2); ?>"
                                            data-payment="<?php echo htmlspecialchars($paymentStatus); ?>"
                                            data-status="<?php echo htmlspecialchars($orderStatus); ?>"
                                            data-date="<?php echo htmlspecialchars($createdDate); ?>">Details</button>
                                        <div class="relative inline-block">
                                            <button class="ord-more-trigger bg-slate-100 p-2 rounded-lg text-slate-600 hover:bg-primary hover:text-white transition-all" type="button"
                                                data-id="<?php echo (int)($order['id'] ?? 0); ?>">
                                                <span class="material-symbols-outlined text-base">more_vert</span>
                                            </button>
                                            <div class="ord-more-menu hidden absolute right-0 top-10 bg-white rounded-xl shadow-xl border border-slate-200 z-20 w-48 py-1 text-sm">
                                                <button class="ord-details-menu w-full text-left px-4 py-2.5 hover:bg-slate-50 text-primary font-semibold flex items-center gap-2 transition-colors"
                                                    data-id="<?php echo (int)($order['id'] ?? 0); ?>"
                                                    data-order-no="<?php echo htmlspecialchars($orderNumber); ?>"
                                                    data-customer="<?php echo htmlspecialchars($customerName); ?>"
                                                    data-email="<?php echo htmlspecialchars($customerEmail); ?>"
                                                    data-total="$<?php echo number_format($total, 2); ?>"
                                                    data-payment="<?php echo htmlspecialchars($paymentStatus); ?>"
                                                    data-status="<?php echo htmlspecialchars($orderStatus); ?>"
                                                    data-date="<?php echo htmlspecialchars($createdDate); ?>">
                                                    <span class="material-symbols-outlined text-sm">visibility</span>View Details
                                                </button>
                                                <button class="ord-status-update w-full text-left px-4 py-2.5 hover:bg-slate-50 text-primary font-semibold flex items-center gap-2 transition-colors"
                                                    data-id="<?php echo (int)($order['id'] ?? 0); ?>"
                                                    data-status="<?php echo htmlspecialchars($orderStatus); ?>">
                                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">local_shipping</span>Update Status
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-slate-50 flex items-center justify-between border-t border-slate-100">
                    <p id="ordVisibleCount" class="text-xs font-bold text-slate-500">Showing <?php echo count($orders); ?> order<?php echo count($orders) !== 1 ? 's' : ''; ?></p>
                    <div class="flex items-center gap-2">
                        <button class="p-2 rounded-lg hover:bg-slate-100 transition-colors disabled:opacity-30" disabled type="button"><span class="material-symbols-outlined text-lg">chevron_left</span></button>
                        <span class="text-xs font-black text-primary px-3">Page 1 of 1</span>
                        <button class="p-2 rounded-lg hover:bg-slate-100 transition-colors disabled:opacity-30" disabled type="button"><span class="material-symbols-outlined text-lg">chevron_right</span></button>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-primary to-teal-600 p-8 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-6 relative z-10 shadow-lg shadow-primary/20">
                <div class="space-y-2 text-center md:text-left">
                    <h3 class="text-white text-xl font-black">Order Fulfillment Optimization</h3>
                    <p class="text-primary-100 text-sm max-w-lg">Our system identified that shipments to Southern regions are currently delayed. Switch to the priority courier for 12 orders to maintain SLA.</p>
                </div>
                <button id="resolveNowBtn" class="bg-white text-primary px-8 py-3 rounded-lg font-bold text-sm uppercase tracking-widest hover:shadow-xl hover:shadow-black/10 transition-all whitespace-nowrap" type="button">
                    Resolve Now
                </button>
            </div>
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-secondary/20 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
            </div>
        </div>
        </div>
    </main>
</div>
<!-- Order Details Modal -->
<div id="ordDetailsModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 items-center justify-center">
    <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md mx-4">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-editorial font-black text-primary">Order Details</h3>
            <button id="ordDetailsClose" class="text-slate-400 hover:text-primary" type="button"><span class="material-symbols-outlined">close</span></button>
        </div>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between"><dt class="text-on-surface-variant font-semibold">Order #</dt><dd id="d-order-no" class="font-bold text-primary"></dd></div>
            <div class="flex justify-between"><dt class="text-on-surface-variant font-semibold">Customer</dt><dd id="d-customer" class="font-bold"></dd></div>
            <div class="flex justify-between"><dt class="text-on-surface-variant font-semibold">Email</dt><dd id="d-email" class="text-on-surface-variant"></dd></div>
            <div class="flex justify-between"><dt class="text-on-surface-variant font-semibold">Date</dt><dd id="d-date" class="text-on-surface-variant"></dd></div>
            <div class="flex justify-between"><dt class="text-on-surface-variant font-semibold">Total</dt><dd id="d-total" class="font-black text-primary text-base"></dd></div>
            <div class="flex justify-between"><dt class="text-on-surface-variant font-semibold">Payment</dt><dd id="d-payment" class="capitalize"></dd></div>
            <div class="flex justify-between items-center"><dt class="text-on-surface-variant font-semibold">Status</dt><dd id="d-status" class="capitalize"></dd></div>
        </dl>
        <div class="mt-6 pt-4 border-t border-slate-100 space-y-2">
            <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">Update Status</p>
            <div class="flex flex-wrap gap-2" id="statusBtns">
                <?php foreach (['pending','processing','shipped','delivered','completed','cancelled'] as $s): ?>
                <button class="status-choice px-3 py-1.5 rounded-full text-xs font-bold border border-outline-variant text-primary hover:bg-primary hover:text-on-primary transition-colors" data-status="<?php echo $s; ?>"><?php echo ucfirst($s); ?></button>
                <?php endforeach; ?>
            </div>
        </div>
        <button id="ordDetailsClose2" class="mt-4 w-full py-2.5 rounded-xl bg-surface-container-high text-primary font-bold text-sm hover:bg-surface-container-highest transition-colors" type="button">Close</button>
    </div>
</div>

<script>
(function () {
    var activeOrdFilter = 'all';
    var activeDateFilter = false;
    var ordSearch = document.getElementById('ordSearch');

    function statusText(status) {
        return (status || '').replace(/_/g, ' ').replace(/\b\w/g, function(chr) { return chr.toUpperCase(); });
    }

    function getStatusBadge(status) {
        if (status === 'completed' || status === 'delivered') {
            return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-bold"><span class="material-symbols-outlined text-[12px]">local_shipping</span> Delivered</span>';
        }
        if (status === 'processing' || status === 'shipped' || status === 'on_delivery') {
            return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] font-bold"><span class="material-symbols-outlined text-[12px]">package_2</span> ' + statusText(status) + '</span>';
        }
        if (status === 'pending') {
            return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant text-[10px] font-bold"><span class="material-symbols-outlined text-[12px]">schedule</span> Pending</span>';
        }
        return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[10px] font-bold"><span class="material-symbols-outlined text-[12px]">block</span> On Hold</span>';
    }

    function syncRowStatusUI(orderId, newStatus) {
        var row = document.querySelector('.ord-row[data-id="' + orderId + '"]');
        if (!row) return;
        row.dataset.status = newStatus;
        var statusCell = row.querySelector('.ord-status-cell');
        if (statusCell) {
            statusCell.innerHTML = getStatusBadge(newStatus);
        }
        row.querySelectorAll('.ord-details, .ord-details-menu, .ord-status-update').forEach(function(btn) {
            btn.dataset.status = newStatus;
        });
    }

    function filterOrders() {
        var q = ordSearch ? ordSearch.value.toLowerCase().trim() : '';
        var thirtyDaysAgo = Date.now() - (30 * 24 * 60 * 60 * 1000);
        var visibleCount = 0;
        document.querySelectorAll('.ord-row').forEach(function(row) {
            var status   = row.dataset.status   || '';
            var customer = row.dataset.customer || '';
            var orderNo  = (row.dataset.orderNo || '').toLowerCase();
            var matchSearch = !q || customer.includes(q) || orderNo.includes(q) || status.includes(q);
            var matchFilter;
            if      (activeOrdFilter === 'all')     { matchFilter = true; }
            else if (activeOrdFilter === 'pending')  { matchFilter = status === 'pending'; }
            else if (activeOrdFilter === 'shipped')  { matchFilter = status === 'shipped' || status === 'processing' || status === 'on_delivery'; }
            var matchDate = true;
            if (activeDateFilter) {
                var rawDate = row.dataset.createdAt || '';
                var d = rawDate ? new Date(rawDate) : null;
                matchDate = !!(d && !isNaN(d.getTime()) && d.getTime() >= thirtyDaysAgo);
            }
            var visible = matchSearch && matchFilter && matchDate;
            row.style.display = visible ? '' : 'none';
            if (visible) visibleCount++;
        });
        var countEl = document.getElementById('ordVisibleCount');
        if (countEl) countEl.textContent = 'Showing ' + visibleCount + ' order' + (visibleCount !== 1 ? 's' : '');
    }

    if (ordSearch) { ordSearch.addEventListener('input', filterOrders); }

    document.getElementById('last30DaysBtn')?.addEventListener('click', function() {
        activeDateFilter = !activeDateFilter;
        if (activeDateFilter) {
            this.classList.add('bg-primary', 'text-on-primary');
            this.classList.remove('bg-surface-container-high', 'text-primary', 'hover:bg-surface-container-highest');
        } else {
            this.classList.remove('bg-primary', 'text-on-primary');
            this.classList.add('bg-surface-container-high', 'text-primary', 'hover:bg-surface-container-highest');
        }
        filterOrders();
    });

    document.querySelectorAll('.ord-filter-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            activeOrdFilter = this.dataset.filter;
            document.querySelectorAll('.ord-filter-tab').forEach(function(b) {
                b.classList.remove('bg-primary', 'text-on-primary', 'shadow-sm');
                b.classList.add('text-on-surface-variant');
            });
            this.classList.add('bg-primary', 'text-on-primary', 'shadow-sm');
            this.classList.remove('text-on-surface-variant');
            filterOrders();
        });
    });

    // More menu toggle
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.ord-more-trigger') && !e.target.closest('.ord-more-menu')) {
            document.querySelectorAll('.ord-more-menu').forEach(function(m) { m.classList.add('hidden'); });
        }
        var t = e.target.closest('.ord-more-trigger');
        if (t) {
            var menu = t.parentElement.querySelector('.ord-more-menu');
            if (menu) {
                document.querySelectorAll('.ord-more-menu').forEach(function(m) { m.classList.add('hidden'); });
                menu.classList.remove('hidden');
            }
        }
    });

    // Order details modal
    var currentOrderId = null;
    function openOrderDetails(btn) {
        document.querySelectorAll('.ord-more-menu').forEach(function(m) { m.classList.add('hidden'); });
        currentOrderId = btn.dataset.id;
        document.getElementById('d-order-no').textContent = btn.dataset.orderNo || '';
        document.getElementById('d-customer').textContent  = btn.dataset.customer || btn.dataset.customerLabel || '';
        document.getElementById('d-email').textContent    = btn.dataset.email || '';
        document.getElementById('d-date').textContent     = btn.dataset.date || '';
        document.getElementById('d-total').textContent    = btn.dataset.total || '';
        document.getElementById('d-payment').textContent  = statusText(btn.dataset.payment || '');
        document.getElementById('d-status').textContent   = statusText(btn.dataset.status || '');
        document.querySelectorAll('.status-choice').forEach(function(choice) {
            if (choice.dataset.status === btn.dataset.status) {
                choice.classList.add('bg-primary', 'text-on-primary');
                choice.classList.remove('border-outline-variant', 'text-primary');
            } else {
                choice.classList.remove('bg-primary', 'text-on-primary');
                choice.classList.add('border-outline-variant', 'text-primary');
            }
        });
        var m = document.getElementById('ordDetailsModal');
        m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeOrderDetails() {
        var m = document.getElementById('ordDetailsModal');
        m.classList.add('hidden'); m.classList.remove('flex');
        currentOrderId = null;
    }
    document.addEventListener('click', function(e) {
        var db = e.target.closest('.ord-details, .ord-details-menu');
        if (db) openOrderDetails(db);
    });
    document.getElementById('ordDetailsClose')?.addEventListener('click', closeOrderDetails);
    document.getElementById('ordDetailsClose2')?.addEventListener('click', closeOrderDetails);
    document.getElementById('ordDetailsModal')?.addEventListener('click', function(e) { if (e.target === this) closeOrderDetails(); });

    // Status update from modal
    document.querySelectorAll('.status-choice').forEach(function(btn) {
        btn.addEventListener('click', async function() {
            if (!currentOrderId) return;
            var newStatus = this.dataset.status;
            try {
                var r = await fetch('/api/orders.php', {
                    method: 'POST', headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({action: 'update_status', id: parseInt(currentOrderId), status: newStatus})
                });
                var data = await r.json();
                if (data.status === 'success') {
                    document.getElementById('d-status').textContent = statusText(newStatus);
                    syncRowStatusUI(currentOrderId, newStatus);
                    // Update all status choice buttons with proper styling
                    document.querySelectorAll('.status-choice').forEach(function(b) {
                        if (b.dataset.status === newStatus) {
                            b.classList.add('bg-primary', 'text-on-primary');
                            b.classList.remove('border-outline-variant', 'text-primary');
                        } else {
                            b.classList.remove('bg-primary', 'text-on-primary');
                            b.classList.add('border-outline-variant', 'text-primary');
                        }
                    });
                    filterOrders();
                    
                    // Show success notification
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order status updated',
                            text: 'Admin successfully changed the order status to ' + statusText(newStatus),
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: function(toast) {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                    }
                } else {
                    // Show error notification
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Status update failed',
                            text: data.message || 'Admin could not change the order status.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: function(toast) {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                    }
                }
            } catch (err) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Status update failed',
                        text: 'Unable to update order status. Please try again.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: function(toast) {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });
                }
            }
        });
    });

    // Update status from more menu
    document.addEventListener('click', function(e) {
        var usb = e.target.closest('.ord-status-update');
        if (!usb) return;
        document.querySelectorAll('.ord-more-menu').forEach(function(m) { m.classList.add('hidden'); });
        // Simulate openOrderDetails with the row data
        var row = usb.closest('.ord-row');
        if (row) {
            var fakeBtn = {dataset: {
                id: usb.dataset.id, orderNo: row.dataset.orderNo || '', customer: row.dataset.customerLabel || row.dataset.customer || '',
                email: row.dataset.email || '', total: row.dataset.total || '',
                payment: row.dataset.payment || '', status: usb.dataset.status || '', date: row.dataset.date || ''
            }};
            openOrderDetails(fakeBtn);
        }
    });

    // Export CSV
    document.getElementById('exportOrdersBtn')?.addEventListener('click', function() {
        var rows = document.querySelectorAll('.ord-row:not([style*="display: none"])');
        var csv  = ['ID,Order No,Customer,Total,Payment,Status,Date'];
        rows.forEach(function(row) {
            var orderNo  = (row.dataset.orderNo  || '').replace(/"/g, '""');
            var customer = (row.dataset.customer || '').replace(/"/g, '""');
            csv.push(row.dataset.id + ',"' + orderNo + '","' + customer + '",' +
                row.dataset.total + ',' + row.dataset.payment + ',' + row.dataset.status + ',' + row.dataset.date);
        });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv.join('\n')], {type: 'text/csv'}));
        a.download = 'orders.csv'; a.click();
    });

    // Resolve Now - Update priority orders
    document.getElementById('resolveNowBtn')?.addEventListener('click', async function() {
        if (typeof Swal === 'undefined') {
            alert('Optimization applied: 12 orders routed to priority courier.');
            return;
        }
        
        // Show loading state
        Swal.fire({
            title: 'Processing...',
            text: 'Routing orders to priority courier',
            icon: 'info',
            allowOutsideClick: false,
            didOpen: async () => {
                Swal.showLoading();
                
                try {
                    // Get all pending/processing orders
                    var ordersToUpdate = [];
                    document.querySelectorAll('.ord-row').forEach(function(row) {
                        var status = row.dataset.status || '';
                        if ((status === 'pending' || status === 'processing' || status === 'on_delivery') && ordersToUpdate.length < 12) {
                            ordersToUpdate.push({
                                id: parseInt(row.dataset.id),
                                element: row
                            });
                        }
                    });
                    
                    if (ordersToUpdate.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'No Orders to Optimize',
                            text: 'All orders are already in optimal routing.',
                            confirmButtonColor: '#006257'
                        });
                        return;
                    }
                    
                    // Update all orders to "shipped" status via API
                    var updateCount = 0;
                    for (var i = 0; i < ordersToUpdate.length; i++) {
                        try {
                            var r = await fetch('/api/orders.php', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/json'},
                                body: JSON.stringify({
                                    action: 'update_status',
                                    id: ordersToUpdate[i].id,
                                    status: 'shipped'
                                })
                            });
                            var data = await r.json();
                            if (data.status === 'success') {
                                updateCount++;
                                syncRowStatusUI(ordersToUpdate[i].id, 'shipped');
                            }
                        } catch (e) {
                            console.log('Update failed for order ' + ordersToUpdate[i].id);
                        }
                    }
                    
                    filterOrders();
                    
                    // Show final success
                    Swal.fire({
                        icon: 'success',
                        title: 'Optimization Applied',
                        text: updateCount + ' orders successfully routed to priority courier. Expected delivery restored within SLA.',
                        confirmButtonColor: '#006257'
                    });
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to apply optimization. Please try again.',
                        confirmButtonColor: '#006257'
                    });
                }
            }
        });
    });
})();
</script>
<script src="/assets/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/js/admin.js"></script>