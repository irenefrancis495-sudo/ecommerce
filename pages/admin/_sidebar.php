<?php
/**
 * Shared Admin Sidebar Partial
 * Requires $activePage (string) to be set by the including file.
 * Example: $activePage = 'orders';
 */
$activePage = $activePage ?? '';

$navLinks = [
    ['href' => '/admin/index',       'icon' => 'dashboard',            'label' => 'Dashboard',   'key' => 'dashboard'],
    ['href' => '/admin/inventory',   'icon' => 'inventory_2',          'label' => 'Inventory',   'key' => 'inventory'],
    ['href' => '/admin/categories',  'icon' => 'category',             'label' => 'Categories',  'key' => 'categories'],
    ['href' => '/admin/orders',      'icon' => 'shopping_cart',        'label' => 'Orders',      'key' => 'orders'],
    ['href' => '/admin/customers',   'icon' => 'group',                'label' => 'Users',       'key' => 'customers'],
    ['href' => '/admin/feedback',    'icon' => 'chat',                 'label' => 'Feedback',    'key' => 'feedback'],
    ['href' => '/admin/messages',    'icon' => 'mail',                 'label' => 'Messages',    'key' => 'messages'],
    ['href' => '/admin/subscribers', 'icon' => 'mark_email_read',      'label' => 'Subscribers', 'key' => 'subscribers'],
    ['href' => '/admin/reports',     'icon' => 'analytics',            'label' => 'Analytics',   'key' => 'reports'],
    ['href' => '/admin/settings',    'icon' => 'settings',             'label' => 'Settings',    'key' => 'settings'],
    ['href' => '/admin/permissions', 'icon' => 'admin_panel_settings', 'label' => 'Permissions', 'key' => 'permissions'],
];
?>
<aside class="admin-sidebar h-screen w-64 fixed left-0 top-0 surface-glass flex flex-col p-4 z-50">
    <div class="mb-10 px-2">
        <h1 class="text-teal-900 font-black tracking-tighter text-2xl">Mpemba Heritage</h1>
        <p class="font-['Epilogue'] tracking-tight font-bold text-sm text-slate-500">Digital Atelier Console</p>
    </div>
    <nav class="flex-1 space-y-1 overflow-y-auto pr-1">
        <?php foreach ($navLinks as $link):
            $isActive = ($activePage === $link['key']);
        ?>
        <a class="flex items-center gap-3 px-4 py-3 <?php echo $isActive
            ? 'bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50'
            : 'text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg'; ?>"
           href="<?php echo htmlspecialchars($link['href']); ?>">
            <span class="material-symbols-outlined"><?php echo $link['icon']; ?></span>
            <span class="font-['Epilogue'] tracking-tight font-bold text-lg"><?php echo $link['label']; ?></span>
        </a>
        <?php endforeach; ?>
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
