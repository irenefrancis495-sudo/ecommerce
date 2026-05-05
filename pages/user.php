<?php
require __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/_customer_permissions.php';
customerRequirePermission('shop.profile');

$userLogged = customerIsLoggedIn();
$orders = [];
$feedbackItems = [];
$messages = [];
$isSubscribed = false;
$newFeedbackReplies = 0;
$newMessageReplies = 0;

if ($userLogged) {
    $currentUser = $_SESSION['user'] ?? [];
    $userId = (int) ($currentUser['id'] ?? 0);
    $ordersFile = __DIR__ . '/../data/orders.json';
    $feedbackFile = __DIR__ . '/../data/customer_comments.json';
    $messagesFile = __DIR__ . '/../data/contact_messages.json';
    $subscribersFile = __DIR__ . '/../data/subscribers.json';

    if ($userId > 0 && file_exists($ordersFile)) {
        $decoded = json_decode((string) file_get_contents($ordersFile), true);
        if (is_array($decoded)) {
            $orders = array_values(array_filter($decoded, function ($order) use ($userId) {
                return (int) ($order['user_id'] ?? 0) === $userId;
            }));
            usort($orders, function ($a, $b) {
                return (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0);
            });
        }
    }

    $userEmail = strtolower(trim((string) ($currentUser['email'] ?? '')));
    if ($userEmail !== '' && file_exists($feedbackFile)) {
        $decodedFeedback = json_decode((string) file_get_contents($feedbackFile), true);
        if (is_array($decodedFeedback)) {
            $feedbackItems = array_values(array_filter($decodedFeedback, function ($item) use ($userEmail) {
                return strtolower(trim((string) ($item['email'] ?? ''))) === $userEmail;
            }));
            usort($feedbackItems, function ($a, $b) {
                return strcmp((string) ($b['created_at'] ?? ''), (string) ($a['created_at'] ?? ''));
            });
            foreach ($feedbackItems as $feedbackItem) {
                if (!empty($feedbackItem['reply']) && strtolower((string) ($feedbackItem['status'] ?? '')) === 'replied') {
                    $newFeedbackReplies++;
                }
            }
        }
    }

    if ($userEmail !== '' && file_exists($messagesFile)) {
        $decodedMessages = json_decode((string) file_get_contents($messagesFile), true);
        if (is_array($decodedMessages)) {
            $messages = array_values(array_filter($decodedMessages, function ($item) use ($userEmail) {
                return strtolower(trim((string) ($item['email'] ?? ''))) === $userEmail;
            }));
            usort($messages, function ($a, $b) {
                return strcmp((string) ($b['created_at'] ?? ''), (string) ($a['created_at'] ?? ''));
            });
            foreach ($messages as $messageItem) {
                if (!empty($messageItem['reply']) && strtolower((string) ($messageItem['status'] ?? '')) === 'replied') {
                    $newMessageReplies++;
                }
            }
        }
    }

    if ($userEmail !== '' && file_exists($subscribersFile)) {
        $decodedSubscribers = json_decode((string) file_get_contents($subscribersFile), true);
        if (is_array($decodedSubscribers)) {
            foreach ($decodedSubscribers as $subscriber) {
                if (strtolower(trim((string) ($subscriber['email'] ?? ''))) === $userEmail) {
                    $isSubscribed = true;
                    break;
                }
            }
        }
    }
}

function accountOrderProgressMessage(string $status): string {
    return match ($status) {
        'pending' => 'Waiting for confirmation',
        'processing' => 'Being prepared',
        'shipped' => 'Shipped',
        'on_delivery' => 'Out for delivery',
        'delivered' => 'Delivered',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        default => 'Updating',
    };
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            line-height: 1;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include __DIR__ . '/../components/ui/navbar.php'; ?>
    <!-- Tab state for JS -->
    <script>
        function switchTab(tab) {
            ['tab-feedback','tab-messages','tab-orders'].forEach(function(id){
                document.getElementById(id).classList.add('hidden');
            });
            ['tabBtn-feedback','tabBtn-messages','tabBtn-orders'].forEach(function(id){
                const btn = document.getElementById(id);
                btn.classList.remove('bg-white','text-primary','shadow','font-bold','border-primary');
                btn.classList.add('text-slate-500','hover:text-primary');
            });
            document.getElementById('tab-' + tab).classList.remove('hidden');
            const active = document.getElementById('tabBtn-' + tab);
            active.classList.remove('text-slate-500','hover:text-primary');
            active.classList.add('bg-white','text-primary','shadow','font-bold');
        }
        // Auto-open tab from hash
        document.addEventListener('DOMContentLoaded', function(){
            const hash = window.location.hash;
            if (hash === '#message-center') switchTab('messages');
            else if (hash === '#orders') switchTab('orders');
            else switchTab('feedback');
        });
    </script>
    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-10 pt-28">
        <?php if (!$userLogged): ?>
            <section class="bg-white rounded-3xl p-10 shadow-sm text-center max-w-md mx-auto mt-10">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-cyan-500 text-white shadow-lg mb-6">
                    <span class="material-symbols-outlined text-[32px]" style="font-variation-settings:'FILL' 1;">lock</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 mb-3">Welcome to Mpemba</h1>
                <p class="text-slate-500 mb-8">Login or create an account to view your orders, feedback and messages.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="/login" class="rounded-full bg-primary px-8 py-3 text-white font-semibold hover:bg-primary/90 transition">Login</a>
                    <a href="/register" class="rounded-full border border-slate-300 px-8 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">Register</a>
                </div>
            </section>
        <?php else: ?>
            <?php
                $username = $_SESSION['user']['username'] ?? $_SESSION['user']['email'] ?? 'Customer';
                $firstName = $_SESSION['user']['first_name'] ?? '';
                $displayName = $firstName ?: $username;
                $avatarLetter = strtoupper(substr($displayName, 0, 1));
                $email = $_SESSION['user']['email'] ?? '';
            ?>
            <!-- Account Header -->
            <section class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-primary/90 to-cyan-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 70% 50%, white 1px, transparent 1px);background-size:28px 28px;"></div>
                <div class="relative flex flex-col sm:flex-row sm:items-center gap-6">
                    <div class="flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-2xl bg-white/20 text-3xl font-black text-white shadow-inner">
                        <?= $avatarLetter ?>
                    </div>
                    <div class="flex-1">
                        <p class="text-white/70 text-sm font-medium uppercase tracking-widest mb-1">My Account</p>
                        <h1 class="text-3xl font-extrabold"><?= htmlspecialchars($displayName) ?></h1>
                        <?php if ($email): ?>
                            <p class="text-white/70 text-sm mt-1"><?= htmlspecialchars($email) ?></p>
                        <?php endif; ?>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold capitalize">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">badge</span>
                                <?= htmlspecialchars($_SESSION['user']['role'] ?? 'customer') ?>
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">shopping_bag</span>
                                <?= count($orders) ?> order<?= count($orders) !== 1 ? 's' : '' ?>
                            </span>
                            <?php if ($isSubscribed): ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-400/30 px-3 py-1 text-xs font-semibold text-emerald-100">
                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">mark_email_read</span>
                                    Subscribed
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 sm:flex-col sm:items-end">
                        <a href="/order-status" class="inline-flex items-center gap-2 rounded-full bg-white/15 border border-white/20 px-4 py-2.5 text-sm font-semibold hover:bg-white/25 transition">
                            <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1;">inventory_2</span>
                            My Orders
                        </a>
                        <button onclick="logout()" class="inline-flex items-center gap-2 rounded-full bg-red-500/80 border border-red-400/40 px-4 py-2.5 text-sm font-semibold hover:bg-red-600/90 transition" type="button">
                            <span class="material-symbols-outlined text-base">logout</span>
                            Logout
                        </button>
                    </div>
                </div>
            </section>

            <!-- Stats row -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm text-center">
                    <p class="text-2xl font-extrabold text-slate-900"><?= count($orders) ?></p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Orders</p>
                </div>
                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm text-center">
                    <p class="text-2xl font-extrabold text-primary"><?= count($feedbackItems) ?></p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Feedback</p>
                </div>
                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm text-center">
                    <p class="text-2xl font-extrabold text-slate-900"><?= count($messages) ?></p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Messages</p>
                </div>
                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm text-center">
                    <p class="text-2xl font-extrabold text-emerald-600"><?= $newFeedbackReplies + $newMessageReplies ?></p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">New Replies</p>
                </div>
            </div>

            <!-- Tab navigation -->
            <div class="bg-slate-100 rounded-2xl p-1.5 flex gap-1 mb-6">
                <button id="tabBtn-feedback" onclick="switchTab('feedback')" class="flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition">
                    <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1;">rate_review</span>
                    Feedback
                    <?php if ($newFeedbackReplies > 0): ?>
                        <span class="inline-flex min-w-[1.25rem] items-center justify-center rounded-full bg-emerald-500 px-1.5 py-0.5 text-[10px] font-bold text-white"><?= $newFeedbackReplies ?></span>
                    <?php endif; ?>
                </button>
                <button id="tabBtn-messages" onclick="switchTab('messages')" class="flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition">
                    <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1;">mail</span>
                    Messages
                    <?php if ($newMessageReplies > 0): ?>
                        <span class="inline-flex min-w-[1.25rem] items-center justify-center rounded-full bg-blue-500 px-1.5 py-0.5 text-[10px] font-bold text-white"><?= $newMessageReplies ?></span>
                    <?php endif; ?>
                </button>
                <button id="tabBtn-orders" onclick="switchTab('orders')" class="flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition">
                    <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1;">inventory_2</span>
                    Orders
                </button>
            </div>
            <!-- TAB: Feedback -->
            <div id="tab-feedback" class="hidden" id="feedback-center">
                <section class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                    <div class="px-8 py-6 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-cyan-500 text-white shadow">
                                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1;">rate_review</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Feedback Center</h2>
                                <p class="text-sm text-slate-500"><?= count($feedbackItems) ?> thread<?= count($feedbackItems) !== 1 ? 's' : '' ?><?= $newFeedbackReplies > 0 ? " · <span class='text-emerald-600 font-semibold'>{$newFeedbackReplies} new repl" . ($newFeedbackReplies === 1 ? 'y' : 'ies') . '</span>' : '' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 sm:p-8">
                        <!-- Send feedback form -->
                        <form id="feedbackForm" class="rounded-2xl border border-slate-200 bg-slate-50 p-6 mb-8 space-y-4">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-base font-bold text-slate-900">Send new feedback</h3>
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white text-primary shadow-sm border border-slate-200">
                                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1;">send</span>
                                </span>
                            </div>
                            <input id="feedbackName" type="hidden" value="<?= htmlspecialchars($_SESSION['user']['username'] ?? $_SESSION['user']['email'] ?? 'customer', ENT_QUOTES, 'UTF-8') ?>">
                            <input id="feedbackEmail" type="hidden" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <textarea id="feedbackMessage" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/10" placeholder="Share your experience, issue, or suggestion..."></textarea>
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <p id="feedbackStatus" class="text-sm text-slate-500">Admin will respond in this section.</p>
                                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-sm font-bold text-white hover:bg-primary/90 transition shadow-md shadow-primary/20">
                                    <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1;">send</span>
                                    Send Feedback
                                </button>
                            </div>
                        </form>

                        <!-- Feedback history -->
                        <div class="space-y-4">
                            <?php if (empty($feedbackItems)): ?>
                                <div class="rounded-2xl border border-dashed border-slate-200 p-10 text-center bg-slate-50">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">chat_bubble</span>
                                    <p class="mt-3 text-sm font-semibold text-slate-700">No feedback sent yet</p>
                                    <p class="text-sm text-slate-400 mt-1">Once you send feedback, admin replies will show here.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($feedbackItems as $feedback): ?>
                                    <?php
                                        $feedbackStatus = (string) ($feedback['status'] ?? 'new');
                                        $badgeClass = match ($feedbackStatus) {
                                            'replied' => 'bg-emerald-100 text-emerald-700',
                                            'read' => 'bg-blue-100 text-blue-700',
                                            default => 'bg-amber-100 text-amber-700',
                                        };
                                    ?>
                                    <article class="rounded-2xl border border-slate-200 p-5 bg-white">
                                        <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                                            <div>
                                                <p class="text-sm font-bold text-slate-900">Sent <?= htmlspecialchars(date('M d, Y H:i', strtotime((string) ($feedback['created_at'] ?? 'now')))) ?></p>
                                                <p class="text-xs text-slate-400 mt-0.5">ID #<?= (int) ($feedback['id'] ?? 0) ?></p>
                                            </div>
                                            <span class="rounded-full px-3 py-1 text-xs font-bold <?= $badgeClass ?>"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $feedbackStatus))) ?></span>
                                        </div>
                                        <div class="rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                            <?= nl2br(htmlspecialchars((string) ($feedback['message'] ?? ''), ENT_QUOTES, 'UTF-8')) ?>
                                        </div>
                                        <?php if (!empty($feedback['reply'])): ?>
                                            <div class="mt-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-4">
                                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-600 px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-white">
                                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">support_agent</span>
                                                        Admin reply
                                                    </span>
                                                    <?php if (!empty($feedback['replied_at'])): ?>
                                                        <p class="text-xs text-slate-500"><?= htmlspecialchars(date('M d, Y H:i', strtotime((string) $feedback['replied_at']))) ?></p>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-sm text-slate-700"><?= nl2br(htmlspecialchars((string) ($feedback['reply'] ?? ''), ENT_QUOTES, 'UTF-8')) ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </article>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>

            <!-- TAB: Messages -->
            <div id="tab-messages" class="hidden">
                <section id="message-center" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6 scroll-mt-28">
                    <div class="px-8 py-6 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-900 to-primary text-white shadow">
                                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1;">mail</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Message Center</h2>
                                <p class="text-sm text-slate-500"><?= count($messages) ?> thread<?= count($messages) !== 1 ? 's' : '' ?><?= $newMessageReplies > 0 ? " · <span class='text-blue-600 font-semibold'>{$newMessageReplies} new repl" . ($newMessageReplies === 1 ? 'y' : 'ies') . '</span>' : '' ?></p>
                            </div>
                        </div>
                        <a href="/contact" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2.5 text-sm font-bold text-white hover:bg-slate-800 transition">
                            <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1;">add</span>
                            New Message
                        </a>
                    </div>
                    <div class="p-6 sm:p-8">
                        <!-- Newsletter status -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 flex items-center justify-between gap-4 mb-6">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Newsletter subscription</p>
                                <p class="text-xs text-slate-500 mt-0.5"><?= $isSubscribed ? 'Subscribed to marketplace updates.' : 'Not subscribed yet.' ?></p>
                            </div>
                            <span class="rounded-full px-3 py-1 text-xs font-bold <?= $isSubscribed ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' ?>">
                                <?= $isSubscribed ? 'Subscribed' : 'Not subscribed' ?>
                            </span>
                        </div>

                        <?php if (empty($messages)): ?>
                            <div class="rounded-2xl border border-dashed border-slate-200 p-10 text-center bg-slate-50">
                                <span class="material-symbols-outlined text-4xl text-slate-300">mark_email_read</span>
                                <p class="mt-3 text-sm font-semibold text-slate-700">No messages yet</p>
                                <p class="text-sm text-slate-400 mt-1">Contact support and admin replies will appear here.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($messages as $message): ?>
                                    <?php
                                        $messageStatus = (string) ($message['status'] ?? 'new');
                                        $badgeClass = match ($messageStatus) {
                                            'replied' => 'bg-emerald-100 text-emerald-700',
                                            'read' => 'bg-blue-100 text-blue-700',
                                            default => 'bg-amber-100 text-amber-700',
                                        };
                                        $subjectText = ucfirst(str_replace('_', ' ', (string) ($message['subject'] ?? 'general')));
                                    ?>
                                    <article class="rounded-2xl border border-slate-200 p-5 bg-white">
                                        <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                                            <div>
                                                <p class="text-sm font-bold text-slate-900"><?= htmlspecialchars($subjectText) ?></p>
                                                <p class="text-xs text-slate-400 mt-0.5">Sent <?= htmlspecialchars(date('M d, Y H:i', strtotime((string) ($message['created_at'] ?? 'now')))) ?></p>
                                            </div>
                                            <span class="rounded-full px-3 py-1 text-xs font-bold <?= $badgeClass ?>"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $messageStatus))) ?></span>
                                        </div>
                                        <div class="rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                            <?= nl2br(htmlspecialchars((string) ($message['message'] ?? ''), ENT_QUOTES, 'UTF-8')) ?>
                                        </div>
                                        <?php if (!empty($message['reply'])): ?>
                                            <div class="mt-3 rounded-xl border border-blue-200 bg-blue-50 px-4 py-4">
                                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-600 px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-white">
                                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">reply</span>
                                                        Admin reply
                                                    </span>
                                                    <?php if (!empty($message['replied_at'])): ?>
                                                        <p class="text-xs text-slate-500"><?= htmlspecialchars(date('M d, Y H:i', strtotime((string) $message['replied_at']))) ?></p>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-sm text-slate-700"><?= nl2br(htmlspecialchars((string) ($message['reply'] ?? ''), ENT_QUOTES, 'UTF-8')) ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>

            <!-- TAB: Orders -->
            <div id="tab-orders" class="hidden">
                <section class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                    <div class="px-8 py-6 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-secondary text-white shadow">
                                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1;">inventory_2</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Order History</h2>
                                <p class="text-sm text-slate-500"><?= count($orders) ?> order<?= count($orders) !== 1 ? 's' : '' ?> total</p>
                            </div>
                        </div>
                        <a href="/order-status" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Full Orders Page
                        </a>
                    </div>
                    <div class="p-6 sm:p-8">
                        <?php if (empty($orders)): ?>
                            <div class="rounded-2xl border border-dashed border-slate-200 p-10 text-center bg-slate-50">
                                <span class="material-symbols-outlined text-4xl text-slate-300">shopping_bag</span>
                                <p class="mt-3 text-sm font-semibold text-slate-700">No orders yet</p>
                                <p class="text-sm text-slate-400 mt-1">Place an order and it will appear here.</p>
                                <a href="/products" class="mt-4 inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-sm font-bold text-white hover:bg-primary/90 transition">Shop now</a>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($orders as $order): ?>
                                    <?php $status = (string) ($order['status'] ?? 'pending'); ?>
                                    <article class="rounded-2xl border border-slate-200 p-5 bg-white flex flex-wrap items-center justify-between gap-4">
                                        <div>
                                            <p class="font-bold text-slate-900">Order #<?= htmlspecialchars((string) ($order['order_number'] ?? $order['id'] ?? '')) ?></p>
                                            <p class="text-sm text-slate-500 mt-0.5">Placed <?= htmlspecialchars((string) ($order['created_at'] ?? '')) ?></p>
                                            <p class="text-sm text-blue-700 font-medium mt-1"><?= htmlspecialchars(accountOrderProgressMessage($status)) ?></p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <p class="font-bold text-slate-900">$<?= number_format((float) ($order['total'] ?? 0), 2) ?></p>
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $status))) ?></span>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        <?php endif; ?>
    </main>
    <?php include __DIR__ . '/../components/ui/footer.php'; ?>
    <script>
        document.getElementById('feedbackForm')?.addEventListener('submit', async function (event) {
            event.preventDefault();

            const name = document.getElementById('feedbackName')?.value.trim() || '';
            const email = document.getElementById('feedbackEmail')?.value.trim() || '';
            const message = document.getElementById('feedbackMessage')?.value.trim() || '';
            const statusEl = document.getElementById('feedbackStatus');

            if (!message) {
                if (statusEl) {
                    statusEl.textContent = 'Please enter your feedback message.';
                    statusEl.className = 'text-sm text-red-600';
                }
                return;
            }

            if (statusEl) {
                statusEl.textContent = 'Sending feedback...';
                statusEl.className = 'text-sm text-slate-500';
            }

            try {
                const response = await fetch('/api/comments.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, email, message })
                });
                const result = await response.json();

                if (result.status === 'success') {
                    if (statusEl) {
                        statusEl.textContent = result.message || 'Feedback sent successfully.';
                        statusEl.className = 'text-sm text-emerald-600';
                    }
                    document.getElementById('feedbackMessage').value = '';
                    window.location.reload();
                } else if (statusEl) {
                    statusEl.textContent = result.message || 'Could not send feedback.';
                    statusEl.className = 'text-sm text-red-600';
                }
            } catch (error) {
                if (statusEl) {
                    statusEl.textContent = 'Network error. Please try again.';
                    statusEl.className = 'text-sm text-red-600';
                }
            }
        });

        async function logout() {
            try {
                const response = await fetch('/api/auth.php?action=logout', { method: 'POST' });
                const result = await response.json();
                if (result.success) {
                    localStorage.removeItem('user');
                    window.location.href = '/home';
                }
            } catch (error) {
                localStorage.removeItem('user');
                window.location.href = '/home';
            }
        }
    </script>
</body>
</html>
