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
<style>
    @keyframes admin-fade-up {
        from {
            opacity: 0;
            transform: translateY(12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes admin-fade-in {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes admin-rise-soft {
        from {
            opacity: 0;
            transform: translateY(16px) scale(0.992);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes admin-skeleton-shimmer {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        opacity: 0;
    }

    body.admin-ui-ready {
        opacity: 1;
        animation: admin-fade-in 280ms ease-out;
    }

    .admin-topbar,
    .admin-content,
    .admin-sidebar {
        will-change: transform, opacity;
    }

    body.admin-ui-ready .admin-topbar {
        animation: admin-fade-up 320ms ease-out;
    }

    body.admin-ui-ready .admin-sidebar {
        animation: admin-fade-up 360ms ease-out;
    }

    body.admin-ui-ready .admin-content {
        animation: admin-fade-up 420ms ease-out;
    }

    .admin-shell a,
    .admin-shell button,
    .admin-shell input[type="button"],
    .admin-shell input[type="submit"],
    .admin-shell .btn {
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, opacity 0.2s ease;
    }

    .admin-shell button:hover,
    .admin-shell a:hover,
    .admin-shell input[type="button"]:hover,
    .admin-shell input[type="submit"]:hover,
    .admin-shell .btn:hover {
        transform: translateY(-1px);
    }

    .admin-shell button:active,
    .admin-shell a:active,
    .admin-shell input[type="button"]:active,
    .admin-shell input[type="submit"]:active,
    .admin-shell .btn:active {
        transform: translateY(0);
    }

    .admin-shell input,
    .admin-shell select,
    .admin-shell textarea {
        transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, color 0.2s ease;
    }

    .admin-reveal {
        opacity: 0;
        transform: translateY(16px) scale(0.992);
    }

    .admin-reveal.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
        animation: admin-rise-soft 520ms cubic-bezier(0.22, 1, 0.36, 1) both;
        animation-delay: var(--admin-reveal-delay, 0ms);
    }

    .admin-content {
        position: relative;
    }

    .admin-skeleton-layer {
        position: absolute;
        inset: 0;
        border-radius: 1rem;
        pointer-events: none;
        z-index: 8;
        opacity: 1;
        transition: opacity 240ms ease;
    }

    .admin-skeleton-layer.is-hidden {
        opacity: 0;
    }

    .admin-skeleton-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.95rem;
    }

    .admin-skeleton-line,
    .admin-skeleton-card {
        border-radius: 0.9rem;
        background: linear-gradient(100deg, rgba(226, 232, 240, 0.55) 20%, rgba(241, 245, 249, 0.95) 50%, rgba(226, 232, 240, 0.55) 80%);
        background-size: 220% 100%;
        animation: admin-skeleton-shimmer 1.2s linear infinite;
    }

    .admin-skeleton-line {
        height: 0.95rem;
    }

    .admin-skeleton-card {
        height: 7.25rem;
    }

    .admin-skeleton-row {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.85rem;
    }

    .admin-skeleton-table {
        height: 16rem;
    }

    .admin-sidebar {
        transition: width 0.24s ease, transform 0.24s ease, box-shadow 0.24s ease;
    }

    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(2, 6, 23, 0.36);
        backdrop-filter: blur(2px);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 45;
    }

    .sidebar-overlay.open {
        opacity: 1;
        pointer-events: auto;
    }

    .admin-mobile-sidebar-btn {
        position: fixed;
        left: 1rem;
        top: 1rem;
        z-index: 44;
    }

    .sidebar-collapse-btn {
        transition: all 0.22s ease;
    }

    .sidebar-collapse-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px -16px rgba(15, 23, 42, 0.5);
    }

    .sidebar-collapse-btn .collapse-icon-wrap {
        width: 1.85rem;
        height: 1.85rem;
        border-radius: 0.7rem;
        border: 1px solid rgba(148, 163, 184, 0.4);
        background: #ffffff;
    }

    .sidebar-collapse-btn .collapse-kbd {
        font-size: 9px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        border: 1px solid rgba(148, 163, 184, 0.45);
        background: rgba(255, 255, 255, 0.88);
        color: #64748b;
        padding: 2px 7px;
        border-radius: 999px;
        font-weight: 800;
        line-height: 1;
    }

    body.admin-sidebar-collapsed .sidebar-collapse-btn {
        justify-content: center;
        gap: 0;
    }

    body.admin-sidebar-collapsed .sidebar-collapse-btn .collapse-kbd {
        display: none;
    }

    body.admin-sidebar-collapsed .admin-sidebar {
        width: 5.4rem !important;
    }

    body.admin-sidebar-collapsed .admin-sidebar .sidebar-label,
    body.admin-sidebar-collapsed .admin-sidebar .sidebar-section-label,
    body.admin-sidebar-collapsed .admin-sidebar .sidebar-footer-label,
    body.admin-sidebar-collapsed .admin-sidebar .sidebar-children,
    body.admin-sidebar-collapsed .admin-sidebar .sidebar-brand-subtitle {
        display: none !important;
    }

    body.admin-sidebar-collapsed .admin-sidebar .sidebar-brand {
        justify-content: center;
    }

    body.admin-sidebar-collapsed .admin-sidebar a {
        justify-content: center;
    }

    body.admin-sidebar-collapsed .admin-sidebar .sidebar-active-dot {
        display: none;
    }

    @media (min-width: 1024px) {
        .admin-mobile-sidebar-btn,
        #adminSidebarClose,
        .sidebar-overlay {
            display: none !important;
        }
    }

    @media (max-width: 1023px) {
        .admin-sidebar {
            position: fixed !important;
            left: 0;
            top: 0;
            width: min(20rem, 88vw) !important;
            height: 100vh !important;
            transform: translateX(-104%);
            border-right: 1px solid rgba(255, 255, 255, 0.52);
            border-bottom: 0;
            box-shadow: 0 28px 45px -24px rgba(15, 23, 42, 0.62);
            z-index: 50;
        }

        .admin-sidebar.mobile-open {
            transform: translateX(0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        html {
            scroll-behavior: auto;
        }

        body,
        body.admin-ui-ready,
        body.admin-ui-ready .admin-topbar,
        body.admin-ui-ready .admin-sidebar,
        body.admin-ui-ready .admin-content,
        .admin-reveal,
        .admin-reveal.is-visible,
        .admin-shell a,
        .admin-shell button,
        .admin-shell input,
        .admin-shell select,
        .admin-shell textarea,
        .admin-shell .btn {
            animation: none !important;
            transition: none !important;
            transform: none !important;
        }

        .admin-skeleton-layer {
            display: none !important;
        }
    }

    @media (max-width: 1023px) {
        .admin-skeleton-row {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .admin-skeleton-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<button id="adminSidebarOpen" class="admin-mobile-sidebar-btn w-11 h-11 rounded-xl bg-white/90 border border-slate-200 text-teal-900 shadow-md shadow-slate-200/35 items-center justify-center lg:hidden" type="button" aria-label="Open navigation menu">
    <span class="material-symbols-outlined text-[20px]">menu</span>
</button>

<div id="adminSidebarOverlay" class="sidebar-overlay lg:hidden" aria-hidden="true"></div>

<aside class="admin-sidebar h-auto lg:h-screen w-full lg:w-64 lg:fixed left-0 top-0 surface-glass flex flex-col p-4 lg:p-5 z-50 border-b border-white/60 lg:border-b-0 lg:border-r lg:border-white/45">
    <div class="mb-6 lg:mb-8">
        <div class="flex items-center justify-between gap-2 mb-2">
            <a class="sidebar-brand group flex items-center gap-3 px-3 py-2.5 rounded-2xl bg-white/70 border border-white/80 shadow-sm shadow-slate-200/30 w-full" href="/admin">
                <span class="w-11 h-11 rounded-xl bg-gradient-to-br from-teal-800 to-teal-600 text-white flex items-center justify-center shadow-md shadow-teal-900/25">
                    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">diamond</span>
                </span>
                <span class="leading-tight sidebar-label">
                    <span class="block text-teal-950 font-black tracking-tight text-lg">Mpemba Heritage</span>
                    <span class="sidebar-brand-subtitle block font-['Epilogue'] tracking-[0.12em] uppercase font-bold text-[10px] text-slate-500">Admin Console</span>
                </span>
            </a>
            <button id="adminSidebarClose" class="w-10 h-10 rounded-xl bg-white/90 border border-slate-200 text-slate-600 flex items-center justify-center lg:hidden" type="button" aria-label="Close navigation menu">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <button id="adminSidebarCollapse" class="sidebar-collapse-btn hidden lg:flex items-center justify-between gap-3 w-full py-2 px-3 rounded-xl border border-slate-200/90 bg-white/80 text-slate-700 hover:text-teal-900 hover:bg-white" type="button" aria-label="Collapse sidebar" aria-pressed="false" title="Collapse sidebar">
            <span class="collapse-icon-wrap flex items-center justify-center">
                <span class="material-symbols-outlined text-[18px]">left_panel_close</span>
            </span>
            <span id="adminSidebarCollapseLabel" class="sidebar-footer-label text-[11px] font-bold tracking-[0.12em] uppercase">Collapse</span>
            <span class="collapse-kbd">Tab</span>
        </button>
    </div>
    <div class="px-2 mb-2">
        <p class="sidebar-section-label text-[11px] tracking-[0.18em] uppercase font-extrabold text-slate-500">Navigation</p>
    </div>
    <nav class="flex-1 space-y-1.5 overflow-y-auto pr-1">
        <?php foreach ($navLinks as $link):
            $isActive = \Mpemba\Utils\Router::isRouteActive($link, $currentRoute) || ($activePage === $link['key']);
            $disabled = $link['disabled'] ?? false;
            $linkClasses = $disabled
                ? 'pointer-events-none opacity-50 text-slate-400 bg-slate-100/80 rounded-2xl border border-slate-200/70'
                : ($isActive
                    ? 'bg-gradient-to-r from-teal-900 to-teal-700 text-white font-extrabold rounded-2xl border border-teal-800/40 shadow-md shadow-teal-900/25'
                    : 'text-slate-600 hover:text-teal-900 transition-all duration-200 hover:bg-white/85 rounded-2xl border border-transparent hover:border-slate-200/70');
        ?>
        <a class="group flex items-center gap-3 px-3.5 py-2.5 <?php echo $linkClasses; ?>"
           href="<?php echo htmlspecialchars($link['href']); ?>" <?php echo $disabled ? 'aria-disabled="true"' : ''; ?>>
            <span class="w-9 h-9 rounded-xl flex items-center justify-center <?php echo $isActive ? 'bg-white/20 text-white' : 'bg-white text-slate-500 group-hover:text-teal-800 border border-slate-200/80'; ?> transition-colors">
                <span class="material-symbols-outlined text-[20px]"><?php echo htmlspecialchars($link['icon'] ?? 'chevron_right'); ?></span>
            </span>
            <span class="sidebar-label font-['Epilogue'] tracking-tight font-bold text-[15px] leading-none"><?php echo htmlspecialchars($link['label']); ?></span>
            <?php if ($isActive): ?>
                <span class="sidebar-active-dot ml-auto w-2 h-2 rounded-full bg-white"></span>
            <?php endif; ?>
        </a>
        <?php if (!empty($link['children'])): ?>
            <div class="sidebar-children space-y-1 pl-6 ml-3 border-l border-slate-200/90">
                <?php foreach ($link['children'] as $child):
                    $childActive = \Mpemba\Utils\Router::isRouteActive($child, $currentRoute) || ($activePage === $child['key']);
                    $childDisabled = $child['disabled'] ?? false;
                    $childClasses = $childDisabled
                        ? 'pointer-events-none opacity-50 text-slate-400'
                        : ($childActive
                            ? 'text-teal-900 font-bold bg-teal-50/80 border border-teal-100/80'
                            : 'text-slate-500 hover:text-teal-900 transition-all duration-200 hover:bg-white/70 border border-transparent hover:border-slate-200/60');
                ?>
                    <a class="block px-3 py-1.5 rounded-xl text-sm <?php echo $childClasses; ?>"
                       href="<?php echo htmlspecialchars($child['href']); ?>" <?php echo $childDisabled ? 'aria-disabled="true"' : ''; ?> >
                        <?php echo htmlspecialchars($child['label']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </nav>
    <div class="mt-5 pt-4 border-t border-slate-200/70 space-y-2.5">
        <a class="group bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary py-3.5 px-4 rounded-xl font-black tracking-wide uppercase text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/25 border border-primary/20 hover:scale-[1.02] hover:shadow-xl hover:shadow-primary/35 transition-all duration-300" href="/admin/reports">
            <span class="material-symbols-outlined text-base group-hover:rotate-90 transition-transform duration-300">add</span>
            <span class="sidebar-footer-label">NEW REPORT</span>
            <span class="sidebar-footer-label text-[9px] px-1.5 py-0.5 rounded-full bg-white/20 border border-white/30">AI</span>
        </a>
        <a class="w-full bg-white text-primary py-2.5 px-4 rounded-xl border border-slate-200/80 font-bold text-sm flex items-center justify-center gap-2 hover:bg-surface-container-high transition-colors" href="/admin/logout">
            <span class="material-symbols-outlined text-sm">logout</span>
            <span class="sidebar-footer-label">Logout</span>
        </a>
    </div>
</aside>

<script>
(() => {
    if (window.__adminSidebarInit) {
        return;
    }
    window.__adminSidebarInit = true;

    const body = document.body;
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.getElementById('adminSidebarOverlay');
    const openBtn = document.getElementById('adminSidebarOpen');
    const closeBtn = document.getElementById('adminSidebarClose');
    const collapseBtn = document.getElementById('adminSidebarCollapse');
    const collapseIcon = collapseBtn ? collapseBtn.querySelector('.material-symbols-outlined') : null;
    const collapseLabel = document.getElementById('adminSidebarCollapseLabel');
    const desktopMedia = window.matchMedia('(min-width: 1024px)');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const attachSkeleton = () => {
        if (prefersReducedMotion) {
            return;
        }

        const content = document.querySelector('.admin-content');
        if (!content) {
            return;
        }

        const skeletonLayer = document.createElement('div');
        skeletonLayer.className = 'admin-skeleton-layer';
        skeletonLayer.setAttribute('aria-hidden', 'true');
        skeletonLayer.innerHTML = `
            <div class="admin-skeleton-grid">
                <div class="admin-skeleton-line" style="width: 42%;"></div>
                <div class="admin-skeleton-line" style="width: 68%;"></div>
                <div class="admin-skeleton-row">
                    <div class="admin-skeleton-card"></div>
                    <div class="admin-skeleton-card"></div>
                    <div class="admin-skeleton-card"></div>
                    <div class="admin-skeleton-card"></div>
                </div>
                <div class="admin-skeleton-card admin-skeleton-table"></div>
            </div>
        `;

        content.appendChild(skeletonLayer);

        const hideSkeleton = () => {
            skeletonLayer.classList.add('is-hidden');
            window.setTimeout(() => {
                skeletonLayer.remove();
            }, 260);
        };

        window.setTimeout(hideSkeleton, 420);
    };

    requestAnimationFrame(() => {
        body.classList.add('admin-ui-ready');
    });

    attachSkeleton();

    if (!sidebar) {
        return;
    }

    const syncLayout = () => {
        const isDesktop = desktopMedia.matches;
        const isCollapsed = body.classList.contains('admin-sidebar-collapsed');
        const hasMain = document.querySelectorAll('.admin-main');
        const hasTopbar = document.querySelectorAll('.admin-topbar');
        const desktopLeft = isCollapsed ? '5.4rem' : '16rem';

        hasMain.forEach((el) => {
            el.style.marginLeft = isDesktop ? desktopLeft : '0';
            el.style.width = isDesktop ? `calc(100% - ${desktopLeft})` : '100%';
        });

        hasTopbar.forEach((el) => {
            el.style.left = isDesktop ? desktopLeft : 'auto';
            el.style.right = '0';
            if (!isDesktop) {
                el.style.width = '100%';
            }
        });

        if (collapseIcon) {
            collapseIcon.textContent = isCollapsed ? 'left_panel_open' : 'left_panel_close';
        }

        if (collapseLabel) {
            collapseLabel.textContent = isCollapsed ? 'Expand' : 'Collapse';
        }

        if (collapseBtn) {
            collapseBtn.setAttribute('aria-pressed', isCollapsed ? 'true' : 'false');
            collapseBtn.setAttribute('aria-label', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
            collapseBtn.setAttribute('title', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
        }
    };

    const closeMobile = () => {
        sidebar.classList.remove('mobile-open');
        if (overlay) {
            overlay.classList.remove('open');
        }
        body.classList.remove('sidebar-mobile-open');
    };

    const openMobile = () => {
        sidebar.classList.add('mobile-open');
        if (overlay) {
            overlay.classList.add('open');
        }
        body.classList.add('sidebar-mobile-open');
    };

    if (openBtn) {
        openBtn.addEventListener('click', openMobile);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeMobile);
    }

    if (overlay) {
        overlay.addEventListener('click', closeMobile);
    }

    if (collapseBtn) {
        collapseBtn.addEventListener('click', () => {
            body.classList.toggle('admin-sidebar-collapsed');
            syncLayout();
        });
    }

    const runSectionReveal = () => {
        const revealTargets = document.querySelectorAll(
            '.admin-content section, .admin-content .kpi-card, .admin-content .panel, .admin-content table, .admin-content [class*="rounded-2xl"], .admin-content [class*="rounded-3xl"]'
        );

        if (!revealTargets.length) {
            return;
        }

        if (prefersReducedMotion) {
            revealTargets.forEach((element) => {
                element.classList.add('is-visible');
            });
            return;
        }

        const uniqueTargets = Array.from(new Set(Array.from(revealTargets)));
        uniqueTargets.forEach((element, index) => {
            element.classList.add('admin-reveal');
            element.style.setProperty('--admin-reveal-delay', `${Math.min(index * 35, 380)}ms`);
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -8% 0px'
        });

        uniqueTargets.forEach((element) => observer.observe(element));
    };

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMobile();
        }
    });

    window.addEventListener('resize', () => {
        if (desktopMedia.matches) {
            closeMobile();
        }
        syncLayout();
    });

    syncLayout();
    runSectionReveal();
})();
</script>
