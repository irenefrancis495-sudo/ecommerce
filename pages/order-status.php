<?php
require_once __DIR__ . '/_customer_permissions.php';
customerRequirePermission('shop.orders');

$userId = (int) $_SESSION['user']['id'];

// Load orders
$ordersFile = __DIR__ . '/../data/orders.json';
$allOrders  = [];
if (file_exists($ordersFile)) {
    $d = json_decode((string) file_get_contents($ordersFile), true);
    if (is_array($d)) $allOrders = $d;
}

// Filter only this user's orders, newest first
$myOrders = array_values(array_filter($allOrders, fn($o) => (int) ($o['user_id'] ?? 0) === $userId));
usort($myOrders, fn($a, $b) => (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0));

// Load order items
$orderItemsFile = __DIR__ . '/../data/order_items.json';
$allItems       = [];
if (file_exists($orderItemsFile)) {
    $d = json_decode((string) file_get_contents($orderItemsFile), true);
    if (is_array($d)) $allItems = $d;
}
$itemsByOrder = [];
foreach ($allItems as $item) {
    $oid = (int) ($item['order_id'] ?? 0);
    $itemsByOrder[$oid][] = $item;
}

function orderStatusBadge(string $status): string {
    $map = [
        'processing'  => 'bg-amber-100 text-amber-700',
        'shipped'     => 'bg-blue-100 text-blue-700',
        'on_delivery' => 'bg-sky-100 text-sky-700',
        'delivered'   => 'bg-emerald-100 text-emerald-700',
        'completed'   => 'bg-green-100 text-green-700',
        'cancelled'   => 'bg-red-100 text-red-700',
        'pending'     => 'bg-slate-100 text-slate-600',
    ];
    $cls   = $map[$status] ?? 'bg-slate-100 text-slate-600';
    $label = ucfirst(str_replace('_', ' ', $status));
    return "<span class=\"inline-block px-2.5 py-1 rounded-full text-xs font-semibold $cls\">$label</span>";
}

function orderProgressStep(string $status): int {
    return match ($status) {
        'pending' => 1,
        'processing' => 2,
        'shipped', 'on_delivery' => 3,
        'delivered', 'completed' => 4,
        'cancelled' => 0,
        default => 1,
    };
}

function orderStatusMessage(string $status): string {
    return match ($status) {
        'pending' => 'Your order has been received and is waiting for confirmation.',
        'processing' => 'Your order is being prepared by the team.',
        'shipped' => 'Your order has been shipped and is on the way.',
        'on_delivery' => 'Your order is out for delivery.',
        'delivered' => 'Your order has been delivered successfully.',
        'completed' => 'This order has been completed successfully.',
        'cancelled' => 'This order was cancelled. Please contact support if needed.',
        default => 'Your order is being updated.',
    };
}

$justPlaced = trim($_GET['placed'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Orders - Mpemba Marketplace</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/assets/tailwindcss/tailwindv3.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F4C75',
                        'primary-container': '#D0E8FF',
                        secondary: '#1B6CA8',
                        'secondary-container': '#BBE1FA',
                        surface: '#FAFAFA',
                        'surface-container': '#F0F4F8',
                        'surface-container-low': '#E8EEF4',
                        'surface-container-high': '#D8E4EE',
                        'on-surface': '#1A1A2E',
                        'on-surface-variant': '#475569',
                        error: '#BA1A1A',
                        outline: '#CBD5E1',
                    },
                    fontFamily: {
                        headline: ['Playfair Display', 'Georgia', 'serif'],
                    },
                }
            }
        };
    </script>
</head>
<body class="bg-surface text-on-surface min-h-screen">
    <?php include __DIR__ . '/../components/ui/navbar.php'; ?>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

        <?php if ($justPlaced): ?>
        <div class="mb-6 flex items-start gap-3 rounded-2xl bg-green-50 border border-green-200 px-5 py-4 text-green-800">
            <span class="material-symbols-outlined text-green-600 mt-0.5" style="font-variation-settings:'FILL' 1;">check_circle</span>
            <div>
                <p class="font-semibold">Payment successful.</p>
                <p class="text-sm mt-0.5">Your order <strong><?= htmlspecialchars($justPlaced, ENT_QUOTES, 'UTF-8') ?></strong> has been received and is now being processed.</p>
            </div>
        </div>
        <?php endif; ?>

        <div class="mb-8 flex items-start gap-4">
            <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-secondary text-white shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-[28px]" style="font-variation-settings:'FILL' 1;">inventory_2</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold font-headline text-primary">My Orders</h1>
                <p class="text-on-surface-variant text-sm mt-1">Your complete purchase history</p>
            </div>
        </div>

        <?php if (empty($myOrders)): ?>
        <div class="rounded-3xl bg-white shadow-sm border border-surface-container-high p-16 text-center">
            <span class="material-symbols-outlined text-6xl text-outline mb-4 block" style="color:#CBD5E1;">receipt_long</span>
            <h2 class="text-xl font-semibold text-on-surface mb-2">You do not have any orders yet</h2>
            <p class="text-on-surface-variant text-sm mb-6">Visit the shop and place your first order.</p>
            <a href="/home" class="inline-block bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:opacity-90 transition-opacity">
                Start Shopping
            </a>
        </div>

        <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($myOrders as $order): ?>
            <?php
                $orderId     = (int) ($order['id'] ?? 0);
                $orderNumber = htmlspecialchars((string) ($order['order_number'] ?? '—'), ENT_QUOTES, 'UTF-8');
                $status      = strtolower((string) ($order['status'] ?? 'pending'));
                $createdAt   = (string) ($order['created_at'] ?? '');
                $dateLabel   = $createdAt ? date('d M Y, H:i', strtotime($createdAt)) : '—';
                $total       = number_format((float) ($order['total'] ?? 0), 2);
                $payMethod   = htmlspecialchars(ucwords(str_replace('_', ' ', (string) ($order['payment_method'] ?? ''))), ENT_QUOTES, 'UTF-8');
                $items       = $itemsByOrder[$orderId] ?? [];
                $progressStep = orderProgressStep($status);
                $progressNote = orderStatusMessage($status);
            ?>
            <div class="rounded-2xl bg-white shadow-sm border border-surface-container-high overflow-hidden">
                <!-- Header -->
                <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 bg-surface-container border-b border-surface-container-high">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1;">package_2</span>
                        <div>
                            <p class="font-bold text-primary text-sm"><?= $orderNumber ?></p>
                            <p class="text-xs text-on-surface-variant"><?= $dateLabel ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <?= orderStatusBadge($status) ?>
                        <span class="text-sm font-bold text-primary">$<?= $total ?></span>
                    </div>
                </div>

                <div class="px-6 py-4 border-b border-surface-container-high bg-white">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-on-surface-variant font-semibold">Order progress</p>
                            <p class="text-sm text-on-surface mt-1"><?= htmlspecialchars($progressNote, ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <span class="text-xs font-semibold text-on-surface-variant">Updated by admin status</span>
                    </div>

                    <?php if ($status === 'cancelled'): ?>
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        This order is no longer active.
                    </div>
                    <?php else: ?>
                    <div class="grid grid-cols-4 gap-2">
                        <?php foreach ([1 => 'Confirmed', 2 => 'Processing', 3 => 'Shipped', 4 => 'Delivered'] as $step => $label): ?>
                        <div class="min-w-0">
                            <div class="h-2 rounded-full <?= $progressStep >= $step ? 'bg-primary' : 'bg-surface-container-high' ?>"></div>
                            <p class="mt-2 text-[11px] font-semibold <?= $progressStep >= $step ? 'text-primary' : 'text-on-surface-variant' ?>"><?= $label ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Items -->
                <?php if (!empty($items)): ?>
                <ul class="divide-y divide-surface-container px-6">
                    <?php foreach ($items as $item): ?>
                    <?php
                        $itemName  = htmlspecialchars((string) ($item['name'] ?? 'Product'), ENT_QUOTES, 'UTF-8');
                        $itemQty   = (int) ($item['quantity'] ?? 1);
                        $itemPrice = number_format((float) ($item['unit_price'] ?? 0), 2);
                        $itemSub   = number_format((float) ($item['subtotal'] ?? 0), 2);
                        $itemImg   = htmlspecialchars((string) ($item['image'] ?? ''), ENT_QUOTES, 'UTF-8');
                    ?>
                    <li class="py-3 flex items-center gap-4">
                        <?php if ($itemImg): ?>
                        <img src="<?= $itemImg ?>" alt="<?= $itemName ?>"
                             class="w-12 h-12 rounded-xl object-cover bg-surface-container flex-shrink-0"
                             onerror="this.style.display='none'">
                        <?php else: ?>
                        <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-xl" style="color:#CBD5E1;">image_not_supported</span>
                        </div>
                        <?php endif; ?>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate"><?= $itemName ?></p>
                            <p class="text-xs text-on-surface-variant">Qty: <?= $itemQty ?> &times; $<?= $itemPrice ?></p>
                        </div>
                        <p class="text-sm font-bold text-primary flex-shrink-0">$<?= $itemSub ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <!-- Footer -->
                <div class="px-6 py-3 bg-surface-container/50 flex flex-wrap items-center justify-between gap-2 text-xs text-on-surface-variant">
                    <span>Payment method: <strong class="text-on-surface"><?= $payMethod ?: '—' ?></strong></span>
                    <span>Items: <strong class="text-on-surface"><?= count($items) ?></strong></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </main>

    <?php include __DIR__ . '/../components/ui/footer.php'; ?>
</body>
</html>
