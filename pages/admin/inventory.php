<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['admin_logged_in'])) {
    echo '<script>window.location.href="/admin/login";</script>';
    return;
}
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin User';
$notificationCount = adminNotificationCount();
?>

<style>
    body { font-family: 'Manrope', sans-serif; }
    .font-editorial { font-family: 'Epilogue', sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .glass-panel { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); }
</style>

<div class="bg-surface text-on-surface flex min-h-screen">
    <!-- SideNavBar -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-950 flex flex-col h-full p-4 z-50">
        <div class="mb-8 px-2">
            <h1 class="text-teal-900 dark:text-teal-500 font-black tracking-tighter text-2xl font-editorial">Mpemba Heritage</h1>
            <p class="text-slate-500 text-xs font-medium tracking-widest uppercase mt-1">Digital Atelier Console</p>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg group" href="/admin/index">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 bg-white dark:bg-slate-900 text-teal-900 dark:text-teal-400 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/inventory">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Inventory</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/orders">
                <span class="material-symbols-outlined">shopping_cart</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/customers">
                <span class="material-symbols-outlined">group</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Users</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/feedback">
                <span class="material-symbols-outlined">chat</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Feedback</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/messages">
                <span class="material-symbols-outlined">mail</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Messages</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/subscribers"><span class="material-symbols-outlined">mark_email_read</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Subscribers</span></a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/reports">
                <span class="material-symbols-outlined">analytics</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Analytics</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/settings">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Settings</span>
            </a>
        </nav>
        <div class="mt-auto p-2 bg-slate-100 dark:bg-slate-900 rounded-xl space-y-2">
            <a class="group w-full bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary py-3.5 rounded-xl font-black tracking-wide uppercase text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/25 border border-primary/20 hover:scale-[1.03] hover:shadow-xl hover:shadow-primary/35 transition-all duration-300" href="/admin/reports">
                <span class="material-symbols-outlined text-base group-hover:rotate-90 transition-transform duration-300">add</span>
                NEW REPORT
                <span class="text-[9px] px-1.5 py-0.5 rounded-full bg-white/20 border border-white/30">AI</span>
            </a>
            <a class="w-full bg-surface-container-high text-primary py-2.5 rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-colors" href="/admin/logout">
                <span class="material-symbols-outlined text-sm">logout</span>
                Logout
            </a>
        </div>
    </aside>

    <!-- Main Content Canvas -->
    <main class="flex-1 ml-64 min-h-screen relative">
        <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl shadow-sm shadow-slate-200/20 flex items-center justify-between px-8 z-40">
            <div class="flex items-center gap-8 flex-1">
                <div class="relative w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                    <input class="w-full bg-surface-container-high border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/10 transition-all outline-none" placeholder="Search marketplace inventory..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4 border-r border-outline-variant/30 pr-6">
                    <a class="relative text-slate-600 dark:text-slate-400 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications">
                        <span class="material-symbols-outlined">notifications</span>
                        <?php if ($notificationCount > 0): ?>
                        <span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span>
                        <?php endif; ?>
                    </a>
                    <button class="text-slate-600 dark:text-slate-400 hover:text-amber-700 transition-colors" type="button">
                        <span class="material-symbols-outlined">help_outline</span>
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-bold text-primary leading-tight"><?php echo htmlspecialchars($adminName); ?></p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-tighter">System Curator</p>
                    </div>
                    <img alt="Administrator Profile" class="w-9 h-9 rounded-full bg-slate-200 object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
                </div>
            </div>
        </header>

        <div class="pt-24 pb-12 px-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div class="max-w-2xl">
                    <h2 class="text-5xl font-editorial font-black text-primary tracking-tight leading-none mb-4">Inventory <span class="text-secondary italic">Curations</span></h2>
                    <p class="text-on-surface-variant text-lg max-w-lg leading-relaxed">Manage the digital atelier's collection. Monitor stock levels, refine product positioning, and orchestrate fulfillment flows from a single editorial interface.</p>
                </div>
                <div class="flex gap-3">
                    <button class="px-6 py-3 bg-white border border-outline-variant/20 rounded-xl text-primary font-bold text-sm flex items-center gap-2 hover:bg-surface-container-low transition-colors shadow-sm" type="button">
                        <span class="material-symbols-outlined text-sm">filter_list</span>
                        Advanced Filters
                    </button>
                    <a href="/admin/add-product" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-secondary to-secondary-container text-on-secondary rounded-xl font-bold text-sm gap-2 shadow-lg shadow-secondary/20 hover:scale-102 transition-transform duration-200">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add</span>
                        Add New Product
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-slate-400 material-symbols-outlined">inventory_2</span>
                        <span class="bg-primary-fixed text-on-primary-fixed text-[10px] font-bold px-2 py-1 rounded-full">+12%</span>
                    </div>
                    <div>
                        <p class="text-3xl font-editorial font-black text-primary">1,482</p>
                        <p class="text-on-surface-variant text-xs uppercase tracking-widest font-bold">Total SKUs</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-error material-symbols-outlined">warning</span>
                        <span class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-1 rounded-full">Priority</span>
                    </div>
                    <div>
                        <p class="text-3xl font-editorial font-black text-error">24</p>
                        <p class="text-on-surface-variant text-xs uppercase tracking-widest font-bold">Low Stock Alerts</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-tertiary material-symbols-outlined">attach_money</span>
                    </div>
                    <div>
                        <p class="text-3xl font-editorial font-black text-primary">$284.5k</p>
                        <p class="text-on-surface-variant text-xs uppercase tracking-widest font-bold">Inventory Value</p>
                    </div>
                </div>
                <div class="bg-primary p-6 rounded-2xl shadow-lg flex flex-col justify-between h-40 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-on-primary/60 text-xs uppercase tracking-widest font-bold mb-1">Active Shipments</p>
                        <p class="text-4xl font-editorial font-black text-white">86</p>
                    </div>
                    <div class="relative z-10 flex items-center gap-2 text-on-primary/80 text-xs">
                        <span class="material-symbols-outlined text-sm">local_shipping</span>
                        In Transit Worldwide
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-primary-container rounded-full blur-3xl opacity-30"></div>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/5 overflow-hidden">
                <div class="p-6 flex items-center justify-between border-b border-surface-variant/20">
                    <div class="flex items-center gap-4">
                        <button class="bg-surface-container-high px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 text-primary hover:bg-surface-container-highest transition-colors" type="button">
                            Bulk Actions
                            <span class="material-symbols-outlined text-xs">expand_more</span>
                        </button>
                        <span class="text-xs text-on-surface-variant font-medium">12 items selected</span>
                    </div>
                    <div class="flex gap-2">
                        <button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors text-slate-500" type="button">
                            <span class="material-symbols-outlined">file_download</span>
                        </button>
                        <button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors text-slate-500" type="button">
                            <span class="material-symbols-outlined">print</span>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="p-5 w-10"><input class="rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox"/></th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Product Details</th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-center">Category</th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-center">Stock Level</th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-right">Price</th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-center">Status</th>
                                <th class="p-5 w-10"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-variant/10">
                            <tr class="hover:bg-surface-bright transition-colors group">
                                <td class="p-5"><input class="rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox"/></td>
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                            <img alt="Premium Footwear" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1614253429340-98120bd6d64e?w=300&h=300&fit=crop"/>
                                        </div>
                                        <div>
                                            <p class="font-bold text-primary group-hover:text-secondary transition-colors">Nomad Leather Artisan Boots</p>
                                            <p class="text-xs text-on-surface-variant">SKU: NH-29384-BL</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-surface-container-highest rounded-full text-[10px] font-bold uppercase tracking-tight text-on-surface-variant">Footwear</span></td>
                                <td class="p-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden"><div class="bg-primary h-full w-[85%] rounded-full"></div></div>
                                        <span class="text-xs font-bold text-primary">142 units</span>
                                    </div>
                                </td>
                                <td class="p-5 text-right font-editorial font-bold text-primary">$420.00</td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed text-[10px] font-bold uppercase rounded-full">Active</span></td>
                                <td class="p-5"><button class="text-slate-400 hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined">more_vert</span></button></td>
                            </tr>

                            <tr class="hover:bg-surface-bright transition-colors group">
                                <td class="p-5"><input class="rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox"/></td>
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                            <img alt="Smart Watch" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&h=300&fit=crop"/>
                                        </div>
                                        <div>
                                            <p class="font-bold text-primary group-hover:text-secondary transition-colors">Titanium Chronos v2</p>
                                            <p class="text-xs text-on-surface-variant">SKU: TC-88122-TI</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-surface-container-highest rounded-full text-[10px] font-bold uppercase tracking-tight text-on-surface-variant">Electronics</span></td>
                                <td class="p-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden"><div class="bg-error h-full w-[12%] rounded-full shadow-[0_0_8px_rgba(186,26,26,0.4)]"></div></div>
                                        <span class="text-xs font-bold text-error">Low Stock (8)</span>
                                    </div>
                                </td>
                                <td class="p-5 text-right font-editorial font-bold text-primary">$1,299.00</td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed text-[10px] font-bold uppercase rounded-full">Active</span></td>
                                <td class="p-5"><button class="text-slate-400 hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined">more_vert</span></button></td>
                            </tr>

                            <tr class="hover:bg-surface-bright transition-colors group">
                                <td class="p-5"><input class="rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox"/></td>
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                            <img alt="High End Headphones" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=300&fit=crop"/>
                                        </div>
                                        <div>
                                            <p class="font-bold text-primary group-hover:text-secondary transition-colors">Symphony ANC Headphones</p>
                                            <p class="text-xs text-on-surface-variant">SKU: SY-10492-MK</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-surface-container-highest rounded-full text-[10px] font-bold uppercase tracking-tight text-on-surface-variant">Audio</span></td>
                                <td class="p-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden"><div class="bg-primary h-full w-[45%] rounded-full"></div></div>
                                        <span class="text-xs font-bold text-primary">56 units</span>
                                    </div>
                                </td>
                                <td class="p-5 text-right font-editorial font-bold text-primary">$350.00</td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-surface-variant text-on-surface-variant text-[10px] font-bold uppercase rounded-full">Inactive</span></td>
                                <td class="p-5"><button class="text-slate-400 hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined">more_vert</span></button></td>
                            </tr>

                            <tr class="hover:bg-surface-bright transition-colors group">
                                <td class="p-5"><input class="rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox"/></td>
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                            <img alt="Premium Ceramics" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1612196808214-b7e239e5a6b0?w=300&h=300&fit=crop"/>
                                        </div>
                                        <div>
                                            <p class="font-bold text-primary group-hover:text-secondary transition-colors">Earthenware Vessel Set</p>
                                            <p class="text-xs text-on-surface-variant">SKU: EW-55221-NM</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-surface-container-highest rounded-full text-[10px] font-bold uppercase tracking-tight text-on-surface-variant">Home Decor</span></td>
                                <td class="p-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden"><div class="bg-primary h-full w-[62%] rounded-full"></div></div>
                                        <span class="text-xs font-bold text-primary">89 units</span>
                                    </div>
                                </td>
                                <td class="p-5 text-right font-editorial font-bold text-primary">$185.00</td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed text-[10px] font-bold uppercase rounded-full">Active</span></td>
                                <td class="p-5"><button class="text-slate-400 hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined">more_vert</span></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-5 flex items-center justify-between bg-surface-container-low/30">
                    <p class="text-xs text-on-surface-variant">Showing <span class="font-bold">1-4</span> of <span class="font-bold">1,482</span> products</p>
                    <div class="flex gap-1">
                        <button class="w-8 h-8 rounded flex items-center justify-center hover:bg-white text-slate-400" type="button"><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                        <button class="w-8 h-8 rounded flex items-center justify-center bg-primary text-white font-bold text-xs" type="button">1</button>
                        <button class="w-8 h-8 rounded flex items-center justify-center hover:bg-white text-primary font-bold text-xs" type="button">2</button>
                        <button class="w-8 h-8 rounded flex items-center justify-center hover:bg-white text-primary font-bold text-xs" type="button">3</button>
                        <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
                        <button class="w-8 h-8 rounded flex items-center justify-center hover:bg-white text-primary font-bold text-xs" type="button">372</button>
                        <button class="w-8 h-8 rounded flex items-center justify-center hover:bg-white text-slate-400" type="button"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="fixed bottom-0 right-0 p-8 pointer-events-none opacity-5">
        <h3 class="text-9xl font-editorial font-black text-primary select-none">MPEMBA</h3>
    </div>
</div>
<script src="/js/admin.js"></script>