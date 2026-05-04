<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';
$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();

$file = __DIR__ . '/../../data/subscribers.json';
$subscribers = file_exists($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];

// Delete subscriber
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    $subscribers = array_values(array_filter($subscribers, fn($s) => $s['id'] !== $id));
    file_put_contents($file, json_encode($subscribers, JSON_PRETTY_PRINT));
    header('Location: /admin/subscribers'); exit;
}

$total = count($subscribers);
$sourceCounts = array_count_values(array_column($subscribers, 'source'));
$footerCount  = $sourceCounts['footer'] ?? 0;
$blogCount    = $sourceCounts['blog'] ?? 0;
$categoryCount = $sourceCounts['category'] ?? 0;
?>
<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }
</style>

<div class="bg-background text-on-background min-h-screen">
  <!-- Sidebar -->
  <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 flex flex-col p-4 z-50">
    <div class="mb-10 px-2">
      <h1 class="text-teal-900 font-black tracking-tighter text-2xl">Mpemba Heritage</h1>
      <p class="font-['Epilogue'] tracking-tight font-bold text-sm text-slate-500">Digital Atelier Console</p>
    </div>
    <nav class="flex-1 space-y-1">
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/index"><span class="material-symbols-outlined">dashboard</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Dashboard</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/inventory"><span class="material-symbols-outlined">inventory_2</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Inventory</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/categories"><span class="material-symbols-outlined">category</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Categories</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/orders"><span class="material-symbols-outlined">shopping_cart</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/customers"><span class="material-symbols-outlined">group</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Users</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/feedback"><span class="material-symbols-outlined">chat</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Feedback</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/messages"><span class="material-symbols-outlined">mail</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Messages</span></a>
      <a class="flex items-center gap-3 px-4 py-3 bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/subscribers"><span class="material-symbols-outlined">mark_email_read</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Subscribers</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/reports"><span class="material-symbols-outlined">analytics</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Analytics</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/settings"><span class="material-symbols-outlined">settings</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Settings</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/permissions"><span class="material-symbols-outlined">admin_panel_settings</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Permissions</span></a>
    </nav>
    <div class="mt-auto space-y-2">
      <a class="group bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary py-3.5 px-4 rounded-xl font-black tracking-wide uppercase text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/25 border border-primary/20 hover:scale-[1.03] hover:shadow-xl hover:shadow-primary/35 transition-all duration-300" href="/admin/reports">
        <span class="material-symbols-outlined text-base group-hover:rotate-90 transition-transform duration-300">add</span>NEW REPORT<span class="text-[9px] px-1.5 py-0.5 rounded-full bg-white/20 border border-white/30">AI</span>
      </a>
      <a class="w-full bg-surface-container-high text-primary py-2.5 px-4 rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-colors" href="/admin/logout"><span class="material-symbols-outlined text-sm">logout</span>Logout</a>
    </div>
  </aside>

  <!-- Top Bar -->
  <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input id="globalSearch" class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-0" placeholder="Search subscribers..." type="text"/>
      </div>
    </div>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications"><span class="material-symbols-outlined">notifications</span><?php if ($notificationCount > 0): ?><span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?= $notificationCount > 99 ? '99+' : $notificationCount ?></span><?php endif; ?></a>
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">help_outline</span></button>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right">
          <p class="text-xs font-bold text-teal-900"><?= htmlspecialchars($adminName) ?></p>
          <p class="text-[10px] text-slate-400">Operations Lead</p>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-8">

      <!-- Header -->
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
          <h2 class="text-3xl font-black text-primary tracking-tight">Newsletter Subscribers</h2>
          <p class="text-on-surface-variant mt-1">Emails collected from newsletter sign-up forms.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
          <div class="flex bg-surface-container rounded-full p-1">
            <button onclick="filterSource('all')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold bg-primary text-on-primary shadow-sm" data-src="all">All</button>
            <button onclick="filterSource('footer')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-colors" data-src="footer">Footer</button>
            <button onclick="filterSource('blog')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-colors" data-src="blog">Blog</button>
            <button onclick="filterSource('category')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-colors" data-src="category">Category</button>
          </div>
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm shadow-slate-200/50 border border-slate-100">
          <div class="flex items-center justify-between mb-3"><span class="text-on-surface-variant text-sm font-semibold">Total</span><span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-primary/10"><span class="material-symbols-outlined text-primary text-lg">people</span></span></div>
          <p class="text-3xl font-black text-primary"><?= $total ?></p>
          <p class="text-xs text-on-surface-variant mt-1">All subscribers</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm shadow-slate-200/50 border border-slate-100">
          <div class="flex items-center justify-between mb-3"><span class="text-on-surface-variant text-sm font-semibold">Footer</span><span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50"><span class="material-symbols-outlined text-blue-600 text-lg">web</span></span></div>
          <p class="text-3xl font-black text-blue-600"><?= $footerCount ?></p>
          <p class="text-xs text-on-surface-variant mt-1">Via footer form</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm shadow-slate-200/50 border border-slate-100">
          <div class="flex items-center justify-between mb-3"><span class="text-on-surface-variant text-sm font-semibold">Blog</span><span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-purple-50"><span class="material-symbols-outlined text-purple-600 text-lg">article</span></span></div>
          <p class="text-3xl font-black text-purple-600"><?= $blogCount ?></p>
          <p class="text-xs text-on-surface-variant mt-1">Via blog page</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm shadow-slate-200/50 border border-slate-100">
          <div class="flex items-center justify-between mb-3"><span class="text-on-surface-variant text-sm font-semibold">Category</span><span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-amber-50"><span class="material-symbols-outlined text-amber-600 text-lg">category</span></span></div>
          <p class="text-3xl font-black text-amber-600"><?= $categoryCount ?></p>
          <p class="text-xs text-on-surface-variant mt-1">Via category page</p>
        </div>
      </div>

      <!-- Subscribers List -->
      <div class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h3 class="font-black text-on-surface text-lg">Subscriber List</h3>
          <span class="text-xs text-on-surface-variant"><?= $total ?> total</span>
        </div>
        <?php if (empty($subscribers)): ?>
        <div class="flex flex-col items-center justify-center py-20 text-on-surface-variant">
          <span class="material-symbols-outlined text-6xl mb-4 opacity-30">mark_email_read</span>
          <p class="font-bold text-lg">No subscribers yet</p>
          <p class="text-sm mt-1">Newsletter sign-ups will appear here.</p>
        </div>
        <?php else: ?>
        <div class="divide-y divide-slate-50" id="subscriberList">
          <?php foreach (array_reverse($subscribers) as $sub):
            $srcColors = ['footer'=>'bg-blue-50 text-blue-700','blog'=>'bg-purple-50 text-purple-700','category'=>'bg-amber-50 text-amber-700'];
            $srcClass = $srcColors[$sub['source'] ?? ''] ?? 'bg-slate-100 text-slate-600';
            $initials = strtoupper(substr($sub['email'], 0, 2));
            $date = isset($sub['subscribed_at']) ? date('M d, Y', strtotime($sub['subscribed_at'])) : '-';
          ?>
          <div class="subscriber-row flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50/70 transition-colors" data-source="<?= htmlspecialchars($sub['source'] ?? '') ?>">
            <div class="flex-shrink-0 w-9 h-9 rounded-full bg-gradient-to-br from-teal-600 to-cyan-500 flex items-center justify-center text-white font-black text-xs"><?= $initials ?></div>
            <div class="flex-1 min-w-0">
              <p class="font-semibold text-on-surface text-sm"><?= htmlspecialchars($sub['email']) ?></p>
              <p class="text-xs text-on-surface-variant mt-0.5">Subscribed <?= $date ?></p>
            </div>
            <div class="flex items-center gap-3">
              <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold <?= $srcClass ?>"><?= htmlspecialchars(ucfirst($sub['source'] ?? 'unknown')) ?></span>
              <form method="POST" class="delete-form">
                <input type="hidden" name="delete_id" value="<?= (int)$sub['id'] ?>" />
                <button type="submit" title="Remove subscriber" class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                  <span class="material-symbols-outlined text-sm">delete</span>
                </button>
              </form>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </main>
</div>

<script src="/assets/sweetalert2/sweetalert2.all.min.js"></script>
<script>
function filterSource(src) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        const active = btn.dataset.src === src;
        btn.classList.toggle('bg-primary', active);
        btn.classList.toggle('text-on-primary', active);
        btn.classList.toggle('shadow-sm', active);
        btn.classList.toggle('text-on-surface-variant', !active);
    });
    document.querySelectorAll('.subscriber-row').forEach(row => {
        row.style.display = (src === 'all' || row.dataset.source === src) ? '' : 'none';
    });
}
document.getElementById('globalSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.subscriber-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const f = this;
        Swal.fire({ title: 'Remove subscriber?', text: 'This cannot be undone.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Yes, remove' })
            .then(r => { if (r.isConfirmed) f.submit(); });
    });
});
</script>