<?php
<<<<<<< HEAD
use Mpemba\Utils\Utility;
=======
require __DIR__ . '/../config/bootstrap.php';
session_start();
use Mpemba\Entity\Order;
>>>>>>> main

$userLogged = isset($_SESSION['user_id']);
$orders = [];
if ($userLogged) {
    $orders = Order::findByUserId($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main class="max-w-5xl mx-auto px-6 py-10">
        <?php if (!$userLogged): ?>
            <section class="bg-white rounded-3xl p-8 shadow-sm">
                <h1 class="text-3xl font-extrabold text-slate-900 mb-4">Welcome back</h1>
                <p class="text-slate-600 mb-6">Please log in or register to view your orders and account details.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="/login" class="rounded-full bg-blue-600 px-6 py-3 text-white hover:bg-blue-700">Login</a>
                    <a href="/register" class="rounded-full border border-slate-300 px-6 py-3 text-slate-700 hover:bg-slate-100">Register</a>
                </div>
            </section>
        <?php else: ?>
            <section class="bg-white rounded-3xl p-8 shadow-sm mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 mb-4">My Account</h1>
                <p class="text-slate-600 mb-2">Username: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
                <p class="text-slate-600 mb-4">Role: <strong><?= htmlspecialchars($_SESSION['role'] ?? 'customer') ?></strong></p>
                <a href="/logout" class="inline-flex items-center rounded-full bg-red-600 px-6 py-3 text-white hover:bg-red-700">Logout</a>
            </section>
            <section class="bg-white rounded-3xl p-8 shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">Recent Orders</h2>
                <?php if (empty($orders)): ?>
                    <p class="text-slate-600">You have no orders yet. Start shopping and checkout to see your order history here.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($orders as $order): ?>
                            <article class="rounded-3xl border border-slate-200 p-5">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-slate-700 font-semibold">Order #<?= (int)$order->id ?></span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-600"><?= htmlspecialchars($order->status) ?></span>
                                </div>
                                <p class="text-slate-600">Total: Tsh <?= number_format($order->total, 2) ?></p>
                                <p class="text-slate-500 text-sm">Placed on <?= htmlspecialchars($order->created_at) ?></p>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
