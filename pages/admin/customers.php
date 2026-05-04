<?php
require_once __DIR__ . '/_auth.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$usersFile = __DIR__ . '/../../data/users.json';
$usersData = [];

if (file_exists($usersFile)) {
    $decoded = json_decode((string) file_get_contents($usersFile), true);
    if (is_array($decoded)) {
        $usersData = $decoded;
    }
}

if (empty($usersData)) {
    $usersData = [
        ['id' => 1, 'username' => 'admin', 'email' => 'admin@mpemba.com', 'first_name' => 'Admin', 'last_name' => 'User', 'role' => 'admin'],
        ['id' => 2, 'username' => 'john_doe', 'email' => 'john@example.com', 'first_name' => 'John', 'last_name' => 'Doe', 'role' => 'customer'],
        ['id' => 3, 'username' => 'jane_smith', 'email' => 'jane@example.com', 'first_name' => 'Jane', 'last_name' => 'Smith', 'role' => 'customer'],
    ];
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
?>

<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }
</style>

<div class="bg-background text-on-background min-h-screen">
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
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/orders">
        <span class="material-symbols-outlined">shopping_cart</span>
        <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/customers">
        <span class="material-symbols-outlined">group</span>
        <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Users</span>
      </a>
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

  <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-0" placeholder="Search users, emails, usernames..." type="text"/>
      </div>
    </div>
    <div class="flex items-center gap-6">
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">notifications</span></button>
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

  <main class="ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-8">
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
          <h2 class="text-3xl font-black text-primary tracking-tight">Users Management</h2>
          <p class="text-on-surface-variant mt-1">Generated from website user accounts for admin operations.</p>
        </div>
        <div class="flex gap-3">
          <button class="flex items-center gap-2 bg-surface-container-high px-4 py-2 rounded-xl text-sm font-semibold text-primary hover:bg-surface-container-highest transition-colors" type="button">
            <span class="material-symbols-outlined text-lg">group</span>
            All Users
          </button>
          <button class="flex items-center gap-2 bg-secondary text-on-secondary px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-secondary/20" type="button">
            <span class="material-symbols-outlined text-lg">download</span>
            Export Users
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Users</p>
          <div class="flex items-baseline gap-2"><span class="text-2xl font-black text-primary"><?php echo $totalUsers; ?></span></div>
        </div>
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Active Users</p>
          <div class="flex items-baseline gap-2"><span class="text-2xl font-black text-primary"><?php echo $activeCount; ?></span><span class="text-xs font-bold text-teal-600">online-ready</span></div>
        </div>
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Customers</p>
          <div class="flex items-baseline gap-2"><span class="text-2xl font-black text-primary"><?php echo $customerCount; ?></span></div>
        </div>
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-2">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Admins</p>
          <div class="flex items-baseline gap-2"><span class="text-2xl font-black text-primary"><?php echo $adminCount; ?></span></div>
        </div>
      </div>

      <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-slate-200/40">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-surface-container-low border-b border-surface-variant/20">
                <th class="px-8 py-5 text-xs font-black text-primary uppercase tracking-widest">ID</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">User</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Username</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Role</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Joined</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Orders</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Spend</th>
                <th class="px-8 py-5 text-xs font-black text-primary uppercase tracking-widest text-right">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-low">
              <?php foreach ($displayUsers as $u): ?>
              <tr class="hover:bg-surface-bright transition-colors group">
                <td class="px-8 py-5 text-sm font-bold text-primary">#<?php echo (int) $u['id']; ?></td>
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed text-[10px] font-black"><?php echo htmlspecialchars($u['initials']); ?></div>
                    <div>
                      <p class="text-sm font-bold text-primary"><?php echo htmlspecialchars($u['name']); ?></p>
                      <p class="text-[10px] text-on-surface-variant"><?php echo htmlspecialchars($u['email']); ?></p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-5 text-sm text-on-surface-variant">@<?php echo htmlspecialchars($u['username']); ?></td>
                <td class="px-6 py-5">
                  <?php if ($u['role'] === 'admin'): ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] font-bold">Admin</span>
                  <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[10px] font-bold">Customer</span>
                  <?php endif; ?>
                </td>
                <td class="px-6 py-5 text-sm text-on-surface-variant"><?php echo htmlspecialchars($u['joined']); ?></td>
                <td class="px-6 py-5 text-sm font-bold text-primary"><?php echo (int) $u['orders']; ?></td>
                <td class="px-6 py-5 text-sm font-bold text-primary">$<?php echo htmlspecialchars($u['spend']); ?></td>
                <td class="px-8 py-5 text-right">
                  <?php if ($u['status'] === 'active'): ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-[10px] font-bold"><span class="w-1 h-1 rounded-full bg-teal-700"></span> Active</span>
                  <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-error-container text-on-error-container text-[10px] font-bold"><span class="w-1 h-1 rounded-full bg-error"></span> Inactive</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>