<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';
require_once __DIR__ . '/_permissions.php';

adminRequirePermission('manage.users');

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'permissions';
$permissions = adminLoadRolePermissions();

$permissionLabels = [
    'create' => 'Create new records and content',
    'read' => 'Read dashboard information and data',
    'update' => 'Update existing records and settings',
    'delete' => 'Delete records and content',
    'manage.users' => 'Manage users, roles, and permissions',
];

$rolePriority = [
    'admin' => 0,
    'manager' => 1,
    'editor' => 2,
    'user' => 3,
];

$roleKeys = array_keys($permissions);
usort($roleKeys, function ($a, $b) use ($rolePriority) {
    $pa = $rolePriority[$a] ?? 99;
    $pb = $rolePriority[$b] ?? 99;
    if ($pa !== $pb) {
        return $pa <=> $pb;
    }
    return strcmp($a, $b);
});

$roleColumns = [];
foreach ($roleKeys as $roleKey) {
    $label = ucwords(str_replace(['_', '-'], ' ', $roleKey));
    $roleColumns[$roleKey] = $label;
}

$usersFile = __DIR__ . '/../../data/users.json';
$users = file_exists($usersFile) ? (json_decode((string) file_get_contents($usersFile), true) ?: []) : [];
$flash = '';
$flashType = 'success';
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/admin/permissions';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'add_role') {
        $rawName = trim((string) ($_POST['new_role_name'] ?? ''));
        $newRole = strtolower(trim(preg_replace('/[^a-z0-9_]+/', '_', $rawName), '_'));
        $newRoleLabel = ucwords(str_replace(['_', '-'], ' ', $newRole));

        if ($newRole === '') {
            $flash = 'Role name is required.';
            $flashType = 'error';
        } elseif (isset($permissions[$newRole])) {
            $flash = 'That role already exists.';
            $flashType = 'error';
        } elseif ($newRole === 'customer') {
            $flash = 'Please use "user" instead of "customer" for the new role name.';
            $flashType = 'error';
        } else {
            $permissions[$newRole] = array_fill_keys(array_keys($permissionLabels), false);
            adminSaveRolePermissions($permissions);
            if ($isAjax) {
                echo json_encode(['success' => true, 'message' => 'Role "' . $newRoleLabel . '" added successfully.', 'role' => $newRole, 'label' => $newRoleLabel]);
                exit;
            }
        }
    }

    if ($action === 'save_role_permissions') {
        foreach ($permissions as $role => $rolePermissions) {
            foreach ($rolePermissions as $permission => $value) {
                $field = 'perm_' . $role . '_' . str_replace('.', '_', $permission);
                $permissions[$role][$permission] = isset($_POST[$field]);
            }
        }
        adminSaveRolePermissions($permissions);
        if ($isAjax) {
            echo json_encode(['success' => true, 'message' => 'Permissions updated successfully.']);
            exit;
        } else {
            header('Location: ' . $currentPath . '?saved=1');
            exit;
        }
    }

    if ($action === 'remove_role') {
        $roleToRemove = strtolower(trim((string) ($_POST['role'] ?? '')));
        $defaultRoles = array_keys(adminDefaultRolePermissions());
        $removeLabel = ucwords(str_replace(['_', '-'], ' ', $roleToRemove));

        if ($roleToRemove === '') {
            $flash = 'Role selection is required to remove a role.';
            $flashType = 'error';
        } elseif (!isset($permissions[$roleToRemove])) {
            $flash = 'That role does not exist.';
            $flashType = 'error';
        } elseif (in_array($roleToRemove, $defaultRoles, true)) {
            $flash = 'Default roles cannot be removed.';
            $flashType = 'error';
        } else {
            unset($permissions[$roleToRemove]);
            adminSaveRolePermissions($permissions);

            foreach ($users as &$user) {
                if (strtolower((string) ($user['role'] ?? '')) === $roleToRemove) {
                    $user['role'] = 'user';
                }
            }
            unset($user);
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            if ($isAjax) {
                echo json_encode(['success' => true, 'message' => 'Role "' . $removeLabel . '" removed successfully.', 'role' => $roleToRemove, 'label' => $removeLabel]);
                exit;
            }
        }
    }

    if ($action === 'update_user_roles') {
        $roles = $_POST['user_role'] ?? [];
        $allowedRoles = array_keys($permissions);
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
                if ($role === 'customer') {
                    $role = 'user';
                }
                $user['role'] = in_array($role, $allowedRoles, true) ? $role : 'user';
            }
            unset($user);
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        if ($isAjax) {
            echo json_encode(['success' => true, 'message' => 'User roles updated successfully.']);
            exit;
        } else {
            header('Location: ' . $currentPath . '?roles=1');
            exit;
        }
    }
}

if ($isAjax && $flashType === 'error') {
    echo json_encode(['success' => false, 'message' => $flash]);
    exit;
}

if (isset($_GET['saved'])) {
    $flash = 'Permissions updated successfully.';
}
if (isset($_GET['roles'])) {
    $flash = 'User roles updated successfully.';
}
if (isset($_GET['added'])) {
    $flash = 'Role "' . htmlspecialchars($_GET['added']) . '" added successfully.';
}
if (isset($_GET['removed'])) {
    $flash = 'Role "' . htmlspecialchars($_GET['removed']) . '" removed successfully.';
}

function userRoleLabel(string $role): string
{
    return ucwords(str_replace(['_', '-'], ' ', $role));
}
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
        <div class="p-6 space-y-8">
          <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
            <input type="hidden" name="action" value="add_role" />
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
              <div>
                <p class="text-sm font-semibold text-slate-700">Add a New Role Group</p>
                <p class="text-xs text-slate-500">Create a custom role and then assign permissions for it.</p>
              </div>
              <div class="grid gap-3 sm:grid-cols-[1fr_auto] w-full sm:w-auto items-end">
                <input name="new_role_name" type="text" placeholder="e.g. support_agent" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-3 text-sm font-bold text-white shadow-lg shadow-primary/20 hover:bg-primary/90 transition">Add Role</button>
              </div>
            </div>
          </form>

          <div class="rounded-2xl bg-white border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3 mb-4">
              <div>
                <p class="text-sm font-semibold text-slate-700">Existing Custom Roles</p>
                <p class="text-xs text-slate-500">Remove any custom role that is no longer needed.</p>
              </div>
            </div>
            <div id="customRolesGrid" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
              <?php $defaultRoles = array_keys(adminDefaultRolePermissions()); ?>
              <?php foreach ($roleColumns as $roleKey => $roleLabel): ?>
                <?php if (in_array($roleKey, $defaultRoles, true)): ?>
                  <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 text-sm font-semibold text-slate-600"><?php echo htmlspecialchars($roleLabel); ?></div>
                <?php else: ?>
                  <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 flex items-center justify-between gap-3">
                    <span class="text-sm font-semibold text-slate-700"><?php echo htmlspecialchars($roleLabel); ?></span>
                    <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="m-0">
                      <input type="hidden" name="action" value="remove_role" />
                      <input type="hidden" name="role" value="<?php echo htmlspecialchars($roleKey); ?>" />
                      <button type="submit" class="rounded-lg bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-100 transition">Remove</button>
                    </form>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>

          <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="space-y-8">
            <input type="hidden" name="action" value="save_role_permissions" />

            <div>
              <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider">
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">security</span>
                  Role Permission Matrix
                </div>
                <p class="text-xs text-slate-500">Assign Create / Read / Update / Delete / Manage Users permissions for each role.</p>
              </div>
              <div class="overflow-x-auto rounded-lg border border-slate-100 shadow-sm">
                <table id="permissionMatrixTable" class="w-full text-sm">
                  <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                      <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Permission</th>
                      <?php foreach ($roleColumns as $roleKey => $roleLabel): ?>
                      <th data-role-key="<?php echo htmlspecialchars($roleKey); ?>" class="px-5 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest w-32"><?php echo htmlspecialchars($roleLabel); ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-100">
                    <?php foreach ($permissionLabels as $permissionKey => $label): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors" data-permission-key="<?php echo htmlspecialchars($permissionKey); ?>">
                      <td class="px-5 py-3 font-medium text-slate-700"><?php echo htmlspecialchars($label); ?></td>
                      <?php foreach ($roleColumns as $roleKey => $roleLabel): ?>
                      <td class="px-5 py-3 text-center">
                        <input type="checkbox" class="w-4 h-4 accent-primary rounded cursor-pointer" name="perm_<?php echo $roleKey . '_' . str_replace('.', '_', $permissionKey); ?>" <?php echo !empty($permissions[$roleKey][$permissionKey]) ? 'checked' : ''; ?> />
                      </td>
                      <?php endforeach; ?>
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
        </div>
      </section>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
          <h3 class="font-black text-primary text-lg flex items-center gap-2">
            <span class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
              <span class="material-symbols-outlined text-purple-600" style="font-variation-settings:'FILL' 1">people</span>
            </span>
            User Roles
          </h3>
          <p class="text-xs text-slate-500 mt-2">Assign each user one of the available roles: Admin, Manager, Editor, or User.</p>
        </div>
        <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="p-6">
          <input type="hidden" name="action" value="update_user_roles" />
          <div class="overflow-x-auto rounded-lg border border-slate-100 shadow-sm">
            <table id="userRolesTable" class="w-full text-sm">
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
                    <?php $userRole = strtolower((string) ($user['role'] ?? 'user')); if ($userRole === 'customer') { $userRole = 'user'; } ?>
                    <select class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" name="user_role[<?php echo (int) ($user['id'] ?? 0); ?>]">
                      <?php foreach ($roleColumns as $roleKey => $roleLabel): ?>
                      <option value="<?php echo htmlspecialchars($roleKey); ?>" <?php echo ($userRole === $roleKey) ? 'selected' : ''; ?>><?php echo htmlspecialchars($roleLabel); ?></option>
                      <?php endforeach; ?>
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

<script>
$(document).ready(function() {
    const $formContainer = $('.admin-main');
    const $rolesGrid = $('#customRolesGrid');
    const $permissionMatrix = $('#permissionMatrixTable');
    const $userRolesTable = $('#userRolesTable');

    function normalizeRoleKey(value) {
        return value
            .toString()
            .trim()
            .toLowerCase()
            .replace(/[^a-z0-9_]+/g, '_')
            .replace(/^_+|_+$/g, '');
    }

    function addRoleCard(roleKey, roleLabel) {
        const removeForm = `
          <form method="POST" action="${window.location.pathname}" class="space-y-0 remove-role-form">
            <input type="hidden" name="action" value="remove_role" />
            <input type="hidden" name="role" value="${roleKey}" />
            <button type="submit" class="rounded-lg bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-100 transition">Remove</button>
          </form>`;

        const card = `
          <div id="role-card-${roleKey}" class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
            <p class="text-sm font-semibold text-slate-900 mb-2">${roleLabel}</p>
            <p class="text-xs text-slate-500 mb-4">Custom role</p>
            ${removeForm}
          </div>`;

        $rolesGrid.append(card);
    }

    function addRoleColumn(roleKey, roleLabel) {
        if (!$permissionMatrix.length || !$userRolesTable.length) {
            return;
        }

        // Add header cell
        $permissionMatrix.find('thead tr').append(
            `<th data-role-key="${roleKey}" class="px-5 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest w-32">${roleLabel}</th>`
        );

        // Add checkbox for every permission row
        $permissionMatrix.find('tbody tr[data-permission-key]').each(function() {
            const permissionKey = $(this).data('permission-key');
            const fieldName = `perm_${roleKey}_${permissionKey.toString().replace(/\./g, '_')}`;
            $(this).append(
                `<td class="px-5 py-3 text-center"><input type="checkbox" class="w-4 h-4 accent-primary rounded cursor-pointer" name="${fieldName}" /></td>`
            );
        });

        // Add option for each user role select
        $userRolesTable.find('select[name^="user_role["]')
            .append(`<option value="${roleKey}">${roleLabel}</option>`);
    }

    function removeRoleColumn(roleKey) {
        if (!$permissionMatrix.length || !$userRolesTable.length) {
            return;
        }

        const $header = $permissionMatrix.find(`thead tr th[data-role-key="${roleKey}"]`);
        if (!$header.length) {
            return;
        }

        const removeIndex = $header.index();
        $header.remove();

        $permissionMatrix.find('tbody tr').each(function() {
            $(this).find('td').eq(removeIndex).remove();
        });

        $userRolesTable.find(`select[name^="user_role["] option[value="${roleKey}"]`).remove();
        $(`#role-card-${roleKey}`).remove();
    }

    function showToast(message, type) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-2xl border border-slate-200 shadow-lg shadow-slate-200/40'
            }
        });
    }

    $(document).on('submit', 'form', function(e) {
        const $form = $(this);
        const action = $form.find('input[name="action"]').val();
        const $submitButton = $form.find('button[type="submit"]');

        if (!action) {
            return false;
        }

        e.preventDefault();
        e.stopImmediatePropagation();
        const formData = $form.serialize();
        $submitButton.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');

        $.ajax({
            url: window.location.pathname,
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (!response || !response.success) {
                    Swal.fire({
                        title: 'Error',
                        text: (response && response.message) ? response.message : 'An unexpected error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc2626'
                    });
                    return;
                }

                window.history.replaceState(null, '', window.location.pathname);

                if (action === 'add_role') {
                    addRoleCard(response.role, response.label || response.role);
                    addRoleColumn(response.role, response.label || response.role);
                    showToast(response.message, 'success');
                    $form.find('input[name="new_role_name"]').val('');
                    return;
                }

                if (action === 'remove_role') {
                    removeRoleColumn(response.role);
                    showToast(response.message, 'success');
                    return;
                }

                if (action === 'save_role_permissions' || action === 'update_user_roles') {
                    showToast(response.message, 'success');
                    return;
                }

                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#003345'
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc2626'
                });
            },
            complete: function() {
                $submitButton.prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
            }
        });

        return false;
    });
});
</script>
