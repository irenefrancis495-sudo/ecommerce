<?php

function adminDefaultRolePermissions(): array
{
    return [
        'admin' => [
            'create' => true,
            'read' => true,
            'update' => true,
            'delete' => true,
            'manage.users' => true,
        ],
        'manager' => [
            'create' => true,
            'read' => true,
            'update' => true,
            'delete' => true,
            'manage.users' => false,
        ],
        'editor' => [
            'create' => true,
            'read' => true,
            'update' => true,
            'delete' => false,
            'manage.users' => false,
        ],
        'user' => [
            'create' => false,
            'read' => true,
            'update' => false,
            'delete' => false,
            'manage.users' => false,
        ],
    ];
}

function adminPermissionsFilePath(): string
{
    return __DIR__ . '/../../data/role_permissions.json';
}

function adminRoleStatusFilePath(): string
{
    return __DIR__ . '/../../data/role_status.json';
}

function adminRoleAuditFilePath(): string
{
    return __DIR__ . '/../../data/role_audit_log.json';
}

function adminDeletedDefaultsFilePath(): string
{
    return __DIR__ . '/../../data/role_deleted_defaults.json';
}

function adminLoadDeletedDefaultRoles(): array
{
    $file = adminDeletedDefaultsFilePath();
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return [];
    }

    $data = json_decode((string) file_get_contents($file), true);
    if (!is_array($data)) {
        return [];
    }

    $normalized = [];
    foreach ($data as $role) {
        $roleKey = strtolower(trim((string) $role));
        if ($roleKey !== '' && $roleKey !== 'admin') {
            $normalized[] = $roleKey;
        }
    }
    return array_values(array_unique($normalized));
}

function adminSaveDeletedDefaultRoles(array $roles): void
{
    $normalized = [];
    foreach ($roles as $role) {
        $roleKey = strtolower(trim((string) $role));
        if ($roleKey !== '' && $roleKey !== 'admin') {
            $normalized[] = $roleKey;
        }
    }

    $normalized = array_values(array_unique($normalized));
    file_put_contents(adminDeletedDefaultsFilePath(), json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function adminLoadRolePermissions(): array
{
    $defaults = adminDefaultRolePermissions();
    $deletedDefaults = adminLoadDeletedDefaultRoles();
    $file = adminPermissionsFilePath();

    if (!file_exists($file)) {
        file_put_contents($file, json_encode($defaults, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return $defaults;
    }

    $data = json_decode((string) file_get_contents($file), true);
    if (!is_array($data)) {
        return $defaults;
    }

    foreach ($defaults as $role => $permissions) {
        if ($role !== 'admin' && in_array($role, $deletedDefaults, true)) {
            continue;
        }

        if (!isset($data[$role]) || !is_array($data[$role])) {
            $data[$role] = $permissions;
            continue;
        }

        foreach ($permissions as $permission => $value) {
            if (!array_key_exists($permission, $data[$role])) {
                $data[$role][$permission] = $value;
            }
        }
    }

    return $data;
}

function adminSaveRolePermissions(array $permissions): void
{
    file_put_contents(adminPermissionsFilePath(), json_encode($permissions, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function adminLoadRoleStatus(): array
{
    $permissions = adminLoadRolePermissions();
    $roleKeys = array_keys($permissions);
    $file = adminRoleStatusFilePath();

    if (!file_exists($file)) {
        $defaults = array_fill_keys($roleKeys, true);
        file_put_contents($file, json_encode($defaults, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return $defaults;
    }

    $data = json_decode((string) file_get_contents($file), true);
    if (!is_array($data)) {
        return array_fill_keys($roleKeys, true);
    }

    $normalized = [];
    foreach ($roleKeys as $roleKey) {
        if (!array_key_exists($roleKey, $data)) {
            $normalized[$roleKey] = true;
            continue;
        }
        $normalized[$roleKey] = (bool) $data[$roleKey];
    }

    if (!isset($normalized['admin'])) {
        $normalized['admin'] = true;
    }

    if ($normalized['admin'] === false) {
        $normalized['admin'] = true;
    }

    file_put_contents($file, json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    return $normalized;
}

function adminSaveRoleStatus(array $status): void
{
    if (isset($status['admin']) && $status['admin'] === false) {
        $status['admin'] = true;
    }
    file_put_contents(adminRoleStatusFilePath(), json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function adminIsRoleEnabled(string $role): bool
{
    $status = adminLoadRoleStatus();
    return (bool) ($status[$role] ?? true);
}

function adminGetFallbackRole(array $roleStatus = []): string
{
    $status = $roleStatus ?: adminLoadRoleStatus();

    if (!empty($status['user'])) {
        return 'user';
    }

    foreach (['manager', 'editor', 'admin'] as $candidate) {
        if (!empty($status[$candidate])) {
            return $candidate;
        }
    }

    return 'admin';
}

function adminLoadRoleAuditLog(): array
{
    $file = adminRoleAuditFilePath();

    if (!file_exists($file)) {
        file_put_contents($file, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return [];
    }

    $data = json_decode((string) file_get_contents($file), true);
    return is_array($data) ? $data : [];
}

function adminAppendRoleAudit(string $action, string $role, array $meta = [], array $actor = []): void
{
    $entries = adminLoadRoleAuditLog();
    $entries[] = [
        'timestamp' => date('Y-m-d H:i:s'),
        'action' => $action,
        'role' => $role,
        'actor_name' => (string) ($actor['name'] ?? ($_SESSION['admin_user']['name'] ?? 'Admin')),
        'actor_username' => (string) ($actor['username'] ?? ($_SESSION['admin_user']['username'] ?? 'admin')),
        'actor_email' => (string) ($actor['email'] ?? ($_SESSION['admin_user']['email'] ?? '')),
        'meta' => $meta,
    ];

    $entries = array_slice($entries, -250);
    file_put_contents(adminRoleAuditFilePath(), json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function adminCurrentRole(): string
{
    $role = strtolower((string) ($_SESSION['admin_user']['role'] ?? 'admin'));
    if ($role === 'customer') {
        return 'user';
    }
    return $role !== '' ? $role : 'admin';
}

function adminIsSuperAdmin(): bool
{
    $username = strtolower((string) ($_SESSION['admin_user']['username'] ?? ''));
    $email = strtolower((string) ($_SESSION['admin_user']['email'] ?? ''));

    return $username === 'admin' || $email === 'admin@mpemba.local';
}

function adminHasPermission(string $permission): bool
{
    if (adminIsSuperAdmin()) {
        return true;
    }

    $permissions = adminLoadRolePermissions();
    $role = adminCurrentRole();

    if (!adminIsRoleEnabled($role)) {
        return false;
    }

    return (bool) ($permissions[$role][$permission] ?? false);
}

function adminRequirePermission(string $permission): void
{
    if (adminHasPermission($permission)) {
        return;
    }

    http_response_code(403);
    echo '<div style="font-family:Manrope,sans-serif;max-width:760px;margin:64px auto;padding:24px;border:1px solid #fecaca;background:#fff7f7;border-radius:12px">';
    echo '<h1 style="margin:0 0 12px;color:#991b1b">Permission denied</h1>';
    echo '<p style="margin:0 0 12px;color:#7f1d1d">You do not have access to this admin section.</p>';
    echo '<a href="/admin/index" style="display:inline-block;margin-top:8px;padding:10px 14px;background:#003345;color:#fff;text-decoration:none;border-radius:8px">Go to dashboard</a>';
    echo '</div>';
    exit;
}

function adminEnforcePagePermission(): void
{
    $path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');

    $map = [
        'admin' => 'read',
        'admin/index' => 'read',
        'admin/inventory' => 'create',
        'admin/add-product' => 'create',
        'admin/categories' => 'update',
        'admin/orders' => 'read',
        'admin/customers' => 'manage.users',
        'admin/feedback' => 'read',
        'admin/messages' => 'read',
        'admin/subscribers' => 'read',
        'admin/reports' => 'read',
        'admin/settings' => 'update',
        'admin/permissions' => 'manage.users',
    ];

    if (!isset($map[$path])) {
        return;
    }

    adminRequirePermission($map[$path]);
}
