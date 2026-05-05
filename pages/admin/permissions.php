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
$activePage = 'permissions';
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

// Admin panel permissions group
$adminPermissionLabels = [
    'dashboard.view'    => 'View Dashboard',
    'inventory.manage'  => 'Manage Inventory & Add Products',
    'categories.manage' => 'Manage Categories',
    'orders.manage'     => 'Manage Orders',
    'users.manage'      => 'Manage Users',
    'feedback.manage'   => 'Manage Feedback',
    'messages.manage'   => 'Manage Messages',
    'subscribers.manage'=> 'Manage Subscribers',
    'reports.view'      => 'View Reports & Analytics',
    'settings.manage'   => 'Manage Settings',
    'permissions.manage'=> 'Manage Roles & Permissions',
];

// Customer storefront permissions group
$customerPermissionLabels = [
    'shop.browse'   => 'Browse Products & Categories',
    'shop.cart'     => 'Add to Cart & Manage Cart',
    'shop.checkout' => 'Checkout & View Payment Methods',
    'shop.orders'   => 'View Own Order History & Status',
    'shop.profile'  => 'View & Edit My Account Profile',
    'shop.reviews'  => 'Submit Product Reviews & Feedback',
];

$permissionLabels = array_merge($adminPermissionLabels, $customerPermissionLabels);
?>
<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }

  body {
    background:
      radial-gradient(circle at 10% 0%, rgba(20, 184, 166, 0.08) 0%, transparent 30%),
      radial-gradient(circle at 100% 20%, rgba(245, 158, 11, 0.08) 0%, transparent 35%),
      #f5f7fb;
  }

  .admin-shell { position: relative; }
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

  .admin-main { width: calc(100% - 16rem); }
  .admin-content { position: relative; z-index: 1; }

  @media (max-width: 1024px) {
    .admin-sidebar { position: static; width: 100%; height: auto; margin-bottom: 1rem; }
    .admin-topbar { position: static; left: auto; right: auto; width: 100%; margin: 0 1rem 1rem; border-radius: 1rem; }
    .admin-main { width: 100%; margin-left: 0; }
    .admin-content { padding-top: 1.25rem; }
  }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <h2 class="font-black text-primary text-xl tracking-tight">Role & Permission Manager</h2>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications"><span class="material-symbols-outlined">notifications</span><?php if ($notificationCount > 0): ?><span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span><?php endif; ?></a>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right"><p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p><p class="text-[10px] text-slate-400">Operations Lead</p></div>
      </div>
    </div>
  </header>

  <main class="admin-main admin-content ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-8">
      <div>
        <h2 class="text-3xl font-black text-primary tracking-tight flex items-center gap-2">
          <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">admin_panel_settings</span>
          Permissions & Roles
        </h2>
        <p class="text-slate-500 mt-1">Manage role-based access control (RBAC) and assign user permissions</p>
      </div>

      <?php if ($flash !== ''): ?>
      <div class="px-4 py-3 rounded-lg text-sm font-semibold flex items-center gap-3 bg-emerald-50 text-emerald-700 border border-emerald-200">
        <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">check_circle</span>
        <?php echo htmlspecialchars($flash); ?>
      </div>
      <?php endif; ?>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
          <h3 class="font-black text-primary text-lg flex items-center gap-2">
            <span class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
              <span class="material-symbols-outlined text-blue-600" style="font-variation-settings:'FILL' 1">security</span>
            </span>
            Role Permissions
          </h3>
          <p class="text-xs text-slate-500 mt-2">Control what each role can access. Changes take effect immediately after saving.</p>
        </div>
        <form method="POST" class="p-6 space-y-8">
          <input type="hidden" name="action" value="save_role_permissions" />

          <!-- Admin Panel Permissions -->
          <div>
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100">
              <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">dashboard</span>
                Admin Panel Access
              </div>
              <p class="text-xs text-slate-500">Controls which roles can view/manage sections inside the admin dashboard</p>
            </div>
            <div class="overflow-x-auto rounded-lg border border-slate-100 shadow-sm">
              <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                  <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Permission</th>
                    <th class="px-5 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest w-24">Admin</th>
                    <th class="px-5 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest w-24">Customer</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                  <?php foreach ($adminPermissionLabels as $permissionKey => $label): ?>
                  <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3 font-medium text-slate-700"><?php echo htmlspecialchars($label); ?></td>
                    <td class="px-5 py-3 text-center">
                      <input type="checkbox" class="w-4 h-4 accent-primary rounded cursor-pointer" name="perm_admin_<?php echo str_replace('.', '_', $permissionKey); ?>" <?php echo !empty($permissions['admin'][$permissionKey]) ? 'checked' : ''; ?> />
                    </td>
                    <td class="px-5 py-3 text-center">
                      <input type="checkbox" class="w-4 h-4 accent-amber-600 rounded cursor-pointer" name="perm_customer_<?php echo str_replace('.', '_', $permissionKey); ?>" <?php echo !empty($permissions['customer'][$permissionKey]) ? 'checked' : ''; ?> />
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Customer Storefront Permissions -->
          <div>
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100">
              <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 text-xs font-bold uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">shopping_bag</span>
                Storefront Access
              </div>
              <p class="text-xs text-slate-500">Controls what customers (and admins acting as customers) can do on the shop</p>
            </div>
            <div class="overflow-x-auto rounded-lg border border-slate-100 shadow-sm">
              <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                  <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Permission</th>
                    <th class="px-5 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest w-24">Admin</th>
                    <th class="px-5 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest w-24">Customer</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                  <?php foreach ($customerPermissionLabels as $permissionKey => $label): ?>
                  <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3 font-medium text-slate-700"><?php echo htmlspecialchars($label); ?></td>
                    <td class="px-5 py-3 text-center">
                      <input type="checkbox" class="w-4 h-4 accent-primary rounded cursor-pointer" name="perm_admin_<?php echo str_replace('.', '_', $permissionKey); ?>" <?php echo !empty($permissions['admin'][$permissionKey]) ? 'checked' : ''; ?> />
                    </td>
                    <td class="px-5 py-3 text-center">
                      <input type="checkbox" class="w-4 h-4 accent-amber-600 rounded cursor-pointer" name="perm_customer_<?php echo str_replace('.', '_', $permissionKey); ?>" <?php echo !empty($permissions['customer'][$permissionKey]) ? 'checked' : ''; ?> />
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="pt-4 flex justify-end">
            <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-bold text-sm shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-200 flex items-center gap-2" type="submit">
              <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">save</span>
              Save All Permissions
            </button>
          </div>
        </form>
      </section>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
          <h3 class="font-black text-primary text-lg flex items-center gap-2">
            <span class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
              <span class="material-symbols-outlined text-purple-600" style="font-variation-settings:'FILL' 1">people</span>
            </span>
            User Roles
          </h3>
          <p class="text-xs text-slate-500 mt-2">Assign each user as customer or admin. Admins get full access to the dashboard.</p>
        </div>
        <form method="POST" class="p-6">
          <input type="hidden" name="action" value="update_user_roles" />
          <div class="overflow-x-auto rounded-lg border border-slate-100 shadow-sm">
            <table class="w-full text-sm">
              <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                  <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Username</th>
                  <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Email</th>
                  <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest w-40">Role</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <?php foreach ($users as $user): ?>
                <tr class="hover:bg-slate-50/60 transition-colors">
                  <td class="px-5 py-3 font-bold text-slate-700"><?php echo htmlspecialchars((string) ($user['username'] ?? '-')); ?></td>
                  <td class="px-5 py-3 text-slate-600 text-xs"><?php echo htmlspecialchars((string) ($user['email'] ?? '-')); ?></td>
                  <td class="px-5 py-3">
                    <select class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" name="user_role[<?php echo (int) ($user['id'] ?? 0); ?>]">
                      <option value="customer" <?php echo (($user['role'] ?? 'customer') === 'customer') ? 'selected' : ''; ?>>👤 Customer</option>
                      <option value="admin" <?php echo (($user['role'] ?? 'customer') === 'admin') ? 'selected' : ''; ?>>⚙️ Admin</option>
                    </select>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="pt-5 flex justify-end">
            <button class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg font-bold text-sm shadow-lg shadow-purple-500/20 hover:shadow-xl hover:shadow-purple-500/30 transition-all duration-200 flex items-center gap-2" type="submit">
              <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">save</span>
              Save User Roles
            </button>
          </div>
        </form>
      </section>
    </div>
  </main>
</div>
