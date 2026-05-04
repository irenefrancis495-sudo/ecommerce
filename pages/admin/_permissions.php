<?php

function adminDefaultRolePermissions(): array
{
    return [
        'admin' => [
            'dashboard.view' => true,
            'inventory.manage' => true,
            'categories.manage' => true,
            'orders.manage' => true,
            'users.manage' => true,
            'feedback.manage' => true,
            'messages.manage' => true,
            'subscribers.manage' => true,
            'reports.view' => true,
            'settings.manage' => true,
            'permissions.manage' => true,
        ],
        'customer' => [
            'dashboard.view' => false,
            'inventory.manage' => false,
            'categories.manage' => false,
            'orders.manage' => false,
            'users.manage' => false,
            'feedback.manage' => false,
            'messages.manage' => false,
            'subscribers.manage' => false,
            'reports.view' => false,
            'settings.manage' => false,
            'permissions.manage' => false,
        ],
    ];
}

function adminPermissionsFilePath(): string
{
    return __DIR__ . '/../../data/role_permissions.json';
}

function adminLoadRolePermissions(): array
{
    $defaults = adminDefaultRolePermissions();
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

function adminCurrentRole(): string
{
    $role = strtolower((string) ($_SESSION['admin_user']['role'] ?? 'admin'));
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
        'admin/index' => 'dashboard.view',
        'admin/inventory' => 'inventory.manage',
        'admin/add-product' => 'inventory.manage',
        'admin/categories' => 'categories.manage',
        'admin/orders' => 'orders.manage',
        'admin/customers' => 'users.manage',
        'admin/feedback' => 'feedback.manage',
        'admin/messages' => 'messages.manage',
        'admin/subscribers' => 'subscribers.manage',
        'admin/reports' => 'reports.view',
        'admin/settings' => 'settings.manage',
        'admin/permissions' => 'permissions.manage',
    ];

    if (!isset($map[$path])) {
        return;
    }

    adminRequirePermission($map[$path]);
}
