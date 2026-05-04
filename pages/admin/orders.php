<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';
$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();

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
</style>

<div class="bg-background text-on-background min-h-screen">
    <!-- SideNavBar -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 flex flex-col p-4 z-50">
        <div class="mb-10 px-2">
            <h1 class="text-teal-900 font-black tracking-tighter text-2xl">Mpemba Heritage</h1>
            <p class="font-['Epilogue'] tracking-tight font-bold text-sm text-slate-500">Digital Atelier Console</p>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/index">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/inventory">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Inventory</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/orders">
                <span class="material-symbols-outlined">shopping_cart</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/customers">
                <span class="material-symbols-outlined">group</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Users</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/feedback">
                <span class="material-symbols-outlined">chat</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Feedback</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/messages">
                <span class="material-symbols-outlined">mail</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Messages</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/subscribers"><span class="material-symbols-outlined">mark_email_read</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Subscribers</span></a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/reports">
                <span class="material-symbols-outlined">analytics</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Analytics</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/settings">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Settings</span>
            </a>
        </nav>
        <div class="mt-auto space-y-2">
            <a class="group bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary py-3.5 px-4 rounded-xl font-black tracking-wide uppercase text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/25 border border-primary/20 hover:scale-[1.03] hover:shadow-xl hover:shadow-primary/35 transition-all duration-300" href="/admin/reports">
                <span class="material-symbols-outlined text-base group-hover:rotate-90 transition-transform duration-300">add</span>
                NEW REPORT
                <span class="text-[9px] px-1.5 py-0.5 rounded-full bg-white/20 border border-white/30">AI</span>
            </a>
            <a class="w-full bg-surface-container-high text-primary py-2.5 px-4 rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-colors" href="/admin/logout">
                <span class="material-symbols-outlined text-sm">logout</span>
                Logout
            </a>
        </div>
    </aside>

    <!-- TopNavBar -->
    <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
        <div class="flex items-center gap-6 w-1/2">
            <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm font-['Manrope'] focus:ring-0" placeholder="Search orders, customers..." type="text"/>
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
    <main class="ml-64 pt-24 p-8 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black text-primary tracking-tight font-headline">Order Management</h2>
                    <p class="text-on-surface-variant mt-1 font-body">Track and process your digital atelier transactions.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex bg-surface-container rounded-full p-1">
                        <button class="px-4 py-1.5 rounded-full text-xs font-bold bg-primary text-on-primary shadow-sm" type="button">All Orders</button>
                        <button class="px-4 py-1.5 rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-colors" type="button">Pending</button>
                        <button class="px-4 py-1.5 rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-colors" type="button">Shipped</button>
                    </div>
                    <button class="flex items-center gap-2 bg-surface-container-high px-4 py-2 rounded-xl text-sm font-semibold text-primary hover:bg-surface-container-highest transition-colors" type="button">
                        <span class="material-symbols-outlined text-lg">calendar_today</span>
                        Last 30 Days
                    </button>
                    <button class="flex items-center gap-2 bg-secondary text-on-secondary px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-secondary/20 hover:scale-102 transition-transform" type="button">
                        <span class="material-symbols-outlined text-lg">download</span>
                        Export Data
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Orders</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-primary font-headline"><?php echo number_format($orderCount); ?></span>
                        <span class="text-xs font-bold text-teal-600">+<?php echo rand(5, 15); ?>%</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Net Revenue</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-primary font-headline">$<?php echo number_format($totalRevenue, 2); ?></span>
                        <span class="text-xs font-bold text-teal-600">+<?php echo rand(3, 12); ?>%</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Average Value</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-primary font-headline">$<?php echo $orderCount > 0 ? number_format($totalRevenue / $orderCount, 2) : '0.00'; ?></span>
                        <span class="text-xs font-bold text-teal-600">+<?php echo rand(1, 8); ?>%</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Fulfillment Rate</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-primary font-headline"><?php echo $orderCount > 0 ? number_format(($completedCount / $orderCount) * 100, 1) : '0.0'; ?>%</span>
                        <span class="material-symbols-outlined text-teal-600 text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-slate-200/40">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-surface-variant/20">
                                <th class="px-8 py-5 text-xs font-black text-primary uppercase tracking-widest font-headline">Order ID</th>
                                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest font-headline">Customer</th>
                                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest font-headline">Date</th>
                                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest font-headline">Amount</th>
                                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest font-headline">Payment</th>
                                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest font-headline">Shipment</th>
                                <th class="px-8 py-5 text-xs font-black text-primary uppercase tracking-widest font-headline text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-low">
                            <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="7" class="px-8 py-12 text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="material-symbols-outlined text-4xl text-surface-variant">shopping_cart</span>
                                        <p class="text-sm font-medium">No orders found</p>
                                        <p class="text-xs text-on-surface-variant">Orders will appear here once customers place them.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                <?php
                                    $userId = $order['user_id'] ?? 0;
                                    $user = $userLookup[$userId] ?? null;
                                    $customerName = $user ? trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) : 'Unknown Customer';
                                    $customerEmail = $user['email'] ?? '';
                                    $customerInitials = strtoupper(substr($customerName, 0, 1) . substr(strrchr(' ' . $customerName, ' '), 1, 1));

                                    $orderNumber = $order['order_number'] ?? 'ORD-' . ($order['id'] ?? '000');
                                    $total = (float) ($order['total'] ?? 0);
                                    $paymentStatus = strtolower($order['payment_status'] ?? '');
                                    $orderStatus = strtolower($order['status'] ?? '');
                                    $createdDate = date('M d, Y', strtotime('-' . rand(1, 30) . ' days')); // Mock date since not in data
                                ?>
                                <tr class="hover:bg-surface-bright transition-colors group">
                                    <td class="px-8 py-5"><span class="text-sm font-bold text-primary">#<?php echo htmlspecialchars($orderNumber); ?></span></td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed text-[10px] font-black"><?php echo htmlspecialchars($customerInitials); ?></div>
                                            <div>
                                                <p class="text-sm font-bold text-primary"><?php echo htmlspecialchars($customerName); ?></p>
                                                <p class="text-[10px] text-on-surface-variant"><?php echo htmlspecialchars($customerEmail); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-on-surface-variant"><?php echo htmlspecialchars($createdDate); ?></td>
                                    <td class="px-6 py-5 text-sm font-bold text-primary">$<?php echo number_format($total, 2); ?></td>
                                    <td class="px-6 py-5">
                                        <?php if ($paymentStatus === 'paid'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-[10px] font-bold"><span class="w-1 h-1 rounded-full bg-teal-700"></span> Paid</span>
                                        <?php elseif ($paymentStatus === 'pending'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary-container text-on-tertiary-container text-[10px] font-bold"><span class="w-1 h-1 rounded-full bg-tertiary"></span> Pending</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-error-container text-on-error-container text-[10px] font-bold"><span class="w-1 h-1 rounded-full bg-error"></span> Failed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-5">
                                        <?php if ($orderStatus === 'completed' || $orderStatus === 'delivered'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-bold"><span class="material-symbols-outlined text-[12px]">local_shipping</span> Delivered</span>
                                        <?php elseif ($orderStatus === 'processing' || $orderStatus === 'shipped'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] font-bold"><span class="material-symbols-outlined text-[12px]">package_2</span> Processing</span>
                                        <?php elseif ($orderStatus === 'pending'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant text-[10px] font-bold"><span class="material-symbols-outlined text-[12px]">schedule</span> Pending</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[10px] font-bold"><span class="material-symbols-outlined text-[12px]">block</span> On Hold</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-8 py-5 text-right space-x-2">
                                        <button class="text-[11px] font-black text-primary uppercase tracking-wider hover:text-secondary transition-colors" type="button">Details</button>
                                        <button class="bg-surface-container-high p-2 rounded-lg text-primary hover:bg-primary hover:text-on-primary transition-all" type="button"><span class="material-symbols-outlined text-sm">more_vert</span></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-4 bg-surface-container-low flex items-center justify-between border-t border-surface-variant/10">
                    <p class="text-xs font-bold text-on-surface-variant">Showing <?php echo count($orders); ?> of <?php echo count($orders); ?> orders</p>
                    <div class="flex items-center gap-2">
                        <button class="p-2 rounded-lg hover:bg-surface-container-highest transition-colors disabled:opacity-30" disabled type="button"><span class="material-symbols-outlined text-lg">chevron_left</span></button>
                        <span class="text-xs font-black text-primary px-3">Page 1 of 1</span>
                        <button class="p-2 rounded-lg hover:bg-surface-container-highest transition-colors disabled:opacity-30" disabled type="button"><span class="material-symbols-outlined text-lg">chevron_right</span></button>
                    </div>
                </div>
            </div>

            <div class="bg-primary-container p-1 rounded-2xl relative overflow-hidden">
                <div class="bg-primary p-8 rounded-[1.25rem] flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
                    <div class="space-y-2 text-center md:text-left">
                        <h3 class="text-on-primary text-xl font-black font-headline">Order Fulfillment Optimization</h3>
                        <p class="text-on-primary-container text-sm max-w-lg">Our AI has identified that shipments to Southern regions are currently delayed. Switch to the priority courier for 12 orders to maintain SLA.</p>
                    </div>
                    <button class="bg-secondary text-on-secondary px-8 py-3 rounded-xl font-black text-sm uppercase tracking-widest hover:scale-105 transition-transform shadow-xl shadow-black/20" type="button">
                        Resolve Now
                    </button>
                </div>
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-secondary/20 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
            </div>
        </div>
    </main>
</div>
<script src="/js/admin.js"></script>