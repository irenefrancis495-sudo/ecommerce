<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';
require_once __DIR__ . '/_permissions.php';

adminRequirePermission('permissions.manage');

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$permissions = adminLoadRolePermissions();
$usersFile = __DIR__ . '/../../data/users.json';
$users = file_exists($usersFile) ? (json_decode((string) file_get_contents($usersFile), true) ?: []) : [];
$flash = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'save_role_permissions') {
        foreach ($permissions as $role => $rolePermissions) {
            foreach ($rolePermissions as $permission => $value) {
                $field = 'perm_' . $role . '_' . str_replace('.', '_', $permission);
                $permissions[$role][$permission] = isset($_POST[$field]);
            }
        }
        adminSaveRolePermissions($permissions);
        header('Location: /admin/permissions?saved=1');
        exit;
    }

    if ($action === 'update_user_roles') {
        $roles = $_POST['user_role'] ?? [];
        if (is_array($roles)) {
            foreach ($users as &$user) {
                $uid = (int) ($user['id'] ?? 0);
                if ($uid <= 0) {
                    continue;
                }
                if (!isset($roles[$uid])) {
                    continue;
                }
                $role = strtolower((string) $roles[$uid]);
                $user['role'] = $role === 'admin' ? 'admin' : 'customer';
            }
            unset($user);
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        header('Location: /admin/permissions?roles=1');
        exit;
    }
}

if (isset($_GET['saved'])) {
    $flash = 'Permissions updated successfully.';
}
if (isset($_GET['roles'])) {
    $flash = 'User roles updated successfully.';
}

$permissionLabels = [
    'dashboard.view' => 'Dashboard',
    'inventory.manage' => 'Inventory + Add Product',
    'categories.manage' => 'Categories',
    'orders.manage' => 'Orders',
    'users.manage' => 'Users',
    'feedback.manage' => 'Feedback',
    'messages.manage' => 'Messages',
    'subscribers.manage' => 'Subscribers',
    'reports.view' => 'Reports',
    'settings.manage' => 'Settings',
    'permissions.manage' => 'Permissions Management',
];
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
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/index"><span class="material-symbols-outlined">dashboard</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Dashboard</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/inventory"><span class="material-symbols-outlined">inventory_2</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Inventory</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/categories"><span class="material-symbols-outlined">category</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Categories</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/orders"><span class="material-symbols-outlined">shopping_cart</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/customers"><span class="material-symbols-outlined">group</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Users</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/feedback"><span class="material-symbols-outlined">chat</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Feedback</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/messages"><span class="material-symbols-outlined">mail</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Messages</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/subscribers"><span class="material-symbols-outlined">mark_email_read</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Subscribers</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/reports"><span class="material-symbols-outlined">analytics</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Analytics</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/settings"><span class="material-symbols-outlined">settings</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Settings</span></a>
      <a class="flex items-center gap-3 px-4 py-3 bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/permissions"><span class="material-symbols-outlined">admin_panel_settings</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Permissions</span></a>
    </nav>
  </aside>

  <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <h2 class="font-black text-primary text-xl tracking-tight">Role & Permission Manager</h2>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications"><span class="material-symbols-outlined">notifications</span><?php if ($notificationCount > 0): ?><span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span><?php endif; ?></a>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right"><p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p><p class="text-[10px] text-slate-400">Operations Lead</p></div>
      </div>
    </div>
  </header>

  <main class="ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-6">
      <?php if ($flash !== ''): ?>
      <div class="px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold"><?php echo htmlspecialchars($flash); ?></div>
      <?php endif; ?>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
          <h3 class="font-black text-on-surface text-lg">Role Permissions</h3>
          <p class="text-xs text-slate-500 mt-1">Control what each role can access in admin panel.</p>
        </div>
        <form method="POST" class="p-5">
          <input type="hidden" name="action" value="save_role_permissions" />
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                  <th class="p-3 text-left">Permission</th>
                  <th class="p-3 text-center">Admin</th>
                  <th class="p-3 text-center">Customer</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <?php foreach ($permissionLabels as $permissionKey => $label): ?>
                <tr>
                  <td class="p-3 font-semibold text-slate-700"><?php echo htmlspecialchars($label); ?></td>
                  <td class="p-3 text-center"><input type="checkbox" name="perm_admin_<?php echo str_replace('.', '_', $permissionKey); ?>" <?php echo !empty($permissions['admin'][$permissionKey]) ? 'checked' : ''; ?> /></td>
                  <td class="p-3 text-center"><input type="checkbox" name="perm_customer_<?php echo str_replace('.', '_', $permissionKey); ?>" <?php echo !empty($permissions['customer'][$permissionKey]) ? 'checked' : ''; ?> /></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="pt-4 flex justify-end">
            <button class="px-5 py-2.5 bg-primary text-white rounded-xl font-bold text-sm" type="submit">Save Permissions</button>
          </div>
        </form>
      </section>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
          <h3 class="font-black text-on-surface text-lg">User Roles</h3>
          <p class="text-xs text-slate-500 mt-1">Assign each user as customer or admin.</p>
        </div>
        <form method="POST" class="p-5">
          <input type="hidden" name="action" value="update_user_roles" />
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                  <th class="p-3 text-left">Username</th>
                  <th class="p-3 text-left">Email</th>
                  <th class="p-3 text-left">Role</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <?php foreach ($users as $user): ?>
                <tr>
                  <td class="p-3 font-semibold text-slate-700"><?php echo htmlspecialchars((string) ($user['username'] ?? '-')); ?></td>
                  <td class="p-3 text-slate-600"><?php echo htmlspecialchars((string) ($user['email'] ?? '-')); ?></td>
                  <td class="p-3">
                    <select class="rounded-lg border-slate-200" name="user_role[<?php echo (int) ($user['id'] ?? 0); ?>]">
                      <option value="customer" <?php echo (($user['role'] ?? 'customer') === 'customer') ? 'selected' : ''; ?>>Customer</option>
                      <option value="admin" <?php echo (($user['role'] ?? 'customer') === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="pt-4 flex justify-end">
            <button class="px-5 py-2.5 bg-primary text-white rounded-xl font-bold text-sm" type="submit">Save User Roles</button>
          </div>
        </form>
      </section>
    </div>
  </main>
</div>
