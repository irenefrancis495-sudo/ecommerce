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
$roleStatus = adminLoadRoleStatus();

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
  if (!array_key_exists($roleKey, $roleStatus)) {
    $roleStatus[$roleKey] = true;
  }
}
adminSaveRoleStatus($roleStatus);

$defaultRoles = array_keys(adminDefaultRolePermissions());
$deletedDefaultRoles = adminLoadDeletedDefaultRoles();

$totalRoleGroups = count($roleColumns);
$enabledRoleGroups = count(array_filter($roleStatus, function ($enabled) {
  return (bool) $enabled;
}));
$disabledRoleGroups = max(0, $totalRoleGroups - $enabledRoleGroups);
$customRoleGroups = count(array_filter(array_keys($roleColumns), function ($roleKey) use ($defaultRoles) {
  return !in_array($roleKey, $defaultRoles, true);
}));

$usersFile = __DIR__ . '/../../data/users.json';
$users = file_exists($usersFile) ? (json_decode((string) file_get_contents($usersFile), true) ?: []) : [];
$actorIdentity = [
  'name' => (string) ($_SESSION['admin_user']['name'] ?? 'Admin'),
  'username' => (string) ($_SESSION['admin_user']['username'] ?? 'admin'),
  'email' => (string) ($_SESSION['admin_user']['email'] ?? ''),
];
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
      $defaultTemplates = adminDefaultRolePermissions();

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
          $permissions[$newRole] = isset($defaultTemplates[$newRole])
            ? $defaultTemplates[$newRole]
            : array_fill_keys(array_keys($permissionLabels), false);
            adminSaveRolePermissions($permissions);
          $roleStatus[$newRole] = true;
          adminSaveRoleStatus($roleStatus);

          if (in_array($newRole, $deletedDefaultRoles, true)) {
            $deletedDefaultRoles = array_values(array_filter($deletedDefaultRoles, function ($role) use ($newRole) {
              return $role !== $newRole;
            }));
            adminSaveDeletedDefaultRoles($deletedDefaultRoles);
          }

          adminAppendRoleAudit('add', $newRole, [
            'label' => $newRoleLabel,
          ], $actorIdentity);
            if ($isAjax) {
                echo json_encode(['success' => true, 'message' => 'Role "' . $newRoleLabel . '" added successfully.', 'role' => $newRole, 'label' => $newRoleLabel]);
                exit;
            }

          header('Location: ' . $currentPath . '?added=' . rawurlencode($newRoleLabel));
          exit;
        }
    }

    if ($action === 'save_role_permissions') {
        foreach ($permissions as $role => $rolePermissions) {
        if (empty($roleStatus[$role])) {
          continue;
        }
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
        $removeLabel = ucwords(str_replace(['_', '-'], ' ', $roleToRemove));

        if ($roleToRemove === '') {
            $flash = 'Role selection is required to remove a role.';
            $flashType = 'error';
        } elseif (!isset($permissions[$roleToRemove])) {
            $flash = 'That role does not exist.';
            $flashType = 'error';
        } elseif ($roleToRemove === 'admin') {
          $flash = 'Admin role cannot be removed.';
            $flashType = 'error';
        } else {
          $wasDefault = in_array($roleToRemove, $defaultRoles, true);
            unset($permissions[$roleToRemove]);
            adminSaveRolePermissions($permissions);
          unset($roleStatus[$roleToRemove]);
          adminSaveRoleStatus($roleStatus);

          if ($wasDefault && !in_array($roleToRemove, $deletedDefaultRoles, true)) {
            $deletedDefaultRoles[] = $roleToRemove;
            adminSaveDeletedDefaultRoles($deletedDefaultRoles);
          }
          adminAppendRoleAudit('delete', $roleToRemove, [
            'label' => $removeLabel,
            'default_role' => $wasDefault,
          ], $actorIdentity);

          $fallbackRole = adminGetFallbackRole($roleStatus);

            foreach ($users as &$user) {
                if (strtolower((string) ($user['role'] ?? '')) === $roleToRemove) {
              $user['role'] = $fallbackRole;
                }
            }
            unset($user);
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            if ($isAjax) {
                echo json_encode(['success' => true, 'message' => 'Role "' . $removeLabel . '" removed successfully.', 'role' => $roleToRemove, 'label' => $removeLabel]);
                exit;
            }

          header('Location: ' . $currentPath . '?removed=' . rawurlencode($removeLabel));
          exit;
        }
    }

        if ($action === 'toggle_role_state') {
          $roleKey = strtolower(trim((string) ($_POST['role'] ?? '')));
          $requestedState = strtolower(trim((string) ($_POST['state'] ?? '')));

          if ($roleKey === '' || !isset($permissions[$roleKey])) {
            $flash = 'Selected role does not exist.';
            $flashType = 'error';
          } elseif (!in_array($requestedState, ['enable', 'disable'], true)) {
            $flash = 'Invalid role state request.';
            $flashType = 'error';
          } elseif ($roleKey === 'admin' && $requestedState === 'disable') {
            $flash = 'Admin role group cannot be disabled.';
            $flashType = 'error';
          } else {
            $enabled = $requestedState === 'enable';
            $roleStatus[$roleKey] = $enabled;
            adminSaveRoleStatus($roleStatus);

            if (!$enabled) {
              $fallbackRole = adminGetFallbackRole($roleStatus);
              foreach ($users as &$user) {
                $userRole = strtolower((string) ($user['role'] ?? 'user'));
                if ($userRole === $roleKey) {
                  $user['role'] = $fallbackRole;
                }
              }
              unset($user);
              file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            }

            $roleLabel = ucwords(str_replace(['_', '-'], ' ', $roleKey));
            $message = $enabled
              ? 'Role "' . $roleLabel . '" enabled successfully.'
              : 'Role "' . $roleLabel . '" disabled successfully.';
            adminAppendRoleAudit($enabled ? 'enable' : 'disable', $roleKey, [
                'label' => $roleLabel,
            ], $actorIdentity);

            if ($isAjax) {
              echo json_encode([
                'success' => true,
                'message' => $message,
                'role' => $roleKey,
                'enabled' => $enabled,
              ]);
              exit;
            }

            header('Location: ' . $currentPath . '?role_state=' . ($enabled ? 'enabled' : 'disabled'));
            exit;
          }
        }

        if ($action === 'bulk_role_state') {
          $requestedState = strtolower(trim((string) ($_POST['bulk_state'] ?? '')));
          $selectedRoles = $_POST['bulk_roles'] ?? [];

          if (!is_array($selectedRoles) || empty($selectedRoles)) {
            $flash = 'Select at least one role group for bulk action.';
            $flashType = 'error';
          } elseif (!in_array($requestedState, ['enable', 'disable', 'delete'], true)) {
            $flash = 'Invalid bulk action selected.';
            $flashType = 'error';
          } else {
            $normalizedRoles = [];
            foreach ($selectedRoles as $roleKeyRaw) {
              $roleKey = strtolower(trim((string) $roleKeyRaw));
              if ($roleKey !== '' && isset($permissions[$roleKey])) {
                $normalizedRoles[] = $roleKey;
              }
            }
            $normalizedRoles = array_values(array_unique($normalizedRoles));

            if (empty($normalizedRoles)) {
              $flash = 'Selected role groups were not valid.';
              $flashType = 'error';
            } else {
              $processed = [];
              $skipped = [];
              $fallbackRole = adminGetFallbackRole($roleStatus);

              foreach ($normalizedRoles as $roleKey) {
                $isDefaultRole = in_array($roleKey, $defaultRoles, true);

                if ($roleKey === 'admin' && in_array($requestedState, ['disable', 'delete'], true)) {
                  $skipped[] = $roleKey;
                  continue;
                }

                if ($requestedState === 'delete' && $isDefaultRole) {
                  if ($roleKey === 'admin') {
                    $skipped[] = $roleKey;
                    continue;
                  }
                }

                if ($requestedState === 'delete') {
                  unset($permissions[$roleKey]);
                  unset($roleStatus[$roleKey]);
                  if ($isDefaultRole && !in_array($roleKey, $deletedDefaultRoles, true)) {
                    $deletedDefaultRoles[] = $roleKey;
                  }
                  foreach ($users as &$user) {
                    if (strtolower((string) ($user['role'] ?? '')) === $roleKey) {
                      $user['role'] = $fallbackRole;
                    }
                  }
                  unset($user);
                }

                if ($requestedState === 'enable') {
                  $roleStatus[$roleKey] = true;
                }

                if ($requestedState === 'disable') {
                  $roleStatus[$roleKey] = false;
                  $fallbackRole = adminGetFallbackRole($roleStatus);
                  foreach ($users as &$user) {
                    if (strtolower((string) ($user['role'] ?? '')) === $roleKey) {
                      $user['role'] = $fallbackRole;
                    }
                  }
                  unset($user);
                }

                $processed[] = $roleKey;
              }

              adminSaveRolePermissions($permissions);
              adminSaveRoleStatus($roleStatus);
                adminSaveDeletedDefaultRoles($deletedDefaultRoles);
              file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

              foreach ($processed as $roleKey) {
                adminAppendRoleAudit('bulk-' . $requestedState, $roleKey, [
                  'bulk' => true,
                  'selected_count' => count($normalizedRoles),
                ], $actorIdentity);
              }

              $message = 'Bulk action complete: ' . count($processed) . ' role(s) processed.';
              if (!empty($skipped)) {
                $message .= ' Skipped: ' . implode(', ', $skipped) . '.';
              }

              if ($isAjax) {
                echo json_encode([
                  'success' => true,
                  'message' => $message,
                  'processed' => $processed,
                  'skipped' => $skipped,
                ]);
                exit;
              }

              header('Location: ' . $currentPath . '?bulk=1');
              exit;
            }
          }
        }

    if ($action === 'update_user_roles') {
        $roles = $_POST['user_role'] ?? [];
          $allowedRoles = array_keys(array_filter($roleStatus, function ($enabled) {
            return (bool) $enabled;
          }));
        $fallbackRole = adminGetFallbackRole($roleStatus);
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
                $user['role'] = in_array($role, $allowedRoles, true) ? $role : $fallbackRole;
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
if (isset($_GET['role_state'])) {
  $flash = $_GET['role_state'] === 'enabled'
    ? 'Role group enabled successfully.'
    : 'Role group disabled successfully.';
}
if (isset($_GET['bulk'])) {
    $flash = 'Bulk role action completed successfully.';
}

function userRoleLabel(string $role): string
{
    return ucwords(str_replace(['_', '-'], ' ', $role));
}

function roleAuditActionLabel(string $action): string
{
  $labels = [
    'add' => 'Added',
    'delete' => 'Deleted',
    'enable' => 'Enabled',
    'disable' => 'Disabled',
    'bulk-enable' => 'Bulk Enabled',
    'bulk-disable' => 'Bulk Disabled',
    'bulk-delete' => 'Bulk Deleted',
  ];
  return $labels[$action] ?? ucwords(str_replace('-', ' ', $action));
}

$roleAuditEntries = array_reverse(adminLoadRoleAuditLog());
$roleAuditEntries = array_slice($roleAuditEntries, 0, 25);
?>
<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }

  body {
    background:
      radial-gradient(ellipse at 0% 0%, rgba(20, 184, 166, 0.10) 0%, transparent 40%),
      radial-gradient(ellipse at 100% 15%, rgba(99, 102, 241, 0.07) 0%, transparent 40%),
      radial-gradient(ellipse at 50% 90%, rgba(245, 158, 11, 0.06) 0%, transparent 40%),
      #f0f4f8;
  }

  .admin-shell { position: relative; }
  .admin-shell::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background-image: linear-gradient(rgba(148, 163, 184, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.05) 1px, transparent 1px);
    background-size: 40px 40px;
    mask-image: radial-gradient(ellipse 80% 80% at center, black, transparent 75%);
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

  /* ── Stat Cards ─────────────────────────────────────────── */
  .perm-stat-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 1.1rem;
    padding: 1.2rem 1.4rem;
    box-shadow: 0 4px 20px -8px rgba(15, 23, 42, 0.10);
    position: relative;
    overflow: hidden;
    transition: transform .18s ease, box-shadow .18s ease;
  }
  .perm-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px -12px rgba(15, 23, 42, 0.18);
  }
  .perm-stat-card::after {
    content: "";
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 0 0 1.1rem 1.1rem;
  }
  .perm-stat-card.stat-total::after   { background: linear-gradient(90deg, #0ea5e9, #14b8a6); }
  .perm-stat-card.stat-enabled::after { background: linear-gradient(90deg, #10b981, #34d399); }
  .perm-stat-card.stat-disabled::after{ background: linear-gradient(90deg, #f59e0b, #fbbf24); }
  .perm-stat-card.stat-custom::after  { background: linear-gradient(90deg, #6366f1, #a78bfa); }

  /* ── Role Cards ─────────────────────────────────────────── */
  .perm-role-card {
    border-radius: 1rem;
    border: 1px solid #e2e8f0;
    background: #fff;
    box-shadow: 0 2px 12px -4px rgba(15, 23, 42, 0.10);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    overflow: hidden;
  }
  .perm-role-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px -8px rgba(15, 23, 42, 0.18);
    border-color: #cbd5e1;
  }
  .perm-role-card.role-disabled { background: #fffbeb; border-color: #fde68a; }
  .perm-role-card.role-admin    { background: linear-gradient(150deg, #f0fdf4 0%, #f8fafc 100%); border-color: #bbf7d0; }
  .perm-role-card-top {
    padding: 0.9rem 1rem 0.7rem;
    border-bottom: 1px solid #f1f5f9;
  }
  .perm-role-card-actions {
    padding: 0.6rem 1rem;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.4rem;
  }
  .perm-role-card.role-disabled .perm-role-card-actions { background: #fefce8; }

  /* ── Permission Matrix ──────────────────────────────────── */
  .perm-matrix-wrap {
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    box-shadow: 0 4px 20px -12px rgba(15, 23, 42, 0.18);
    overflow: auto;
    max-height: 540px;
  }

  #permissionMatrixTable thead th {
    position: sticky;
    top: 0;
    z-index: 2;
    backdrop-filter: blur(8px);
  }

  #permissionMatrixTable thead th:first-child,
  #permissionMatrixTable tbody td:first-child {
    position: sticky;
    left: 0;
    z-index: 1;
    background: #f8fafc;
  }

  #permissionMatrixTable thead th:first-child {
    z-index: 3;
  }

  #permissionMatrixTable thead th[data-role-enabled="0"] {
    background: #fffbeb;
    color: #b45309;
  }

  #permissionMatrixTable tbody tr:hover td { background: #f0fdf4; }

  .perm-bulk-form {
    background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #dbe3ec;
    border-radius: 0.9rem;
  }

  .perm-sticky-actions {
    position: sticky;
    bottom: 0;
    z-index: 2;
    background: linear-gradient(180deg, rgba(248, 250, 252, 0.88), rgba(248, 250, 252, 1));
    border-top: 1px solid #e2e8f0;
    margin-inline: -1.5rem;
    padding: 0.9rem 1.5rem;
  }

  .perm-field-focus:focus {
    box-shadow: 0 0 0 3px rgba(0, 51, 69, 0.14);
  }

  /* ── Audit Timeline ──────────────────────────────────────── */
  .audit-timeline { position: relative; padding-left: 2.5rem; }
  .audit-timeline::before {
    content: "";
    position: absolute;
    left: 0.85rem; top: 0; bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #e2e8f0 0%, transparent 100%);
  }
  .audit-timeline-item {
    position: relative;
    padding-bottom: 1.1rem;
  }
  .audit-timeline-item:last-child { padding-bottom: 0; }
  .audit-timeline-dot {
    position: absolute;
    left: -2rem;
    top: 0.2rem;
    width: 1.25rem; height: 1.25rem;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e2e8f0;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
  }

  /* ── Page Hero ──────────────────────────────────────────── */
  .perm-hero {
    background: linear-gradient(135deg, #003345 0%, #065e5e 55%, #0d9488 100%);
    border-radius: 1.25rem;
    padding: 1.75rem 2rem;
    position: relative;
    overflow: hidden;
  }
  .perm-hero::after {
    content: "";
    position: absolute;
    top: -40px; right: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
  }
  .perm-hero::before {
    content: "";
    position: absolute;
    bottom: -30px; right: 80px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
  }

  /* ── Section header accent ───────────────────────────────── */
  .section-accent {
    display: inline-block;
    width: 3px; height: 1.1rem;
    border-radius: 2px;
    margin-right: 0.5rem;
    vertical-align: middle;
  }

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
    <div class="max-w-6xl mx-auto space-y-7">

      <!-- Hero Header -->
      <div class="perm-hero shadow-xl shadow-teal-900/20">
        <div class="relative z-10 flex items-center justify-between gap-4 flex-wrap">
          <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center flex-shrink-0 ring-1 ring-white/20">
              <span class="material-symbols-outlined text-3xl text-white" style="font-variation-settings:'FILL' 1">admin_panel_settings</span>
            </div>
            <div>
              <h2 class="text-2xl font-black text-white tracking-tight leading-tight">Permissions & Roles</h2>
              <p class="text-teal-200 text-xs mt-0.5 font-medium">Role-based access control (RBAC) — manage who can do what across the system</p>
            </div>
          </div>
          <div class="flex items-center gap-2 flex-wrap">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 text-white text-xs font-semibold ring-1 ring-white/20">
              <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">groups</span>
              <?php echo number_format($totalRoleGroups); ?> Role Groups
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-500/20 text-emerald-200 text-xs font-semibold ring-1 ring-emerald-400/30">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
              <?php echo number_format($enabledRoleGroups); ?> Active
            </span>
          </div>
        </div>
      </div>

      <!-- Stat Cards -->
      <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="perm-stat-card stat-total">
          <div class="flex items-start justify-between gap-2">
            <div>
              <p class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Role Groups</p>
              <p class="text-3xl font-black text-slate-800 mt-1 leading-none"><?php echo number_format($totalRoleGroups); ?></p>
              <p class="text-xs text-slate-400 mt-1">Total defined</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-sky-500 text-xl" style="font-variation-settings:'FILL' 1">layers</span>
            </div>
          </div>
        </div>
        <div class="perm-stat-card stat-enabled">
          <div class="flex items-start justify-between gap-2">
            <div>
              <p class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Enabled</p>
              <p class="text-3xl font-black text-emerald-700 mt-1 leading-none"><?php echo number_format($enabledRoleGroups); ?></p>
              <p class="text-xs text-slate-400 mt-1">Active roles</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-emerald-500 text-xl" style="font-variation-settings:'FILL' 1">check_circle</span>
            </div>
          </div>
        </div>
        <div class="perm-stat-card stat-disabled">
          <div class="flex items-start justify-between gap-2">
            <div>
              <p class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Disabled</p>
              <p class="text-3xl font-black text-amber-700 mt-1 leading-none"><?php echo number_format($disabledRoleGroups); ?></p>
              <p class="text-xs text-slate-400 mt-1">Paused roles</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-amber-500 text-xl" style="font-variation-settings:'FILL' 1">pause_circle</span>
            </div>
          </div>
        </div>
        <div class="perm-stat-card stat-custom">
          <div class="flex items-start justify-between gap-2">
            <div>
              <p class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Custom</p>
              <p class="text-3xl font-black text-indigo-700 mt-1 leading-none"><?php echo number_format($customRoleGroups); ?></p>
              <p class="text-xs text-slate-400 mt-1">User-created</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-indigo-500 text-xl" style="font-variation-settings:'FILL' 1">tune</span>
            </div>
          </div>
        </div>
      </div>

      <?php if ($flash !== ''): ?>
      <div class="rounded-xl border <?php echo $flashType === 'error' ? 'border-red-200 bg-red-50 text-red-700' : 'border-emerald-200 bg-emerald-50 text-emerald-700'; ?> px-4 py-3 text-sm font-semibold flex items-center gap-3">
        <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1"><?php echo $flashType === 'error' ? 'error' : 'check_circle'; ?></span>
        <?php echo htmlspecialchars($flash); ?>
      </div>
      <?php endif; ?>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-200">
              <span class="material-symbols-outlined text-white text-xl" style="font-variation-settings:'FILL' 1">security</span>
            </div>
            <div>
              <h3 class="font-black text-slate-800 text-base leading-tight">Role Permissions</h3>
              <p class="text-xs text-slate-500 mt-0.5">Control what each role can access. Changes take effect immediately after saving.</p>
            </div>
          </div>
        </div>
        <div class="p-6 space-y-8">
          <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100/60 border border-slate-200 p-5 shadow-sm">
            <input type="hidden" name="action" value="add_role" />
            <div class="flex items-center gap-2 mb-4">
              <span class="section-accent bg-blue-500"></span>
              <p class="text-sm font-black text-slate-700 uppercase tracking-wide">Add a New Role Group</p>
            </div>
            <p class="text-xs text-slate-500 mb-4">Create a custom role, then assign its permissions in the matrix below.</p>
            <div class="grid gap-3 sm:grid-cols-[1fr_auto] items-end">
              <input name="new_role_name" type="text" placeholder="e.g. support_agent" class="perm-field-focus w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
              <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary to-teal-700 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all duration-200 whitespace-nowrap">
                <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">add_circle</span>
                Add Role
              </button>
            </div>
          </form>

          <div class="rounded-2xl bg-white border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-1">
              <span class="section-accent bg-teal-500"></span>
              <p class="text-sm font-black text-slate-700 uppercase tracking-wide">Existing Role Groups</p>
            </div>
            <p class="text-xs text-slate-500 mb-4">Each role can be enabled, disabled, or permanently deleted (custom roles only).</p>

            <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="perm-bulk-form mb-5 p-4" id="bulkRoleForm">
              <input type="hidden" name="action" value="bulk_role_state" />
              <div class="flex flex-col gap-3 lg:flex-row lg:items-end">
                <div class="flex-1">
                  <p class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Bulk Action on Selected Roles</p>
                  <select name="bulk_state" class="perm-field-focus w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                    <option value="enable">✓ Enable Selected</option>
                    <option value="disable">⏸ Disable Selected</option>
                    <option value="delete">✕ Delete Selected (except admin)</option>
                  </select>
                </div>
                <button type="submit" id="bulkRoleSubmit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-700 transition-all shadow-sm" data-confirm="bulk" data-role-label="selected role groups">
                  <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">done_all</span>
                  Apply to Selected
                </button>
              </div>
              <p class="mt-2 text-xs text-slate-400 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[13px]">info</span>
                Use checkboxes on cards below, then apply one action. Admin role is always protected.
              </p>
            </form>

            <?php
              $roleIcons = [
                'admin'   => ['icon' => 'shield_person',  'bg' => 'bg-emerald-600',   'light' => 'bg-emerald-50',  'text' => 'text-emerald-700'],
                'manager' => ['icon' => 'manage_accounts','bg' => 'bg-blue-600',      'light' => 'bg-blue-50',     'text' => 'text-blue-700'],
                'editor'  => ['icon' => 'edit_note',      'bg' => 'bg-violet-600',    'light' => 'bg-violet-50',   'text' => 'text-violet-700'],
                'user'    => ['icon' => 'person',         'bg' => 'bg-slate-500',     'light' => 'bg-slate-50',    'text' => 'text-slate-600'],
              ];
            ?>
            <div id="customRolesGrid" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
              <?php foreach ($roleColumns as $roleKey => $roleLabel): ?>
                <?php
                  $isDefaultRole = in_array($roleKey, $defaultRoles, true);
                  $isRoleEnabled = (bool) ($roleStatus[$roleKey] ?? true);
                  $isAdmin = ($roleKey === 'admin');
                  $iconData = $roleIcons[$roleKey] ?? ['icon' => 'badge', 'bg' => 'bg-indigo-500', 'light' => 'bg-indigo-50', 'text' => 'text-indigo-700'];
                  $cardClass = $isAdmin ? 'role-admin' : ($isRoleEnabled ? '' : 'role-disabled');
                ?>
                <div id="role-card-<?php echo htmlspecialchars($roleKey); ?>" class="perm-role-card <?php echo $cardClass; ?>">
                  <div class="perm-role-card-top">
                    <div class="flex items-start justify-between gap-3">
                      <label class="inline-flex items-center gap-3 min-w-0 flex-1 cursor-pointer">
                        <input type="checkbox" class="role-select-checkbox w-4 h-4 accent-primary rounded flex-shrink-0 mt-0.5" name="bulk_roles[]" value="<?php echo htmlspecialchars($roleKey); ?>" form="bulkRoleForm" />
                        <div class="flex items-center gap-2.5 min-w-0">
                          <div class="w-9 h-9 rounded-xl <?php echo $iconData['bg']; ?> flex items-center justify-center flex-shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings:'FILL' 1"><?php echo $iconData['icon']; ?></span>
                          </div>
                          <div class="min-w-0">
                            <p class="text-sm font-black <?php echo $isRoleEnabled ? 'text-slate-800' : 'text-amber-900'; ?> truncate leading-tight"><?php echo htmlspecialchars($roleLabel); ?></p>
                            <p class="text-[11px] <?php echo $isDefaultRole ? ($iconData['text']) : 'text-indigo-500'; ?> font-semibold mt-0.5">
                              <?php echo $isDefaultRole ? 'Default role' : 'Custom role'; ?>
                            </p>
                          </div>
                        </div>
                      </label>
                      <span class="text-[10px] px-2.5 py-1 rounded-full font-bold flex-shrink-0 <?php echo $isAdmin ? 'bg-emerald-100 text-emerald-700' : ($isRoleEnabled ? 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200' : 'bg-amber-100 text-amber-700 ring-1 ring-amber-200'); ?>">
                        <?php if ($isAdmin): ?>
                          <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Locked</span>
                        <?php elseif ($isRoleEnabled): ?>
                          <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span> Enabled</span>
                        <?php else: ?>
                          <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block"></span> Disabled</span>
                        <?php endif; ?>
                      </span>
                    </div>
                  </div>
                  <div class="perm-role-card-actions">
                    <?php if ($isAdmin): ?>
                      <span class="inline-flex items-center gap-1 text-[11px] text-slate-400 font-semibold px-2 py-1">
                        <span class="material-symbols-outlined text-[13px]">lock</span> Protected
                      </span>
                    <?php else: ?>
                      <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="m-0">
                        <input type="hidden" name="action" value="toggle_role_state" />
                        <input type="hidden" name="role" value="<?php echo htmlspecialchars($roleKey); ?>" />
                        <input type="hidden" name="state" value="<?php echo $isRoleEnabled ? 'disable' : 'enable'; ?>" />
                        <button type="submit" data-confirm="<?php echo $isRoleEnabled ? 'disable' : 'enable'; ?>" data-role-label="<?php echo htmlspecialchars($roleLabel); ?>"
                          class="inline-flex items-center gap-1.5 rounded-lg <?php echo $isRoleEnabled ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 ring-1 ring-amber-200' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 ring-1 ring-emerald-200'; ?> px-2.5 py-1.5 text-[11px] font-bold transition">
                          <span class="material-symbols-outlined text-[13px]" style="font-variation-settings:'FILL' 1"><?php echo $isRoleEnabled ? 'pause_circle' : 'play_circle'; ?></span>
                          <?php echo $isRoleEnabled ? 'Disable' : 'Enable'; ?>
                        </button>
                      </form>
                      <?php if ($isDefaultRole): ?>
                        <button type="button" disabled class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100/70 px-2.5 py-1.5 text-[11px] font-bold text-slate-300 cursor-not-allowed" title="Default roles cannot be deleted">
                          <span class="material-symbols-outlined text-[13px]">delete</span> Delete
                        </button>
                      <?php else: ?>
                        <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="m-0">
                          <input type="hidden" name="action" value="remove_role" />
                          <input type="hidden" name="role" value="<?php echo htmlspecialchars($roleKey); ?>" />
                          <button type="submit" data-confirm="delete" data-role-label="<?php echo htmlspecialchars($roleLabel); ?>"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1.5 text-[11px] font-bold text-red-600 hover:bg-red-100 ring-1 ring-red-200 transition">
                            <span class="material-symbols-outlined text-[13px]" style="font-variation-settings:'FILL' 1">delete</span>
                            Delete
                          </button>
                        </form>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="space-y-6">
            <input type="hidden" name="action" value="save_role_permissions" />

            <div>
              <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100">
                <span class="section-accent bg-blue-500"></span>
                <p class="text-sm font-black text-slate-700 uppercase tracking-wide">Role Permission Matrix</p>
                <p class="text-xs text-slate-400 hidden sm:block">— assign CRUD + Manage permissions per role</p>
              </div>
                <p class="text-xs text-slate-500">Assign Create / Read / Update / Delete / Manage Users permissions for each role.</p>
              </div>
              <div class="perm-matrix-wrap">
                <table id="permissionMatrixTable" class="w-full text-sm">
                  <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                      <th class="px-5 py-3.5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest min-w-[180px]">Permission</th>
                      <?php foreach ($roleColumns as $roleKey => $roleLabel): ?>
                      <?php
                        $thEnabled = !empty($roleStatus[$roleKey]);
                        $thIconData = $roleIcons[$roleKey] ?? ['icon' => 'badge', 'bg' => 'bg-indigo-500'];
                      ?>
                      <th data-role-key="<?php echo htmlspecialchars($roleKey); ?>" data-role-enabled="<?php echo $thEnabled ? '1' : '0'; ?>" class="px-4 py-3.5 text-center w-28 <?php echo $thEnabled ? 'bg-slate-50' : 'bg-amber-50'; ?>">
                        <div class="flex flex-col items-center gap-1">
                          <div class="w-7 h-7 rounded-lg <?php echo $thEnabled ? $thIconData['bg'] : 'bg-amber-300'; ?> flex items-center justify-center mx-auto opacity-90">
                            <span class="material-symbols-outlined text-white text-[14px]" style="font-variation-settings:'FILL' 1"><?php echo $thIconData['icon']; ?></span>
                          </div>
                          <span class="text-[10px] font-black uppercase tracking-widest <?php echo $thEnabled ? 'text-slate-500' : 'text-amber-700'; ?>"><?php echo htmlspecialchars($roleLabel); ?></span>
                          <?php if (!$thEnabled): ?><span class="text-[9px] text-amber-500 font-semibold">(disabled)</span><?php endif; ?>
                        </div>
                      </th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-100">
                    <?php foreach ($permissionLabels as $permissionKey => $label): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors" data-permission-key="<?php echo htmlspecialchars($permissionKey); ?>">
                      <td class="px-5 py-3.5 font-medium text-slate-700 text-xs"><?php echo htmlspecialchars($label); ?></td>
                      <?php foreach ($roleColumns as $roleKey => $roleLabel): ?>
                      <td class="px-4 py-3.5 text-center <?php echo empty($roleStatus[$roleKey]) ? 'bg-amber-50/40' : ''; ?>">
                        <input type="checkbox" class="w-4 h-4 accent-primary rounded cursor-pointer" name="perm_<?php echo $roleKey . '_' . str_replace('.', '_', $permissionKey); ?>" <?php echo !empty($permissions[$roleKey][$permissionKey]) ? 'checked' : ''; ?> <?php echo empty($roleStatus[$roleKey]) ? 'disabled' : ''; ?> />
                      </td>
                      <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="perm-sticky-actions flex justify-end">
              <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-200 flex items-center gap-2" type="submit">
                <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">save</span>
                Save All Permissions
              </button>
            </div>
          </form>
        </div>
      </section>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-amber-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-200">
              <span class="material-symbols-outlined text-white text-xl" style="font-variation-settings:'FILL' 1">history</span>
            </div>
            <div>
              <h3 class="font-black text-slate-800 text-base leading-tight">Role Audit Trail</h3>
              <p class="text-xs text-slate-500 mt-0.5">Recent add, enable/disable, delete, and bulk operations — last 25 entries.</p>
            </div>
          </div>
        </div>
        <div class="p-6">
          <?php if (empty($roleAuditEntries)): ?>
          <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
              <span class="material-symbols-outlined text-2xl text-slate-300">history_toggle_off</span>
            </div>
            <p class="text-slate-500 font-semibold text-sm">No audit activity yet</p>
            <p class="text-slate-400 text-xs mt-1">Actions on role groups will appear here</p>
          </div>
          <?php else: ?>
          <?php
            $auditColors = [
              'add'          => ['dot' => 'bg-emerald-500', 'badge' => 'bg-emerald-100 text-emerald-700', 'icon' => 'add_circle'],
              'delete'       => ['dot' => 'bg-red-500',     'badge' => 'bg-red-100 text-red-700',         'icon' => 'delete'],
              'enable'       => ['dot' => 'bg-teal-500',    'badge' => 'bg-teal-100 text-teal-700',       'icon' => 'play_circle'],
              'disable'      => ['dot' => 'bg-amber-500',   'badge' => 'bg-amber-100 text-amber-700',     'icon' => 'pause_circle'],
              'bulk-enable'  => ['dot' => 'bg-teal-400',    'badge' => 'bg-teal-50 text-teal-600',        'icon' => 'done_all'],
              'bulk-disable' => ['dot' => 'bg-amber-400',   'badge' => 'bg-amber-50 text-amber-600',      'icon' => 'done_all'],
              'bulk-delete'  => ['dot' => 'bg-red-400',     'badge' => 'bg-red-50 text-red-600',          'icon' => 'done_all'],
            ];
          ?>
          <div class="audit-timeline">
            <?php foreach ($roleAuditEntries as $entry): ?>
            <?php
              $entryAction = (string) ($entry['action'] ?? '-');
              $entryRole = userRoleLabel((string) ($entry['role'] ?? '-'));
              $entryActor = (string) ($entry['actor_name'] ?? 'Admin');
              $entryTime = (string) ($entry['timestamp'] ?? '-');
              $entryMeta = $entry['meta'] ?? [];
              $ac = $auditColors[$entryAction] ?? ['dot' => 'bg-slate-400', 'badge' => 'bg-slate-100 text-slate-600', 'icon' => 'info'];
            ?>
            <div class="audit-timeline-item">
              <div class="audit-timeline-dot <?php echo $ac['dot']; ?>">
                <span class="material-symbols-outlined text-white" style="font-size:9px;font-variation-settings:'FILL' 1"><?php echo $ac['icon']; ?></span>
              </div>
              <div class="flex flex-col sm:flex-row sm:items-start sm:gap-4 gap-1">
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center gap-1 text-[11px] font-black px-2 py-0.5 rounded-full <?php echo $ac['badge']; ?>">
                      <?php echo htmlspecialchars(roleAuditActionLabel($entryAction)); ?>
                    </span>
                    <span class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars($entryRole); ?></span>
                  </div>
                  <div class="flex items-center gap-3 mt-1 flex-wrap">
                    <span class="text-xs text-slate-400 flex items-center gap-1">
                      <span class="material-symbols-outlined text-[12px]">person</span>
                      <?php echo htmlspecialchars($entryActor); ?>
                    </span>
                    <span class="text-xs text-slate-400 flex items-center gap-1">
                      <span class="material-symbols-outlined text-[12px]">schedule</span>
                      <?php echo htmlspecialchars($entryTime); ?>
                    </span>
                    <?php if (!empty($entryMeta) && is_array($entryMeta)): ?>
                    <span class="text-xs text-slate-300 truncate max-w-[260px]" title="<?php echo htmlspecialchars(json_encode($entryMeta)); ?>">
                      <?php
                        $metaStr = [];
                        foreach ($entryMeta as $mk => $mv) { if (!is_array($mv)) $metaStr[] = $mk . ': ' . (is_bool($mv) ? ($mv ? 'yes' : 'no') : $mv); }
                        echo htmlspecialchars(implode(' · ', array_slice($metaStr, 0, 3)));
                      ?>
                    </span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
      </section>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-purple-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-purple-200">
              <span class="material-symbols-outlined text-white text-xl" style="font-variation-settings:'FILL' 1">people</span>
            </div>
            <div>
              <h3 class="font-black text-slate-800 text-base leading-tight">User Role Assignments</h3>
              <p class="text-xs text-slate-500 mt-0.5">Assign each registered user one of the available enabled roles.</p>
            </div>
          </div>
        </div>
        <form method="POST" action="<?php echo htmlspecialchars($currentPath); ?>" class="p-6">
          <input type="hidden" name="action" value="update_user_roles" />
          <div class="overflow-x-auto rounded-xl border border-slate-100 shadow-sm">
            <table id="userRolesTable" class="w-full text-sm">
              <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                  <th class="px-5 py-3.5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">User</th>
                  <th class="px-5 py-3.5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Email</th>
                  <th class="px-5 py-3.5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest w-44">Role</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50">
                <?php foreach ($users as $user): ?>
                <?php
                  $userRole = strtolower((string) ($user['role'] ?? 'user'));
                  if ($userRole === 'customer') { $userRole = 'user'; }
                  $uname = (string) ($user['username'] ?? '-');
                  $uInitial = strtoupper(substr($uname, 0, 1)) ?: '?';
                  $uColors = ['A' => 'bg-emerald-500', 'B' => 'bg-blue-500', 'C' => 'bg-violet-500', 'D' => 'bg-orange-500'];
                  $uBg = $uColors[$uInitial] ?? 'bg-teal-500';
                ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                  <td class="px-5 py-3 font-bold text-slate-700">
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-full <?php echo $uBg; ?> flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-black"><?php echo htmlspecialchars($uInitial); ?></span>
                      </div>
                      <span class="text-sm"><?php echo htmlspecialchars($uname); ?></span>
                    </div>
                  </td>
                  <td class="px-5 py-3 text-slate-500 text-xs"><?php echo htmlspecialchars((string) ($user['email'] ?? '-')); ?></td>
                  <td class="px-5 py-3">
                    <select class="perm-field-focus rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm font-semibold focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none w-full" name="user_role[<?php echo (int) ($user['id'] ?? 0); ?>]">
                      <?php foreach ($roleColumns as $roleKey => $roleLabel): ?>
                      <?php $isRoleEnabled = !empty($roleStatus[$roleKey]); ?>
                      <option value="<?php echo htmlspecialchars($roleKey); ?>" <?php echo ($userRole === $roleKey) ? 'selected' : ''; ?> <?php echo (!$isRoleEnabled && $userRole !== $roleKey) ? 'disabled' : ''; ?>><?php echo htmlspecialchars($roleLabel . ($isRoleEnabled ? '' : ' (disabled)')); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="perm-sticky-actions flex justify-end">
            <button class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-purple-500/20 hover:shadow-xl hover:shadow-purple-500/30 transition-all duration-200 flex items-center gap-2" type="submit">
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
    const $rolesGrid = $('#customRolesGrid');
    const $permissionMatrix = $('#permissionMatrixTable');
    const $userRolesTable = $('#userRolesTable');

    function addRoleCard(roleKey, roleLabel) {
        const card = `
          <div id="role-card-${roleKey}" class="perm-role-card">
            <div class="perm-role-card-top">
              <div class="flex items-start justify-between gap-3">
                <label class="inline-flex items-center gap-3 min-w-0 flex-1 cursor-pointer">
                  <input type="checkbox" class="role-select-checkbox w-4 h-4 accent-primary rounded flex-shrink-0 mt-0.5" name="bulk_roles[]" value="${roleKey}" form="bulkRoleForm" />
                  <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-indigo-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                      <span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings:'FILL' 1">badge</span>
                    </div>
                    <div class="min-w-0">
                      <p class="text-sm font-black text-slate-800 truncate leading-tight">${roleLabel}</p>
                      <p class="text-[11px] text-indigo-500 font-semibold mt-0.5">Custom role</p>
                    </div>
                  </div>
                </label>
                <span class="text-[10px] px-2.5 py-1 rounded-full font-bold flex-shrink-0 bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200">
                  <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span> Enabled</span>
                </span>
              </div>
            </div>
            <div class="perm-role-card-actions">
              <form method="POST" action="${window.location.pathname}" class="m-0">
                <input type="hidden" name="action" value="toggle_role_state" />
                <input type="hidden" name="role" value="${roleKey}" />
                <input type="hidden" name="state" value="disable" />
                <button type="submit" data-confirm="disable" data-role-label="${roleLabel}" class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 ring-1 ring-amber-200 px-2.5 py-1.5 text-[11px] font-bold transition">
                  <span class="material-symbols-outlined text-[13px]" style="font-variation-settings:'FILL' 1">pause_circle</span>
                  Disable
                </button>
              </form>
              <form method="POST" action="${window.location.pathname}" class="m-0">
                <input type="hidden" name="action" value="remove_role" />
                <input type="hidden" name="role" value="${roleKey}" />
                <button type="submit" data-confirm="delete" data-role-label="${roleLabel}" class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1.5 text-[11px] font-bold text-red-600 hover:bg-red-100 ring-1 ring-red-200 transition">
                  <span class="material-symbols-outlined text-[13px]" style="font-variation-settings:'FILL' 1">delete</span>
                  Delete
                </button>
              </form>
            </div>
          </div>`;

        $rolesGrid.append(card);
    }

    function addRoleColumn(roleKey, roleLabel) {
        if (!$permissionMatrix.length || !$userRolesTable.length) {
            return;
        }

        // Add header cell
        $permissionMatrix.find('thead tr').append(
          `<th data-role-key="${roleKey}" data-role-enabled="1" class="px-4 py-3.5 text-center w-28 bg-slate-50"><div class="flex flex-col items-center gap-1"><div class="w-7 h-7 rounded-lg bg-indigo-500 flex items-center justify-center mx-auto opacity-90"><span class="material-symbols-outlined text-white text-[14px]" style="font-variation-settings:'FILL' 1">badge</span></div><span class="text-[10px] font-black uppercase tracking-widest text-slate-500">${roleLabel}</span></div></th>`
        );

        // Add checkbox for every permission row
        $permissionMatrix.find('tbody tr[data-permission-key]').each(function() {
            const permissionKey = $(this).data('permission-key');
            const fieldName = `perm_${roleKey}_${permissionKey.toString().replace(/\./g, '_')}`;
            $(this).append(
                `<td class="px-4 py-3.5 text-center"><input type="checkbox" class="w-4 h-4 accent-primary rounded cursor-pointer" name="${fieldName}" /></td>`
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
        return true;
        }

      const confirmType = ($submitButton.data('confirm') || '').toString();
      const roleLabel = ($submitButton.data('role-label') || 'this role').toString();
      if (!$form.data('confirmed') && (confirmType === 'delete' || confirmType === 'disable' || confirmType === 'enable')) {
        e.preventDefault();

        let promptTitle = 'Proceed with this action?';
        let promptText = 'Please confirm this change.';
        let confirmColor = '#003345';

        if (confirmType === 'delete') {
          promptTitle = 'Delete role group?';
          promptText = `Role ${roleLabel} will be removed and affected users will be reassigned.`;
          confirmColor = '#dc2626';
        }

        if (confirmType === 'disable') {
          promptTitle = 'Disable role group?';
          promptText = `Role ${roleLabel} will stop being assignable until enabled again.`;
          confirmColor = '#d97706';
        }

        if (confirmType === 'enable') {
          promptTitle = 'Enable role group?';
          promptText = `Role ${roleLabel} will be available for assignment and permissions.`;
          confirmColor = '#059669';
        }

        Swal.fire({
          title: promptTitle,
          text: promptText,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, continue',
          cancelButtonText: 'Cancel',
          confirmButtonColor: confirmColor
        }).then((result) => {
          if (!result.isConfirmed) {
            return;
          }
          $form.data('confirmed', true);
          $form.trigger('submit');
        });
        return false;
      }

      if (action === 'bulk_role_state') {
        const selectedCount = $form.find('input[name="bulk_roles[]"]:checked').length;
        const bulkState = (($form.find('select[name="bulk_state"]').val() || '').toString()).toLowerCase();

        if (selectedCount === 0) {
          e.preventDefault();
          Swal.fire({
            title: 'No roles selected',
            text: 'Select at least one role group before running a bulk action.',
            icon: 'warning',
            confirmButtonColor: '#d97706'
          });
          return false;
        }

        if (!$form.data('confirmed')) {
          e.preventDefault();
          const labelMap = {
            enable: 'Enable selected role groups?',
            disable: 'Disable selected role groups?',
            delete: 'Delete selected role groups?'
          };

          const detailMap = {
            enable: 'Selected roles will become available for assignments and permission updates.',
            disable: 'Selected roles will stop being assignable until re-enabled.',
            delete: 'Selected roles will be removed. Admin role is protected and skipped automatically.'
          };

          const colorMap = {
            enable: '#059669',
            disable: '#d97706',
            delete: '#dc2626'
          };

          Swal.fire({
            title: labelMap[bulkState] || 'Apply bulk action?',
            text: `${detailMap[bulkState] || 'This action will update selected roles.'} Selected: ${selectedCount}.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply',
            cancelButtonText: 'Cancel',
            confirmButtonColor: colorMap[bulkState] || '#003345'
          }).then((result) => {
            if (!result.isConfirmed) {
              return;
            }
            $form.data('confirmed', true);
            $form.trigger('submit');
          });
          return false;
        }
      }

      $form.removeData('confirmed');

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

                if (action === 'toggle_role_state') {
                  showToast(response.message, 'success');
                  setTimeout(() => {
                    window.location.reload();
                  }, 550);
                  return;
                }

                if (action === 'bulk_role_state') {
                    showToast(response.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 650);
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
