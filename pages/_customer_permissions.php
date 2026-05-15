<?php
/**
 * Customer-side permission enforcement helper.
 * Include this at the top of any frontend page that requires a logged-in
 * customer with specific abilities, e.g.:
 *
 *   require_once __DIR__ . '/../pages/_customer_permissions.php';
 *   customerRequirePermission('shop.cart');
 *
 * Session key used: $_SESSION['user'] (set by UserController::login)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('adminLoadRolePermissions')) {
    $_cpPermFile = __DIR__ . '/admin/_permissions.php';
    if (file_exists($_cpPermFile)) {
        require_once $_cpPermFile;
    }
}

// ──────────────────────────────────────────────────────────────────────────────
// Helpers
// ──────────────────────────────────────────────────────────────────────────────

function customerIsLoggedIn(): bool
{
    return !empty($_SESSION['user']) && !empty($_SESSION['user']['id']);
}

function customerCurrentRole(): string
{
    if (!customerIsLoggedIn()) {
        return 'guest';
    }
    $role = strtolower((string) ($_SESSION['user']['role'] ?? 'customer'));
    return $role !== '' ? $role : 'customer';
}

function customerHasPermission(string $permission): bool
{
    if (!customerIsLoggedIn()) {
        return false;
    }

    if (function_exists('adminLoadRolePermissions')) {
        $perms = adminLoadRolePermissions();
        $role  = customerCurrentRole();
        return (bool) ($perms[$role][$permission] ?? false);
    }

    // Fallback: customers can do all shop.* things by default
    return str_starts_with($permission, 'shop.');
}

function customerCurrentGroup(): string
{
    if (!customerIsLoggedIn()) {
        return 'guest';
    }
    $role = strtolower((string) ($_SESSION['user']['role'] ?? 'customer'));
    if ($role === 'customer') {
        return 'user';
    }
    return $role !== '' ? $role : 'user';
}

function customerCurrentGroupName(): string
{
    $group = customerCurrentGroup();
    if ($group === 'guest') {
        return 'Guest';
    }

    if (class_exists('\Mpemba\Utils\Database')) {
        return \Mpemba\Utils\Database::getGroupLabel($group);
    }

    return ucwords(str_replace(['_', '-'], ' ', $group));
}

function customerHasGroup(string|array $groups): bool
{
    if (!customerIsLoggedIn()) {
        return false;
    }

    $currentGroup = customerCurrentGroup();
    $allowed = is_array($groups) ? $groups : [$groups];
    foreach ($allowed as $groupItem) {
        if (strtolower(trim((string) $groupItem)) === $currentGroup) {
            return true;
        }
    }
    return false;
}

function customerRequireGroup(string|array $groups, string $redirect = '/login'): void
{
    if (!customerIsLoggedIn()) {
        $return = urlencode($_SERVER['REQUEST_URI'] ?? '');
        $target = $redirect . ($return ? '?next=' . $return : '');
        header('Location: ' . $target);
        exit;
    }

    if (customerHasGroup($groups)) {
        return;
    }

    http_response_code(403);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Access Denied</title><script src="https://cdn.tailwindcss.com"></script></head><body class="min-h-screen bg-slate-50 flex items-center justify-center font-sans p-6"><div class="bg-white rounded-3xl shadow-xl max-w-md w-full p-10 text-center"><div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-rose-50 mb-6"><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg></div><h1 class="text-2xl font-extrabold text-slate-900 mb-2">Access Denied</h1><p class="text-slate-600 mb-2">You do not have permission to view this page.</p><p class="text-slate-500 text-sm mb-8">Please sign in with the correct account or contact an administrator.</p><div class="flex flex-col sm:flex-row gap-3 justify-center"><a href="/login" class="rounded-full bg-primary px-6 py-3 text-white font-semibold hover:opacity-90 transition" style="background:#003345">Sign In</a><a href="javascript:history.back()" class="rounded-full border border-slate-300 px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">Go Back</a></div></div></body></html>';
    exit;
}

/**
 * If customer is not logged in, redirect to login with a return URL.
 * Pass $hard = true to exit immediately (no partial output).
 */
function customerRequireLogin(string $redirect = '/login'): void
{
    if (customerIsLoggedIn()) {
        return;
    }

    $return = urlencode($_SERVER['REQUEST_URI'] ?? '');
    $target = $redirect . ($return ? '?next=' . $return : '');

    header('Location: ' . $target);
    exit;
}

/**
 * Require login AND a specific permission.
 * Unauthenticated visitors → redirect to /login.
 * Authenticated users without the permission → show a friendly denial page.
 */
function customerRequirePermission(string $permission): void
{
    customerRequireLogin();

    if (customerHasPermission($permission)) {
        return;
    }

    http_response_code(403);
    $labels = [
        'shop.cart'     => 'Shopping Cart',
        'shop.checkout' => 'Checkout & Payment',
        'shop.orders'   => 'Order History',
        'shop.profile'  => 'My Account',
        'shop.reviews'  => 'Write Reviews',
        'shop.browse'   => 'Browse Products',
    ];
    $name = $labels[$permission] ?? $permission;
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Access Restricted – Mpemba Marketplace</title>
<script src="https://cdn.tailwindcss.com"></script></head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center font-sans p-6">
  <div class="bg-white rounded-3xl shadow-xl max-w-md w-full p-10 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-50 mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
      </svg>
    </div>
    <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Access Restricted</h1>
    <p class="text-slate-600 mb-2">Your account does not have permission to use <strong>' . htmlspecialchars($name) . '</strong>.</p>
    <p class="text-slate-500 text-sm mb-8">Please contact the store administrator if you believe this is a mistake.</p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
      <a href="/home" class="rounded-full bg-primary px-6 py-3 text-white font-semibold hover:opacity-90 transition" style="background:#003345">Go to Home</a>
      <a href="javascript:history.back()" class="rounded-full border border-slate-300 px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">Go Back</a>
    </div>
  </div>
</body></html>';
    exit;
}
