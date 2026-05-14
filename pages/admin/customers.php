<?php
require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'customers';
// Load users from database (no JSON fallback)
$usersData = \Mpemba\Utils\Database::getUsers();

if (!is_array($usersData)) {
  $usersData = [];
}

$roleOptions = array_keys(adminLoadRolePermissions());

function adminRoleLabel(string $role): string
{
    return ucwords(str_replace(['_', '-'], ' ', $role));
}

$displayUsers = [];
$activeCount = 0;
$adminCount = 0;
$customerCount = 0;

foreach ($usersData as $idx => $u) {
    $first = trim((string) ($u['first_name'] ?? ''));
    $last = trim((string) ($u['last_name'] ?? ''));
    $fullName = trim($first . ' ' . $last);
    $fullName = $fullName !== '' ? $fullName : (string) ($u['username'] ?? 'Unknown User');

    $role = strtolower((string) ($u['role'] ?? 'customer'));
    if ($role === 'customer') {
        $role = 'user';
    }
    $isActive = ((int) ($u['id'] ?? 0) % 4) !== 0;
    if ($isActive) {
        $activeCount++;
    }

    if ($role === 'admin') {
        $adminCount++;
    } else {
        $customerCount++;
    }

    $joinedDate = date('M d, Y', strtotime('-' . (($idx + 2) * 13) . ' days'));
    $orders = max(1, (($idx + 1) * 3) % 24);
    $totalSpend = number_format(($orders * 38.5) + (($idx + 1) * 14), 2);
    $initials = strtoupper(substr($fullName, 0, 1) . substr(strrchr(' ' . $fullName, ' '), 1, 1));

    $displayUsers[] = [
        'id' => (int) ($u['id'] ?? ($idx + 1)),
        'username' => (string) ($u['username'] ?? ''),
        'email' => (string) ($u['email'] ?? ''),
        'name' => $fullName,
        'role' => $role,
        'status' => $isActive ? 'active' : 'inactive',
        'joined' => $joinedDate,
        'orders' => $orders,
        'spend' => $totalSpend,
        'initials' => trim($initials) !== '' ? $initials : 'U',
    ];
}

$totalUsers = count($displayUsers);

$commentsFile = __DIR__ . '/../../data/customer_comments.json';
$customerComments = [];
if (file_exists($commentsFile)) {
    $decodedComments = json_decode((string) file_get_contents($commentsFile), true);
    if (is_array($decodedComments)) {
        $customerComments = $decodedComments;
    }
}

usort($customerComments, function ($a, $b) {
    return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
});

$commentsCount = count($customerComments);

// Load orders for Recent Customer Orders section
$ordersFile = __DIR__ . '/../../data/orders.json';
$orders = [];
if (file_exists($ordersFile)) {
    $decodedOrders = json_decode((string) file_get_contents($ordersFile), true);
    if (is_array($decodedOrders)) {
        $orders = $decodedOrders;
    }
}
usort($orders, function ($a, $b) {
    return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
});
// Build user lookup by id
$userLookup = [];
foreach ($usersData as $u) {
    $uid = (int)($u['id'] ?? 0);
    if ($uid > 0) $userLookup[$uid] = $u;
}
?>

<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }

  body {
    background:
      radial-gradient(circle at 10% 0%, rgba(20, 184, 166, 0.07) 0%, transparent 32%),
      radial-gradient(circle at 90% 15%, rgba(245, 158, 11, 0.07) 0%, transparent 32%),
      radial-gradient(circle at 50% 90%, rgba(99, 102, 241, 0.04) 0%, transparent 40%),
      #f1f4f8;
  }

  .admin-shell { position: relative; }
  .admin-shell::before {
    content: "";
    position: fixed; inset: 0; pointer-events: none;
    background-image: linear-gradient(rgba(148,163,184,0.055) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(148,163,184,0.055) 1px, transparent 1px);
    background-size: 44px 44px;
    mask-image: radial-gradient(ellipse at 50% 40%, black 0%, transparent 72%);
    z-index: 0;
  }

  .admin-sidebar { border-right: 1px solid rgba(255,255,255,0.45); box-shadow: 0 24px 40px -32px rgba(15,23,42,0.5); }
  .admin-topbar  { border-bottom: 1px solid rgba(255,255,255,0.7); box-shadow: 0 12px 28px -24px rgba(15,23,42,0.35); }

  .admin-main { width: calc(100% - 16rem); }
  .admin-content { position: relative; z-index: 1; }

  /* KPI cards */
  .kpi-card { transition: transform .18s ease, box-shadow .18s ease; }
  .kpi-card:hover { transform: translateY(-3px); box-shadow: 0 20px 36px -18px rgba(15,23,42,0.18); }

  /* Avatar palette */
  .av-teal   { background: #0d9488; color:#fff; }
  .av-indigo { background: #4f46e5; color:#fff; }
  .av-rose   { background: #e11d48; color:#fff; }
  .av-amber  { background: #d97706; color:#fff; }
  .av-violet { background: #7c3aed; color:#fff; }
  .av-cyan   { background: #0891b2; color:#fff; }
  .av-lime   { background: #65a30d; color:#fff; }
  .av-fuchsia{ background: #c026d3; color:#fff; }

  /* Table row hover */
  .usr-row { transition: background .14s; }
  .usr-row:hover { background: #f0f9ff; }

  /* Form labels float */
  .field-wrap { position: relative; }
  .field-wrap label { position: absolute; left:3rem; top:50%; transform:translateY(-50%); font-size:.72rem; font-weight:700; color:#94a3b8; pointer-events:none; transition:.15s; letter-spacing:.04em; text-transform:uppercase; }
  .field-wrap input:focus ~ label,
  .field-wrap input:not(:placeholder-shown) ~ label,
  .field-wrap select:focus ~ label { top:.55rem; font-size:.6rem; color:#003345; }
  .field-wrap .fi { position:absolute; left:.85rem; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px; pointer-events:none; }
  .field-wrap input, .field-wrap select {
    padding: 1.4rem 1rem .55rem 3rem;
    border-radius: 1rem;
    border: 1.5px solid #e2e8f0;
    font-size: .875rem;
    background: #f8fafc;
    width: 100%;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
  }
  .field-wrap input:focus, .field-wrap select:focus { border-color:#003345; box-shadow: 0 0 0 3px rgba(0,51,69,.08); background:#fff; }
  .field-wrap select { appearance: none; }

  /* Feedback pill */
  .fb-pill-new     { background:#fef3c7; color:#92400e; }
  .fb-pill-replied { background:#d1fae5; color:#065f46; }
  .fb-pill-closed  { background:#f1f5f9; color:#475569; }

  @media (max-width: 1024px) {
    .admin-sidebar { position:static; width:100%; height:auto; margin-bottom:1rem; }
    .admin-topbar  { position:static; left:auto; right:auto; width:100%; margin:0 1rem 1rem; border-radius:1rem; }
    .admin-main { width:100%; margin-left:0; }
    .admin-content { padding-top:1.25rem; }
  }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input id="custSearch" class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-0" placeholder="Search users, emails, usernames..." type="text"/>
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

      <!-- Page Header -->
      <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
        <div>
          <div class="flex items-center gap-2 text-xs text-on-surface-variant mb-1 font-semibold">
            <span class="material-symbols-outlined text-sm">home</span>
            <span>Admin</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary">Users</span>
          </div>
          <h2 class="text-3xl font-black text-primary tracking-tight flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-primary text-white shadow-lg shadow-primary/30">
              <span class="material-symbols-outlined text-xl" style="font-variation-settings:'FILL' 1">group</span>
            </span>
            Users Management
          </h2>
          <p class="text-on-surface-variant mt-1 text-sm">Manage all registered accounts and access levels.</p>
        </div>
        <div class="flex gap-2 flex-wrap items-center">
          <button data-role-filter="all" class="role-filter-tab flex items-center gap-1.5 bg-primary text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm shadow-primary/20" type="button">
            <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">group</span>
            All <span class="bg-white/20 rounded-md px-1.5 py-0.5 text-xs"><?php echo $totalUsers; ?></span>
          </button>
          <button data-role-filter="customer" class="role-filter-tab flex items-center gap-1.5 bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors" type="button">
            <span class="material-symbols-outlined text-base">person</span>
            Customers <span class="bg-slate-100 rounded-md px-1.5 py-0.5 text-xs text-slate-500"><?php echo $customerCount; ?></span>
          </button>
          <button data-role-filter="admin" class="role-filter-tab flex items-center gap-1.5 bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors" type="button">
            <span class="material-symbols-outlined text-base">admin_panel_settings</span>
            Admins <span class="bg-slate-100 rounded-md px-1.5 py-0.5 text-xs text-slate-500"><?php echo $adminCount; ?></span>
          </button>
          <button id="exportUsersBtn" class="flex items-center gap-2 bg-secondary text-on-secondary px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-secondary/20 hover:opacity-90 transition" type="button">
            <span class="material-symbols-outlined text-base">download</span>
            Export CSV
          </button>
        </div>
      </div>

      <!-- KPI Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings:'FILL' 1">group</span>
          </div>
          <div>
            <p class="text-2xl font-black text-primary leading-none"><?php echo $totalUsers; ?></p>
            <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-wide">Total Users</p>
          </div>
        </div>
        <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-teal-600 text-2xl" style="font-variation-settings:'FILL' 1">verified_user</span>
          </div>
          <div>
            <p class="text-2xl font-black text-teal-700 leading-none"><?php echo $activeCount; ?></p>
            <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-wide">Active</p>
          </div>
        </div>
        <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-indigo-600 text-2xl" style="font-variation-settings:'FILL' 1">storefront</span>
          </div>
          <div>
            <p class="text-2xl font-black text-indigo-700 leading-none"><?php echo $customerCount; ?></p>
            <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-wide">Customers</p>
          </div>
        </div>
        <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-amber-600 text-2xl" style="font-variation-settings:'FILL' 1">rate_review</span>
          </div>
          <div>
            <p class="text-2xl font-black text-amber-700 leading-none"><?php echo $commentsCount; ?></p>
            <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-wide">Feedback</p>
          </div>
        </div>
      </div>

      <!-- Activity Overview -->
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-black text-primary flex items-center gap-2">
              <span class="material-symbols-outlined text-lg text-indigo-500" style="font-variation-settings:'FILL' 1">shopping_bag</span>
              Recent Orders
            </h3>
            <a href="/admin/orders" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">View all <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
          </div>
          <div class="divide-y divide-slate-50">
            <?php
            $recentOrders = array_slice($orders, 0, 5);
            if (empty($recentOrders)): ?>
              <div class="text-center py-10 text-slate-400">
                <span class="material-symbols-outlined text-4xl mb-2 block opacity-40">shopping_bag</span>
                <p class="text-sm font-medium">No orders yet</p>
              </div>
            <?php else: ?>
              <?php foreach ($recentOrders as $order):
                $user = $userLookup[$order['user_id']] ?? null;
                $customerName = $user ? trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) : ($order['user_email'] ?? 'Unknown');
                $customerName = trim($customerName) ?: 'Unknown';
                $orderNumber = $order['order_number'] ?? 'ORD-' . $order['id'];
                $total = (float) ($order['total'] ?? 0);
                $status = strtolower($order['status'] ?? 'pending');
                $statusColors = [
                  'completed' => 'bg-teal-50 text-teal-700',
                  'delivered' => 'bg-teal-50 text-teal-700',
                  'pending'   => 'bg-amber-50 text-amber-700',
                  'shipped'   => 'bg-indigo-50 text-indigo-700',
                  'cancelled' => 'bg-red-50 text-red-700',
                ];
                $sc = $statusColors[$status] ?? 'bg-slate-100 text-slate-600';
              ?>
              <div class="flex items-center justify-between px-6 py-3.5 hover:bg-slate-50 transition">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full av-teal flex items-center justify-center text-[10px] font-black flex-shrink-0">
                    <?php echo strtoupper(substr($customerName, 0, 1)); ?>
                  </div>
                  <div>
                    <p class="text-sm font-bold text-primary leading-tight"><?php echo htmlspecialchars($customerName); ?></p>
                    <p class="text-xs text-slate-400"><?php echo htmlspecialchars($orderNumber); ?></p>
                  </div>
                </div>
                <div class="text-right flex items-center gap-3">
                  <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-bold <?php echo $sc; ?>">
                    <?php echo ucfirst($status); ?>
                  </span>
                  <p class="text-sm font-black text-primary">$<?php echo number_format($total, 2); ?></p>
                </div>
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- Recent Feedback -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-black text-primary flex items-center gap-2">
              <span class="material-symbols-outlined text-lg text-amber-500" style="font-variation-settings:'FILL' 1">rate_review</span>
              Recent Feedback
            </h3>
            <span class="text-xs font-bold text-slate-400"><?php echo $commentsCount; ?> total</span>
          </div>
          <div class="divide-y divide-slate-50">
            <?php
            $recentComments = array_slice($customerComments, 0, 5);
            if (empty($recentComments)): ?>
              <div class="text-center py-10 text-slate-400">
                <span class="material-symbols-outlined text-4xl mb-2 block opacity-40">chat_bubble</span>
                <p class="text-sm font-medium">No feedback yet</p>
              </div>
            <?php else: ?>
              <?php foreach ($recentComments as $comment):
                $name = $comment['name'] ?? 'Anonymous';
                $message = $comment['message'] ?? '';
                $createdAt = $comment['created_at'] ?? '';
                $fStatus = $comment['status'] ?? 'new';
                $pillCls = $fStatus === 'replied' ? 'fb-pill-replied' : ($fStatus === 'closed' ? 'fb-pill-closed' : 'fb-pill-new');
              ?>
              <div class="px-6 py-3.5 hover:bg-slate-50 transition <?php echo $fStatus === 'new' ? 'border-l-4 border-amber-400' : ''; ?>">
                <div class="flex items-start justify-between gap-2 mb-1">
                  <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full av-amber flex items-center justify-center text-[10px] font-black flex-shrink-0">
                      <?php echo strtoupper(substr($name, 0, 1)); ?>
                    </div>
                    <span class="text-sm font-bold text-primary"><?php echo htmlspecialchars($name); ?></span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold <?php echo $pillCls; ?>"><?php echo ucfirst($fStatus); ?></span>
                  </div>
                  <span class="text-[10px] text-slate-400 flex-shrink-0"><?php echo $createdAt ? date('M d', strtotime($createdAt)) : ''; ?></span>
                </div>
                <p class="text-xs text-slate-500 leading-snug pl-8 line-clamp-2"><?php echo htmlspecialchars(substr($message, 0, 90)) . (strlen($message) > 90 ? '…' : ''); ?></p>
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Add New User -->
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-xl" style="font-variation-settings:'FILL' 1">person_add</span>
          </div>
          <div>
            <h3 class="text-base font-black text-primary">Add New User</h3>
            <p class="text-xs text-slate-400">Create a new customer or admin account</p>
          </div>
        </div>
        <div class="p-6">
          <form id="add-user-form" class="grid gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="field-wrap">
                <span class="material-symbols-outlined fi">alternate_email</span>
                <input id="new-username" type="text" placeholder=" " required autocomplete="off">
                <label for="new-username">Username</label>
              </div>
              <div class="field-wrap">
                <span class="material-symbols-outlined fi">mail</span>
                <input id="new-email" type="email" placeholder=" " required autocomplete="off">
                <label for="new-email">Email address</label>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="field-wrap">
                <span class="material-symbols-outlined fi">badge</span>
                <input id="new-firstname" type="text" placeholder=" " autocomplete="off">
                <label for="new-firstname">First Name</label>
              </div>
              <div class="field-wrap">
                <span class="material-symbols-outlined fi">badge</span>
                <input id="new-lastname" type="text" placeholder=" " autocomplete="off">
                <label for="new-lastname">Last Name</label>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="field-wrap">
                <span class="material-symbols-outlined fi">lock</span>
                <input id="new-password" type="password" placeholder=" " required autocomplete="new-password">
                <label for="new-password">Password</label>
              </div>
              <div class="field-wrap">
                <span class="material-symbols-outlined fi">shield_person</span>
                <select id="new-role">
                  <?php foreach ($roleOptions as $roleOption): ?>
                  <option value="<?php echo htmlspecialchars($roleOption); ?>"><?php echo htmlspecialchars(adminRoleLabel($roleOption)); ?></option>
                  <?php endforeach; ?>
                </select>
                <label for="new-role">Role</label>
              </div>
            </div>
            <div class="flex items-center gap-4 pt-1">
              <button type="submit" class="flex items-center gap-2 rounded-xl bg-primary text-white px-6 py-2.5 text-sm font-bold hover:bg-primary/90 transition shadow-md shadow-primary/20">
                <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">person_add</span>
                Create User
              </button>
              <span id="add-user-status" class="text-sm text-slate-500"></span>
            </div>
          </form>
        </div>
      </div>

      <!-- Users Table -->
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h3 class="text-base font-black text-primary flex items-center gap-2">
            <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">manage_accounts</span>
            All Users
          </h3>
          <p id="usrVisibleCount" class="text-xs font-bold text-slate-400">Showing <?php echo $totalUsers; ?> user<?php echo $totalUsers !== 1 ? 's' : ''; ?></p>
        </div>
        <div class="overflow-x-auto">
          <table id="usersTable" class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-100">
                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest w-12">#</th>
                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">User</th>
                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest hidden md:table-cell">Username</th>
                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Role</th>
                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest hidden lg:table-cell">Joined</th>
                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest hidden lg:table-cell text-center">Orders</th>
                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest hidden xl:table-cell text-right">Spend</th>
                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
              <?php
              $avPalette = ['av-teal','av-indigo','av-rose','av-amber','av-violet','av-cyan','av-lime','av-fuchsia'];
              foreach ($displayUsers as $uidx => $u):
                $avClass = $avPalette[$uidx % count($avPalette)];
              ?>
              <tr class="usr-row"
                  data-id="<?php echo (int)$u['id']; ?>"
                  data-name="<?php echo htmlspecialchars($u['name']); ?>"
                  data-email="<?php echo htmlspecialchars($u['email']); ?>"
                  data-username="<?php echo htmlspecialchars($u['username']); ?>"
                  data-role="<?php echo htmlspecialchars($u['role']); ?>"
                  data-status="<?php echo htmlspecialchars($u['status']); ?>">
                <td class="px-6 py-4 text-xs font-bold text-slate-400"><?php echo (int)$u['id']; ?></td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl <?php echo $avClass; ?> flex items-center justify-center text-[11px] font-black flex-shrink-0 shadow-sm">
                      <?php echo htmlspecialchars($u['initials']); ?>
                    </div>
                    <div class="min-w-0">
                      <p class="text-sm font-bold text-primary truncate"><?php echo htmlspecialchars($u['name']); ?></p>
                      <p class="text-xs text-slate-400 truncate"><?php echo htmlspecialchars($u['email']); ?></p>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4 hidden md:table-cell">
                  <span class="text-xs font-mono font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">@<?php echo htmlspecialchars($u['username']); ?></span>
                </td>
                <td class="px-4 py-4">
                  <?php $displayRole = strtolower((string) ($u['role'] ?? 'user')); if ($displayRole === 'customer') { $displayRole = 'user'; } ?>
                  <?php if ($displayRole === 'admin'): ?>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[11px] font-bold">
                      <span class="material-symbols-outlined text-xs" style="font-size:13px;font-variation-settings:'FILL' 1">shield</span>
                      Admin
                    </span>
                  <?php else: ?>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-bold">
                      <span class="material-symbols-outlined text-xs" style="font-size:13px;font-variation-settings:'FILL' 1">person</span>
                      <?php echo htmlspecialchars(adminRoleLabel($displayRole)); ?>
                    </span>
                  <?php endif; ?>
                </td>
                <td class="px-4 py-4 hidden lg:table-cell text-xs text-slate-500 font-medium"><?php echo htmlspecialchars($u['joined']); ?></td>
                <td class="px-4 py-4 hidden lg:table-cell text-center">
                  <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/8 text-primary text-xs font-black"><?php echo (int)$u['orders']; ?></span>
                </td>
                <td class="px-4 py-4 hidden xl:table-cell text-right text-sm font-black text-primary">$<?php echo htmlspecialchars($u['spend']); ?></td>
                <td class="px-4 py-4 text-center">
                  <?php if ($u['status'] === 'active'): ?>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-teal-50 text-teal-700 text-[11px] font-bold">
                      <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span>Active
                    </span>
                  <?php else: ?>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[11px] font-bold">
                      <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>Inactive
                    </span>
                  <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-right">
                  <?php if ($u['role'] === 'admin'): ?>
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold cursor-default">
                      <span class="material-symbols-outlined text-sm">lock</span> Protected
                    </span>
                  <?php else: ?>
                    <button onclick="deleteUser(<?php echo (int)$u['id']; ?>, '<?php echo htmlspecialchars(addslashes($u['username'])); ?>')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-red-50 text-red-600 text-xs font-bold hover:bg-red-100 transition">
                      <span class="material-symbols-outlined text-sm">delete</span> Delete
                    </button>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100">
          <p id="usrVisibleCountBottom" class="text-xs text-slate-400 font-semibold"><?php echo $totalUsers; ?> user<?php echo $totalUsers !== 1 ? 's' : ''; ?> registered</p>
        </div>
      </div>

      <!-- Customer Feedback Full List -->
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h3 class="text-base font-black text-primary flex items-center gap-2">
            <span class="material-symbols-outlined text-lg text-amber-500" style="font-variation-settings:'FILL' 1">forum</span>
            Customer Feedback
          </h3>
          <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 text-amber-700 px-3 py-1 text-xs font-bold">
            <span class="material-symbols-outlined text-sm">chat</span>
            <?php echo $commentsCount; ?> message<?php echo $commentsCount === 1 ? '' : 's'; ?>
          </span>
        </div>

        <?php if ($commentsCount === 0): ?>
          <div class="py-16 text-center text-slate-400">
            <span class="material-symbols-outlined text-5xl block opacity-30 mb-3">forum</span>
            <p class="text-sm font-semibold">No customer feedback received yet.</p>
          </div>
        <?php else: ?>
          <div class="divide-y divide-slate-50">
            <?php foreach (array_slice($customerComments, 0, 8) as $comment):
              $fStatus = $comment['status'] ?? 'new';
              $pillCls = $fStatus === 'replied' ? 'bg-teal-50 text-teal-700' : ($fStatus === 'closed' ? 'bg-slate-100 text-slate-500' : 'bg-amber-50 text-amber-700');
            ?>
            <div class="px-6 py-5 hover:bg-slate-50 transition flex flex-col sm:flex-row sm:items-start gap-4 <?php echo $fStatus === 'new' ? 'border-l-4 border-amber-400' : ''; ?>">
              <div class="w-10 h-10 rounded-xl av-amber flex items-center justify-center text-sm font-black flex-shrink-0">
                <?php echo strtoupper(substr($comment['name'] ?? 'A', 0, 1)); ?>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                  <span class="text-sm font-bold text-primary"><?php echo htmlspecialchars($comment['name'] ?? 'Anonymous'); ?></span>
                  <span class="text-xs text-slate-400"><?php echo htmlspecialchars($comment['email'] ?? ''); ?></span>
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold <?php echo $pillCls; ?>"><?php echo ucfirst($fStatus); ?></span>
                  <span class="text-[11px] text-slate-300 ml-auto"><?php echo htmlspecialchars($comment['created_at'] ?? ''); ?></span>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($comment['message'] ?? '')); ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </main>
</div>
<script>
  async function addUser(event) {
    event.preventDefault();

    const status = document.getElementById('add-user-status');
    status.textContent = '';
    status.className = 'text-sm text-slate-500';

    const payload = {
      username: document.getElementById('new-username').value.trim(),
      email: document.getElementById('new-email').value.trim(),
      first_name: document.getElementById('new-firstname').value.trim(),
      last_name: document.getElementById('new-lastname').value.trim(),
      password: document.getElementById('new-password').value,
      role: document.getElementById('new-role').value
    };

    if (!payload.username || !payload.email || !payload.password) {
      status.textContent = 'Username, email and password are required.';
      status.className = 'text-sm text-error';
      return;
    }

    try {
      const response = await fetch('/api/admin_users.php?action=add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const result = await response.json();

      if (result.status === 'success') {
        status.textContent = 'User created successfully.';
        status.className = 'text-sm text-teal-700';
        document.getElementById('add-user-form').reset();
        setTimeout(() => location.reload(), 900);
      } else {
        status.textContent = result.message || 'Could not create user.';
        status.className = 'text-sm text-error';
      }
    } catch (error) {
      status.textContent = 'There was an error saving the user.';
      status.className = 'text-sm text-error';
    }
  }

  async function deleteUser(id, username) {
    const confirm = await Swal.fire({
      title: 'Delete User?',
      html: 'Are you sure you want to delete <strong>' + username + '</strong>?<br><span class="text-sm text-slate-500">This action cannot be undone.</span>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#64748b',
      reverseButtons: true
    });
    if (!confirm.isConfirmed) return;

    try {
      const response = await fetch('/api/admin_users.php?action=delete', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      });
      const result = await response.json();

      if (result.status === 'success') {
        await Swal.fire({ title: 'Deleted!', text: 'User has been deleted.', icon: 'success', timer: 1500, showConfirmButton: false });
        location.reload();
      } else {
        Swal.fire({ title: 'Error', text: result.message || 'Could not delete user.', icon: 'error' });
      }
    } catch (error) {
      Swal.fire({ title: 'Error', text: 'There was an error deleting the user.', icon: 'error' });
    }
  }

  document.getElementById('add-user-form').addEventListener('submit', addUser);

  // ── Role filter ──────────────────────────────────────────────────────────
  var activeRoleFilter = 'all';

  function filterUsers() {
    var q = (document.getElementById('custSearch')?.value || '').toLowerCase().trim();
    var count = 0;
    document.querySelectorAll('.usr-row').forEach(function(row) {
      var role     = row.dataset.role     || '';
      var name     = row.dataset.name     || '';
      var email    = row.dataset.email    || '';
      var username = row.dataset.username || '';
      var matchRole   = activeRoleFilter === 'all' || role === activeRoleFilter;
      var matchSearch = !q || name.toLowerCase().includes(q) || email.toLowerCase().includes(q) || username.toLowerCase().includes(q);
      var visible = matchRole && matchSearch;
      row.style.display = visible ? '' : 'none';
      if (visible) count++;
    });
    var top = document.getElementById('usrVisibleCount');
    var bot = document.getElementById('usrVisibleCountBottom');
    var txt = 'Showing ' + count + ' user' + (count !== 1 ? 's' : '');
    if (top) top.textContent = txt;
    if (bot) bot.textContent = count + ' user' + (count !== 1 ? 's' : '') + ' registered';
  }

  document.querySelectorAll('.role-filter-tab').forEach(function(btn) {
    btn.addEventListener('click', function() {
      activeRoleFilter = this.dataset.roleFilter || 'all';
      document.querySelectorAll('.role-filter-tab').forEach(function(b) {
        b.classList.remove('bg-primary', 'text-white', 'shadow-sm', 'shadow-primary/20');
        b.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600', 'hover:bg-slate-50');
      });
      this.classList.add('bg-primary', 'text-white', 'shadow-sm', 'shadow-primary/20');
      this.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600', 'hover:bg-slate-50');
      filterUsers();
    });
  });

  // ── Search ────────────────────────────────────────────────────────────────
  var custSearch = document.getElementById('custSearch');
  if (custSearch) { custSearch.addEventListener('input', filterUsers); }

  // ── Export Users CSV ─────────────────────────────────────────────────────
  document.getElementById('exportUsersBtn')?.addEventListener('click', function() {
    var rows = document.querySelectorAll('.usr-row:not([style*="display: none"])');
    var csv  = ['ID,Name,Email,Username,Role,Status'];
    rows.forEach(function(row) {
      var id       = row.dataset.id       || '';
      var name     = (row.dataset.name     || '').replace(/"/g, '""');
      var email    = (row.dataset.email    || '').replace(/"/g, '""');
      var username = (row.dataset.username || '').replace(/"/g, '""');
      var role     = (row.dataset.role     || '').replace(/"/g, '""');
      var status   = (row.dataset.status   || '').replace(/"/g, '""');
      csv.push(id + ',"' + name + '","' + email + '","' + username + '","' + role + '","' + status + '"');
    });
    var a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([csv.join('\n')], { type: 'text/csv' }));
    a.download = 'users_export.csv';
    a.click();
  });
</script>
<script src="/js/admin.js"></script>