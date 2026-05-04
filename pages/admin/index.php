<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['admin_logged_in'])) {
    echo '<script>window.location.href="/admin/login";</script>';
    return;
}

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin User';
?>

<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 flex flex-col p-4 z-50">
    <div class="mb-10 px-2">
        <h1 class="text-teal-900 font-black tracking-tighter text-2xl">Mpemba Heritage</h1>
        <p class="font-['Epilogue'] tracking-tight font-bold text-sm text-slate-500">Digital Atelier Console</p>
    </div>
    <nav class="flex-1 space-y-1">
        <a class="bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 flex items-center gap-3 px-4 py-3 scale-102 transition-transform duration-200" href="/admin/index">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-['Epilogue'] tracking-tight">Dashboard</span>
        </a>
        <a class="text-slate-500 hover:text-teal-800 hover:bg-white transition-all duration-300 flex items-center gap-3 px-4 py-3 rounded-lg" href="/admin/inventory">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-['Epilogue'] tracking-tight">Inventory</span>
        </a>
        <a class="text-slate-500 hover:text-teal-800 hover:bg-white transition-all duration-300 flex items-center gap-3 px-4 py-3 rounded-lg" href="/admin/orders">
            <span class="material-symbols-outlined">shopping_cart</span>
            <span class="font-['Epilogue'] tracking-tight">Orders</span>
        </a>
        <a class="text-slate-500 hover:text-teal-800 hover:bg-white transition-all duration-300 flex items-center gap-3 px-4 py-3 rounded-lg" href="/admin/customers">
            <span class="material-symbols-outlined">group</span>
            <span class="font-['Epilogue'] tracking-tight">Users</span>
        </a>
        <a class="text-slate-500 hover:text-teal-800 hover:bg-white transition-all duration-300 flex items-center gap-3 px-4 py-3 rounded-lg" href="/admin/feedback">
            <span class="material-symbols-outlined">chat</span>
            <span class="font-['Epilogue'] tracking-tight">Feedback</span>
        </a>
        <a class="text-slate-500 hover:text-teal-800 hover:bg-white transition-all duration-300 flex items-center gap-3 px-4 py-3 rounded-lg" href="/admin/messages">
            <span class="material-symbols-outlined">mail</span>
            <span class="font-['Epilogue'] tracking-tight">Messages</span>
        </a>
        <a class="text-slate-500 hover:text-teal-800 hover:bg-white transition-all duration-300 flex items-center gap-3 px-4 py-3 rounded-lg" href="/admin/subscribers"><span class="material-symbols-outlined">mark_email_read</span><span class="font-['Epilogue'] tracking-tight">Subscribers</span></a>
        <a class="text-slate-500 hover:text-teal-800 hover:bg-white transition-all duration-300 flex items-center gap-3 px-4 py-3 rounded-lg" href="/admin/reports">
            <span class="material-symbols-outlined">analytics</span>
            <span class="font-['Epilogue'] tracking-tight">Analytics</span>
        </a>
        <a class="text-slate-500 hover:text-teal-800 hover:bg-white transition-all duration-300 flex items-center gap-3 px-4 py-3 rounded-lg" href="/admin/settings">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-['Epilogue'] tracking-tight">Settings</span>
        </a>
    </nav>
    <div class="mt-auto p-4 bg-slate-100 rounded-xl space-y-2">
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

<!-- Main Content Area -->
<main class="ml-64 min-h-screen">
    <!-- TopNavBar Component -->
    <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
        <div class="flex items-center flex-1">
            <div class="relative w-full max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input class="w-full bg-surface-container-high border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-teal-900/10 focus:bg-white transition-all" placeholder="Search marketplace records..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex gap-4">
                <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button">
                    <span class="material-symbols-outlined">help_outline</span>
                </button>
            </div>
            <div class="flex items-center gap-3 pl-6 border-l border-slate-100">
                <div class="text-right">
                    <p class="text-sm font-bold text-teal-900 leading-none"><?php echo htmlspecialchars($adminName); ?></p>
                    <p class="text-xs text-slate-500">System Architect</p>
                </div>
                <img alt="Administrator Profile" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
            </div>
        </div>
    </header>

    <div class="pt-24 px-8 pb-12">
        <!-- Hero Title -->
        <div class="mb-10">
            <h2 class="text-4xl font-black text-primary tracking-tighter mb-2">Marketplace Performance</h2>
            <p class="text-on-surface-variant max-w-2xl">Real-time oversight of the Mpemba digital atelier ecosystem. Monitor sales trajectories, vendor health, and customer engagement through a curated editorial lens.</p>
        </div>

        <!-- Bento Grid Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-primary-fixed text-on-primary-fixed rounded-lg">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded-full">+12.4%</span>
                </div>
                <p class="text-sm font-medium text-on-surface-variant mb-1">Total Revenue</p>
                <h3 class="text-2xl font-bold text-primary tracking-tight">$1,284,590.00</h3>
                <div class="mt-4 h-12 w-full flex items-end gap-1">
                    <div class="bg-primary/10 w-full h-[40%] rounded-t-sm"></div>
                    <div class="bg-primary/20 w-full h-[60%] rounded-t-sm"></div>
                    <div class="bg-primary/15 w-full h-[45%] rounded-t-sm"></div>
                    <div class="bg-primary/30 w-full h-[75%] rounded-t-sm"></div>
                    <div class="bg-primary/40 w-full h-[55%] rounded-t-sm"></div>
                    <div class="bg-primary/60 w-full h-[85%] rounded-t-sm"></div>
                    <div class="bg-primary w-full h-full rounded-t-sm"></div>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-secondary-fixed text-on-secondary-fixed rounded-lg">
                        <span class="material-symbols-outlined">shopping_basket</span>
                    </div>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">+5.2%</span>
                </div>
                <p class="text-sm font-medium text-on-surface-variant mb-1">New Orders</p>
                <h3 class="text-2xl font-bold text-primary tracking-tight">3,492</h3>
                <div class="mt-4 h-12 w-full flex items-end gap-1">
                    <div class="bg-secondary/10 w-full h-[30%] rounded-t-sm"></div>
                    <div class="bg-secondary/20 w-full h-[50%] rounded-t-sm"></div>
                    <div class="bg-secondary/15 w-full h-[40%] rounded-t-sm"></div>
                    <div class="bg-secondary/30 w-full h-[60%] rounded-t-sm"></div>
                    <div class="bg-secondary/40 w-full h-[70%] rounded-t-sm"></div>
                    <div class="bg-secondary/60 w-full h-[50%] rounded-t-sm"></div>
                    <div class="bg-secondary w-full h-full rounded-t-sm"></div>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-surface-container-high text-primary rounded-lg">
                        <span class="material-symbols-outlined">storefront</span>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Stable</span>
                </div>
                <p class="text-sm font-medium text-on-surface-variant mb-1">Active Artisans</p>
                <h3 class="text-2xl font-bold text-primary tracking-tight">842</h3>
                <div class="mt-4 h-12 w-full flex items-end gap-1">
                    <div class="bg-primary/20 w-full h-[60%] rounded-t-sm"></div>
                    <div class="bg-primary/20 w-full h-[65%] rounded-t-sm"></div>
                    <div class="bg-primary/20 w-full h-[55%] rounded-t-sm"></div>
                    <div class="bg-primary/20 w-full h-[70%] rounded-t-sm"></div>
                    <div class="bg-primary/20 w-full h-[62%] rounded-t-sm"></div>
                    <div class="bg-primary/20 w-full h-[68%] rounded-t-sm"></div>
                    <div class="bg-primary/40 w-full h-full rounded-t-sm"></div>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-tertiary-fixed text-on-tertiary-fixed rounded-lg">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded-full">+22.8%</span>
                </div>
                <p class="text-sm font-medium text-on-surface-variant mb-1">Monthly Traffic</p>
                <h3 class="text-2xl font-bold text-primary tracking-tight">1.2M</h3>
                <div class="mt-4 h-12 w-full flex items-end gap-1">
                    <div class="bg-tertiary/10 w-full h-[20%] rounded-t-sm"></div>
                    <div class="bg-tertiary/20 w-full h-[35%] rounded-t-sm"></div>
                    <div class="bg-tertiary/15 w-full h-[50%] rounded-t-sm"></div>
                    <div class="bg-tertiary/30 w-full h-[45%] rounded-t-sm"></div>
                    <div class="bg-tertiary/40 w-full h-[75%] rounded-t-sm"></div>
                    <div class="bg-tertiary/60 w-full h-[90%] rounded-t-sm"></div>
                    <div class="bg-tertiary w-full h-full rounded-t-sm"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h4 class="text-xl font-bold text-primary">Sales Performance Over Time</h4>
                        <p class="text-sm text-on-surface-variant">Comparative analysis of gross volume vs net revenue</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-1 rounded-full text-xs font-bold bg-primary text-white" type="button">Monthly</button>
                        <button class="px-4 py-1 rounded-full text-xs font-bold bg-surface-container-high text-on-surface-variant hover:bg-surface-variant transition-colors" type="button">Quarterly</button>
                    </div>
                </div>
                <div class="relative h-64 w-full bg-slate-50/50 rounded-lg flex items-end px-4 gap-4">
                    <div class="flex-1 bg-gradient-to-t from-primary/10 to-primary/30 h-[45%] rounded-t-lg relative group">
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-primary text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">$84k (Feb)</div>
                    </div>
                    <div class="flex-1 bg-gradient-to-t from-primary/10 to-primary/30 h-[55%] rounded-t-lg relative group"></div>
                    <div class="flex-1 bg-gradient-to-t from-primary/10 to-primary/30 h-[48%] rounded-t-lg relative group"></div>
                    <div class="flex-1 bg-gradient-to-t from-primary/10 to-primary/30 h-[75%] rounded-t-lg relative group"></div>
                    <div class="flex-1 bg-gradient-to-t from-primary/10 to-primary/30 h-[85%] rounded-t-lg relative group"></div>
                    <div class="flex-1 bg-gradient-to-t from-primary/10 to-primary/30 h-[70%] rounded-t-lg relative group"></div>
                    <div class="flex-1 bg-gradient-to-t from-secondary/20 to-secondary/60 h-[95%] rounded-t-lg relative group">
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-secondary text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">$142k (Aug)</div>
                    </div>
                </div>
                <div class="flex justify-between mt-4 px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    <span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-8 rounded-xl">
                <h4 class="text-xl font-bold text-primary mb-6">Recent Platform Events</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-900">
                                <span class="material-symbols-outlined text-sm">shopping_bag</span>
                            </div>
                            <div class="absolute top-10 left-1/2 -translate-x-1/2 w-0.5 h-full bg-slate-200"></div>
                        </div>
                        <div class="pb-2">
                            <p class="text-sm font-bold text-primary">New Premium Order #4928</p>
                            <p class="text-xs text-on-surface-variant mb-1">Artisan Leather Collection by Studio V.</p>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">2 minutes ago</span>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-900">
                                <span class="material-symbols-outlined text-sm">person_add</span>
                            </div>
                            <div class="absolute top-10 left-1/2 -translate-x-1/2 w-0.5 h-full bg-slate-200"></div>
                        </div>
                        <div class="pb-2">
                            <p class="text-sm font-bold text-primary">Vendor Application Received</p>
                            <p class="text-xs text-on-surface-variant mb-1">Handmade Ceramics - Kyoto Artisans.</p>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">45 minutes ago</span>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-700">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </div>
                        </div>
                        <div class="pb-2">
                            <p class="text-sm font-bold text-primary">System Update Complete</p>
                            <p class="text-xs text-on-surface-variant mb-1">V2.4 Cloud Infrastructure migration successful.</p>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">2 hours ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <div class="bg-primary text-white p-8 rounded-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="text-xl font-bold mb-8">Dominant Market Categories</h4>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between text-sm mb-2 font-['Epilogue'] font-bold">
                                <span>Heritage Textiles</span>
                                <span>$420k</span>
                            </div>
                            <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                                <div class="bg-secondary h-full rounded-full w-[85%]"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2 font-['Epilogue'] font-bold">
                                <span>Hand-Forged Jewelry</span>
                                <span>$310k</span>
                            </div>
                            <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                                <div class="bg-secondary h-full rounded-full w-[65%]"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2 font-['Epilogue'] font-bold">
                                <span>Sustainable Ceramics</span>
                                <span>$205k</span>
                            </div>
                            <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                                <div class="bg-secondary h-full rounded-full w-[45%]"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full border-[32px] border-white/5 pointer-events-none"></div>
            </div>

            <div class="group relative rounded-xl overflow-hidden shadow-sm h-full min-h-[360px]">
                <img alt="Artisan Showcase" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=1200&h=900&fit=crop&crop=center"/>
                <div class="absolute inset-0 bg-gradient-to-t from-primary via-transparent to-transparent opacity-80"></div>
                <div class="absolute bottom-0 left-0 p-8">
                    <span class="inline-block px-3 py-1 bg-secondary text-on-secondary rounded-full text-[10px] font-bold uppercase tracking-widest mb-3">Artisan Spotlight</span>
                    <h4 class="text-2xl font-bold text-white mb-2 leading-tight">Preserving Heritage Through Modern Craft</h4>
                    <p class="text-white/70 text-sm max-w-sm">How Studio Kaji is redefining traditional weaving for a global digital audience.</p>
                    <a class="mt-6 inline-flex items-center gap-2 text-secondary font-bold text-sm hover:translate-x-2 transition-transform" href="/admin/reports">
                        Read the Story <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="/js/admin.js"></script>