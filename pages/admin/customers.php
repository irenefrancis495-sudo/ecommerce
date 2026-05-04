<?php
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
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
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/categories">
        <span class="material-symbols-outlined">category</span>
        <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Categories</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/orders">
        <span class="material-symbols-outlined">shopping_cart</span>
        <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/customers">
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
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/permissions">
        <span class="material-symbols-outlined">admin_panel_settings</span>
        <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Permissions</span>
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
          <button id="exportUsersBtn" class="flex items-center gap-2 bg-secondary text-on-secondary px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-secondary/20" type="button">
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
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Comments</p>
          <div class="flex items-baseline gap-2"><span class="text-2xl font-black text-primary"><?php echo $commentsCount; ?></span></div>
        </div>
      </div>

      <!-- Customer Activity Overview -->
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-surface-container-lowest p-6 rounded-3xl shadow-sm shadow-slate-200/40">
          <h3 class="text-lg font-black text-primary mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined">shopping_cart</span>
            Recent Customer Orders
          </h3>
          <div class="space-y-3">
            <?php
            $recentOrders = array_slice($orders, 0, 5); // Show last 5 orders
            if (empty($recentOrders)): ?>
              <div class="text-center py-8 text-on-surface-variant">
                <span class="material-symbols-outlined text-3xl mb-2 block">shopping_cart</span>
                <p class="text-sm">No orders yet</p>
              </div>
            <?php else: ?>
              <?php foreach ($recentOrders as $order):
                $user = $userLookup[$order['user_id']] ?? null;
                $customerName = $user ? trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) : 'Unknown';
                $orderNumber = $order['order_number'] ?? 'ORD-' . $order['id'];
                $total = (float) ($order['total'] ?? 0);
                $status = strtolower($order['status'] ?? '');
              ?>
              <div class="flex items-center justify-between p-3 bg-surface-container-high rounded-xl">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed text-xs font-black">
                    <?php echo strtoupper(substr($customerName, 0, 1)); ?>
                  </div>
                  <div>
                    <p class="text-sm font-bold text-primary"><?php echo htmlspecialchars($customerName); ?></p>
                    <p class="text-xs text-on-surface-variant"><?php echo htmlspecialchars($orderNumber); ?></p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-bold text-primary">$<?php echo number_format($total, 2); ?></p>
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold
                    <?php echo $status === 'completed' ? 'bg-teal-50 text-teal-700' : 'bg-tertiary-container text-on-tertiary-container'; ?>">
                    <?php echo ucfirst($status ?: 'pending'); ?>
                  </span>
                </div>
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- Recent Comments -->
        <div class="bg-surface-container-lowest p-6 rounded-3xl shadow-sm shadow-slate-200/40">
          <h3 class="text-lg font-black text-primary mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined">chat</span>
            Recent Customer Feedback
          </h3>
          <div class="space-y-3">
            <?php
            $recentComments = array_slice($customerComments, 0, 5); // Show last 5 comments
            if (empty($recentComments)): ?>
              <div class="text-center py-8 text-on-surface-variant">
                <span class="material-symbols-outlined text-3xl mb-2 block">chat</span>
                <p class="text-sm">No feedback yet</p>
              </div>
            <?php else: ?>
              <?php foreach ($recentComments as $comment):
                $name = $comment['name'] ?? 'Anonymous';
                $message = $comment['message'] ?? '';
                $createdAt = $comment['created_at'] ?? '';
                $status = $comment['status'] ?? 'new';
                $isNew = $status === 'new';
              ?>
              <div class="p-3 bg-surface-container-high rounded-xl <?php echo $isNew ? 'border-l-4 border-tertiary' : ''; ?>">
                <div class="flex items-start justify-between mb-2">
                  <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed text-xs font-black">
                      <?php echo strtoupper(substr($name, 0, 1)); ?>
                    </div>
                    <span class="text-sm font-bold text-primary"><?php echo htmlspecialchars($name); ?></span>
                    <?php if ($isNew): ?>
                      <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-tertiary-container text-on-tertiary-container text-xs font-bold">
                        <span class="w-1 h-1 rounded-full bg-tertiary"></span>
                        NEW
                      </span>
                    <?php endif; ?>
                  </div>
                  <span class="text-xs text-on-surface-variant"><?php echo htmlspecialchars(date('M d, H:i', strtotime($createdAt))); ?></span>
                </div>
                <p class="text-sm text-on-surface-variant line-clamp-2"><?php echo htmlspecialchars(substr($message, 0, 80) . (strlen($message) > 80 ? '...' : '')); ?></p>
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-surface-container-lowest p-6 rounded-3xl shadow-sm shadow-slate-200/40">
          <h3 class="text-lg font-black text-primary mb-4">Add New User</h3>
          <form id="add-user-form" class="grid gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <input id="new-username" type="text" placeholder="Username" class="rounded-2xl border border-surface-container-high px-4 py-3 text-sm" required>
              <input id="new-email" type="email" placeholder="Email" class="rounded-2xl border border-surface-container-high px-4 py-3 text-sm" required>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <input id="new-firstname" type="text" placeholder="First Name" class="rounded-2xl border border-surface-container-high px-4 py-3 text-sm">
              <input id="new-lastname" type="text" placeholder="Last Name" class="rounded-2xl border border-surface-container-high px-4 py-3 text-sm">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <input id="new-password" type="password" placeholder="Password" class="rounded-2xl border border-surface-container-high px-4 py-3 text-sm" required>
              <select id="new-role" class="rounded-2xl border border-surface-container-high px-4 py-3 text-sm">
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="flex items-center justify-between gap-4">
              <button type="submit" class="rounded-2xl bg-primary text-white px-6 py-3 text-sm font-semibold hover:bg-primary/90 transition">Create User</button>
              <span id="add-user-status" class="text-sm text-slate-500"></span>
            </div>
          </form>
        </div>
      </div>

      <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-slate-200/40">
        <div class="overflow-x-auto">
          <table id="usersTable" class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-surface-container-low border-b border-surface-variant/20">
                <th class="px-8 py-5 text-xs font-black text-primary uppercase tracking-widest">ID</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">User</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Username</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Role</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Joined</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Orders</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Spend</th>
                <th class="px-6 py-5 text-xs font-black text-primary uppercase tracking-widest">Action</th>
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
                <td class="px-6 py-5 text-sm text-right">
                  <?php if ($u['role'] === 'admin'): ?>
                    <button disabled class="rounded-full bg-surface-container-high text-slate-500 px-3 py-2 text-xs font-semibold">Protected</button>
                  <?php else: ?>
                    <button onclick="deleteUser(<?php echo (int) $u['id']; ?>, '<?php echo htmlspecialchars(addslashes($u['username'])); ?>')" class="rounded-full bg-error/10 text-error px-3 py-2 text-xs font-semibold hover:bg-error/20 transition">Delete</button>
                  <?php endif; ?>
                </td>
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

      <div class="mt-10 bg-surface-container-lowest rounded-3xl p-6 shadow-sm shadow-slate-200/40">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
          <div>
            <h3 class="text-xl font-black text-primary">Customer Feedback</h3>
            <p class="text-sm text-on-surface-variant">Recent messages from the website feedback form.</p>
          </div>
          <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-2 text-xs font-semibold text-primary">
            <?php echo $commentsCount; ?> message<?php echo $commentsCount === 1 ? '' : 's'; ?>
          </span>
        </div>

        <?php if ($commentsCount === 0): ?>
          <div class="rounded-3xl border border-dashed border-slate-200 bg-white/80 p-10 text-center text-slate-500">
            No customer feedback has been received yet.
          </div>
        <?php else: ?>
          <div class="space-y-4">
            <?php foreach (array_slice($customerComments, 0, 6) as $comment): ?>
              <div class="rounded-3xl border border-slate-200 bg-white/80 p-5">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                  <div>
                    <p class="text-sm font-semibold text-primary"><?php echo htmlspecialchars($comment['name'] ?? 'Anonymous'); ?> <span class="text-slate-400 font-medium">(<?php echo htmlspecialchars($comment['email'] ?? 'no-reply'); ?>)</span></p>
                    <p class="text-xs text-slate-500 mt-1"><?php echo htmlspecialchars($comment['created_at'] ?? 'Unknown'); ?></p>
                  </div>
                  <span class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-[11px] font-bold <?php echo ((isset($comment['status']) && $comment['status'] === 'new') ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600'); ?>">
                    <?php echo htmlspecialchars(ucfirst($comment['status'] ?? 'new')); ?>
                  </span>
                </div>
                <p class="mt-4 text-sm text-slate-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($comment['message'] ?? '')); ?></p>
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
    if (!confirm('Delete user "' + username + '"? This action cannot be undone.')) {
      return;
    }

    try {
      const response = await fetch('/api/admin_users.php?action=delete', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      });
      const result = await response.json();

      if (result.status === 'success') {
        alert('User deleted successfully.');
        location.reload();
      } else {
        alert(result.message || 'Could not delete user.');
      }
    } catch (error) {
      alert('There was an error deleting the user.');
    }
  }

  document.getElementById('add-user-form').addEventListener('submit', addUser);

  // ── Search ────────────────────────────────────────────────────────────────
  var custSearch = document.getElementById('custSearch');
  if (custSearch) {
    custSearch.addEventListener('input', function() {
      var q = this.value.toLowerCase().trim();
      document.querySelectorAll('#usersTable tbody tr').forEach(function(row) {
        var txt = row.textContent.toLowerCase();
        row.style.display = (!q || txt.includes(q)) ? '' : 'none';
      });
    });
  }

  // ── Export Users CSV ─────────────────────────────────────────────────────
  document.getElementById('exportUsersBtn')?.addEventListener('click', function() {
    var rows = document.querySelectorAll('#usersTable tbody tr:not([style*="display: none"])');
    var csv  = ['ID,Name,Email,Role,Status'];
    rows.forEach(function(row) {
      var cells = row.querySelectorAll('td');
      if (cells.length < 3) return;
      var name   = (cells[1]?.textContent.trim() || '').replace(/"/g,'""');
      var email  = (cells[2]?.textContent.trim() || '').replace(/"/g,'""');
      var role   = (cells[3]?.textContent.trim() || '').replace(/"/g,'""');
      var status = (cells[4]?.textContent.trim() || '').replace(/"/g,'""');
      var id     = row.dataset.id || '';
      csv.push(id + ',"' + name + '","' + email + '","' + role + '","' + status + '"');
    });
    var a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([csv.join('\n')], {type:'text/csv'}));
    a.download = 'users.csv'; a.click();
  });
</script>
<script src="/js/admin.js"></script>