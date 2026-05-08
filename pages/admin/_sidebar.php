<?php
/**
 * Shared Admin Sidebar Partial
 * Requires $activePage (string) to be set by the including file.
 * Example: $activePage = 'orders';
 */
$activePage = $activePage ?? '';
$currentRoute = \Mpemba\Utils\Router::getCurrentRoute();
$navLinks = \Mpemba\Utils\Router::getMenuRoutes('admin');
?>
<aside class="admin-sidebar h-screen w-64 fixed left-0 top-0 surface-glass flex flex-col p-4 z-50">
    <div class="mb-10 px-2">
        <h1 class="text-teal-900 font-black tracking-tighter text-2xl">Mpemba Heritage</h1>
        <p class="font-['Epilogue'] tracking-tight font-bold text-sm text-slate-500">Digital Atelier Console</p>
    </div>
    <nav class="flex-1 space-y-1 overflow-y-auto pr-1">
        <?php foreach ($navLinks as $link):
            $isActive = \Mpemba\Utils\Router::isRouteActive($link, $currentRoute) || ($activePage === $link['key']);
            $disabled = $link['disabled'] ?? false;
            $linkClasses = $disabled
                ? 'pointer-events-none opacity-50 text-slate-400 bg-slate-50 rounded-lg'
                : ($isActive
                    ? 'bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50'
                    : 'text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg');
        ?>
        <a class="flex items-center gap-3 px-4 py-3 <?php echo $linkClasses; ?>"
           href="<?php echo htmlspecialchars($link['href']); ?>" <?php echo $disabled ? 'aria-disabled="true"' : ''; ?>>
            <span class="material-symbols-outlined"><?php echo htmlspecialchars($link['icon'] ?? 'chevron_right'); ?></span>
            <span class="font-['Epilogue'] tracking-tight font-bold text-lg"><?php echo htmlspecialchars($link['label']); ?></span>
        </a>
        <?php if (!empty($link['children'])): ?>
            <div class="space-y-1 pl-8">
                <?php foreach ($link['children'] as $child):
                    $childActive = \Mpemba\Utils\Router::isRouteActive($child, $currentRoute) || ($activePage === $child['key']);
                    $childDisabled = $child['disabled'] ?? false;
                    $childClasses = $childDisabled
                        ? 'pointer-events-none opacity-50 text-slate-400'
                        : ($childActive
                            ? 'text-teal-900 font-semibold'
                            : 'text-slate-500 hover:text-teal-800 transition-all duration-300 hover:text-teal-900');
                ?>
                    <a class="block px-3 py-2 rounded-lg <?php echo $childClasses; ?>"
                       href="<?php echo htmlspecialchars($child['href']); ?>" <?php echo $childDisabled ? 'aria-disabled="true"' : ''; ?> >
                        <?php echo htmlspecialchars($child['label']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
