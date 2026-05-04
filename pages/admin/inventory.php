<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin User';
$notificationCount = adminNotificationCount();

// Load products from products.json
$productsFile = __DIR__ . '/../../data/products.json';
$allProducts  = [];
if (file_exists($productsFile)) {
    $decoded = json_decode((string) file_get_contents($productsFile), true);
    if (is_array($decoded)) {
        $allProducts = $decoded;
    }
}

$totalProducts = count($allProducts);
$lowStockCount  = 0;
$activeCount    = 0;
$totalValue     = 0.0;

foreach ($allProducts as $p) {
    $stock  = (int)   ($p['stock_quantity'] ?? 0);
    $price  = (float) ($p['price'] ?? 0);
    $status = strtolower((string) ($p['status'] ?? 'active'));
    $totalValue += $price * $stock;
    if ($status === 'active') { $activeCount++; }
    if ($stock < 40)          { $lowStockCount++; }
}

// Pagination
$perPage      = 20;
$currentPage  = max(1, (int) ($_GET['page'] ?? 1));
$totalPages   = max(1, (int) ceil($totalProducts / $perPage));
$currentPage  = min($currentPage, $totalPages);
$offset       = ($currentPage - 1) * $perPage;
$pageProducts = array_slice($allProducts, $offset, $perPage);
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
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/categories">
                <span class="material-symbols-outlined">category</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Categories</span>
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
            <a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 dark:text-slate-400 hover:text-teal-800 hover:bg-white dark:hover:bg-slate-900 transition-all duration-300 rounded-lg" href="/admin/permissions">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span class="font-['Epilogue'] tracking-tight font-bold text-lg">Permissions</span>
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
                    <input id="invSearch" class="w-full bg-surface-container-high border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/10 transition-all outline-none" placeholder="Search products by name or category..." type="text"/>
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
                <div class="flex flex-wrap gap-3">
                    <button id="exportBtn" class="px-5 py-2.5 bg-white border border-outline-variant/20 rounded-xl text-primary font-bold text-sm flex items-center gap-2 hover:bg-surface-container-low transition-colors shadow-sm" type="button">
                        <span class="material-symbols-outlined text-sm">file_download</span>
                        Export CSV
                    </button>
                    <a href="/admin/add-product" class="inline-flex items-center justify-center px-8 py-2.5 bg-gradient-to-r from-secondary to-secondary-container text-on-secondary rounded-xl font-bold text-sm gap-2 shadow-lg shadow-secondary/20 hover:scale-102 transition-transform duration-200">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add</span>
                        Add New Product
                    </a>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex gap-2 mb-8 flex-wrap">
                <button data-filter="all" class="filter-tab px-5 py-2 rounded-full text-sm font-bold bg-primary text-on-primary shadow-sm transition-all duration-200">All <span class="ml-1 px-2 py-0.5 rounded-full bg-white/20 text-[10px]"><?php echo $totalProducts; ?></span></button>
                <button data-filter="active" class="filter-tab px-5 py-2 rounded-full text-sm font-bold text-on-surface-variant bg-surface-container-high hover:bg-surface-container-highest transition-all duration-200">Active <span class="ml-1 px-2 py-0.5 rounded-full bg-primary/10 text-primary text-[10px]"><?php echo $activeCount; ?></span></button>
                <button data-filter="inactive" class="filter-tab px-5 py-2 rounded-full text-sm font-bold text-on-surface-variant bg-surface-container-high hover:bg-surface-container-highest transition-all duration-200">Inactive <span class="ml-1 px-2 py-0.5 rounded-full bg-primary/10 text-primary text-[10px]"><?php echo $totalProducts - $activeCount; ?></span></button>
                <button data-filter="lowstock" class="filter-tab px-5 py-2 rounded-full text-sm font-bold text-on-surface-variant bg-surface-container-high hover:bg-surface-container-highest transition-all duration-200">Low Stock <span class="ml-1 px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10px]"><?php echo $lowStockCount; ?></span></button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-slate-400 material-symbols-outlined">inventory_2</span>
                        <span class="bg-primary-fixed text-on-primary-fixed text-[10px] font-bold px-2 py-1 rounded-full">+12%</span>
                    </div>
                    <div>
                        <p class="text-3xl font-editorial font-black text-primary">1,482</p>
                        <p class="text-3xl font-editorial font-black text-primary"><?php echo number_format($totalProducts); ?></p>
                        <p class="text-on-surface-variant text-xs uppercase tracking-widest font-bold">Total Products</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-error material-symbols-outlined">warning</span>
                        <span class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-1 rounded-full">Priority</span>
                    </div>
                    <div>
                        <p class="text-3xl font-editorial font-black text-error"><?php echo $lowStockCount; ?></p>
                        <p class="text-on-surface-variant text-xs uppercase tracking-widest font-bold">Low Stock Alerts</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start">
                        <span class="text-tertiary material-symbols-outlined">attach_money</span>
                    </div>
                    <div>
                        <p class="text-3xl font-editorial font-black text-primary">$<?php echo $totalValue >= 1000 ? number_format($totalValue / 1000, 1) . 'k' : number_format($totalValue, 0); ?></p>
                        <p class="text-on-surface-variant text-xs uppercase tracking-widest font-bold">Inventory Value</p>
                    </div>
                </div>
                <div class="bg-primary p-6 rounded-2xl shadow-lg flex flex-col justify-between h-40 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-on-primary/60 text-xs uppercase tracking-widest font-bold mb-1">Active Shipments</p>
                        <p class="text-4xl font-editorial font-black text-white"><?php echo $activeCount; ?></p>
                    </div>
                    <div class="relative z-10 flex items-center gap-2 text-on-primary/80 text-xs">
                        <span class="material-symbols-outlined text-sm">local_shipping</span>
                        Active in Catalog
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-primary-container rounded-full blur-3xl opacity-30"></div>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/5 overflow-hidden">
                <div class="p-6 flex items-center justify-between border-b border-surface-variant/20">
                <div class="p-5 flex items-center justify-between border-b border-surface-variant/20">
                    <span id="selectedCount" class="text-xs text-on-surface-variant font-medium">0 items selected</span>
                    <button id="printBtn" class="p-2 hover:bg-surface-container-low rounded-lg transition-colors text-slate-500" title="Print" type="button">
                        <span class="material-symbols-outlined">print</span>
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="p-5 w-10"><input id="selectAll" class="rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox"/></th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Product Details</th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-center">Category</th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-center">Stock Level</th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-right">Price</th>
                                <th class="p-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-center">Status</th>
                                <th class="p-5 w-10"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-variant/10">
                            <?php foreach ($pageProducts as $p):
                                $stock    = (int)   ($p['stock_quantity'] ?? 0);
                                $price    = (float) ($p['price'] ?? 0);
                                $status   = strtolower((string) ($p['status'] ?? 'active'));
                                $name     = (string) ($p['name'] ?? '');
                                $slug     = (string) ($p['slug'] ?? '');
                                $category = (string) ($p['category'] ?? '');
                                $imgUrl   = (string) ($p['image_url'] ?? '');
                                $id       = (int)   ($p['id'] ?? 0);
                                $sku      = strtoupper(substr($slug, 0, 6)) . '-' . $id;
                                if ($stock === 0)    { $barColor = 'bg-error';    $stockLabel = 'Out of Stock'; $stockClass = 'text-error';    $pct = 2; }
                                elseif ($stock < 40) { $barColor = 'bg-amber-500'; $stockLabel = 'Low ('.$stock.')'; $stockClass = 'text-amber-600'; $pct = max(4, (int)(($stock/200)*100)); }
                                else                 { $barColor = 'bg-primary';  $stockLabel = $stock.' units'; $stockClass = 'text-primary';  $pct = min(100, (int)(($stock/200)*100)); }
                            ?>
                            <tr class="hover:bg-surface-bright transition-colors group inv-row"
                                data-status="<?php echo htmlspecialchars($status); ?>"
                                data-category="<?php echo htmlspecialchars($category); ?>"
                                data-name="<?php echo htmlspecialchars(strtolower($name)); ?>"
                                data-id="<?php echo $id; ?>">
                                <td class="p-5"><input class="row-check rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox" value="<?php echo $id; ?>"/></td>
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                            <img alt="<?php echo htmlspecialchars($name); ?>" class="w-full h-full object-cover" src="<?php echo htmlspecialchars($imgUrl ?: 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=300&h=300&fit=crop'); ?>" onerror="this.src='https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=300&h=300&fit=crop'"/>
                                        </div>
                                        <div>
                                            <p class="font-bold text-primary group-hover:text-secondary transition-colors"><?php echo htmlspecialchars($name); ?></p>
                                            <p class="text-xs text-on-surface-variant">SKU: <?php echo htmlspecialchars($sku); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center"><span class="px-3 py-1 bg-surface-container-highest rounded-full text-[10px] font-bold uppercase tracking-tight text-on-surface-variant"><?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $category))); ?></span></td>
                                <td class="p-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
                                            <div class="<?php echo $barColor; ?> h-full rounded-full" style="width:<?php echo $pct; ?>%"></div>
                                        </div>
                                        <span class="text-xs font-bold <?php echo $stockClass; ?>"><?php echo htmlspecialchars($stockLabel); ?></span>
                                    </div>
                                </td>
                                <td class="p-5 text-right font-editorial font-bold text-primary">$<?php echo number_format($price, 2); ?></td>
                                <td class="p-5 text-center">
                                    <?php if ($status === 'active'): ?>
                                        <span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed text-[10px] font-bold uppercase rounded-full">Active</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-surface-variant text-on-surface-variant text-[10px] font-bold uppercase rounded-full">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-5 relative">
                                    <button class="row-menu-trigger text-slate-400 hover:text-primary transition-colors" type="button">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                    <div class="row-menu hidden absolute right-10 top-2 bg-white rounded-xl shadow-xl border border-slate-100 z-20 w-36 py-1 text-sm">
                                        <button class="row-edit w-full text-left px-4 py-2.5 hover:bg-slate-50 text-primary font-semibold flex items-center gap-2"
                                            data-id="<?php echo $id; ?>"
                                            data-name="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"
                                            data-price="<?php echo $price; ?>"
                                            data-stock="<?php echo $stock; ?>"
                                            data-status="<?php echo htmlspecialchars($status); ?>"
                                            data-category="<?php echo htmlspecialchars($category); ?>">
                                            <span class="material-symbols-outlined text-sm">edit</span>Edit
                                        </button>
                                        <button class="row-delete w-full text-left px-4 py-2.5 hover:bg-red-50 text-red-600 font-semibold flex items-center gap-2"
                                            data-id="<?php echo $id; ?>"
                                            data-name="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>">
                                            <span class="material-symbols-outlined text-sm">delete</span>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($pageProducts)): ?>
                            <tr><td colspan="7" class="py-16 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-5xl mb-3 block">inventory_2</span>
                                <p class="font-bold">No products found</p>
                                <a href="/admin/add-product" class="text-sm text-primary underline mt-1 inline-block">Add your first product</a>
                            </td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="p-5 flex items-center justify-between bg-surface-container-low/30">
                    <p class="text-xs text-on-surface-variant">
                        Showing <span class="font-bold"><?php echo $offset + 1; ?>–<?php echo min($offset + $perPage, $totalProducts); ?></span>
                        of <span class="font-bold"><?php echo number_format($totalProducts); ?></span> products
                    </p>
                    <div class="flex gap-1">
                        <?php if ($currentPage > 1): ?>
                        <a href="?page=<?php echo $currentPage - 1; ?>" class="w-8 h-8 rounded flex items-center justify-center hover:bg-white text-slate-500 transition-colors"><span class="material-symbols-outlined text-sm">chevron_left</span></a>
                        <?php endif; ?>
                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="w-8 h-8 rounded flex items-center justify-center font-bold text-xs transition-colors <?php echo $i === $currentPage ? 'bg-primary text-white' : 'hover:bg-white text-primary'; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                        <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?php echo $currentPage + 1; ?>" class="w-8 h-8 rounded flex items-center justify-center hover:bg-white text-slate-500 transition-colors"><span class="material-symbols-outlined text-sm">chevron_right</span></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="fixed bottom-0 right-0 p-8 pointer-events-none opacity-5">
        <h3 class="text-9xl font-editorial font-black text-primary select-none">MPEMBA</h3>
    </div>
</div>
<!-- Edit Product Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 items-center justify-center">
    <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-editorial font-black text-primary">Edit Product</h3>
            <button id="editModalClose" class="text-slate-400 hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form id="editForm" class="space-y-4">
            <input id="editId" type="hidden"/>
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-1">Product Name</label>
                <input id="editName" class="w-full rounded-xl border border-outline-variant px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="text" required/>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-1">Price (USD)</label>
                    <input id="editPrice" class="w-full rounded-xl border border-outline-variant px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="number" step="0.01" min="0" required/>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-1">Stock Qty</label>
                    <input id="editStock" class="w-full rounded-xl border border-outline-variant px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="number" min="0" required/>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-1">Status</label>
                    <select id="editStatus" class="w-full rounded-xl border border-outline-variant px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-1">Category</label>
                    <select id="editCategory" class="w-full rounded-xl border border-outline-variant px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="atelier-electronics">Electronics</option>
                        <option value="heritage-fashion">Heritage Fashion</option>
                        <option value="natural-beauty">Natural Beauty</option>
                        <option value="lifestyle-essentials">Lifestyle Essentials</option>
                        <option value="sanctuary-home">Sanctuary Home</option>
                    </select>
                </div>
            </div>
            <div id="editError" class="hidden text-sm text-red-600 bg-red-50 rounded-xl px-4 py-2.5"></div>
            <div class="flex gap-3 pt-2">
                <button type="button" id="editCancel" class="flex-1 py-3 rounded-xl border border-outline-variant text-primary font-bold text-sm hover:bg-surface-container-low transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary/90 transition-colors">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    var activeFilter = 'all';
    var invSearch = document.getElementById('invSearch');

    function filterRows() {
        var q = invSearch ? invSearch.value.toLowerCase().trim() : '';
        document.querySelectorAll('.inv-row').forEach(function(row) {
            var name   = row.dataset.name     || '';
            var cat    = row.dataset.category || '';
            var status = row.dataset.status   || '';
            var stockEl = row.querySelector('.text-xs.font-bold');
            var stockTxt = stockEl ? stockEl.textContent.toLowerCase() : '';
            var matchSearch = !q || name.includes(q) || cat.includes(q) || stockTxt.includes(q);
            var matchFilter;
            if      (activeFilter === 'all')      { matchFilter = true; }
            else if (activeFilter === 'active')   { matchFilter = status === 'active'; }
            else if (activeFilter === 'inactive') { matchFilter = status === 'inactive'; }
            else if (activeFilter === 'lowstock') {
                matchFilter = stockTxt.includes('low') || stockTxt.includes('out');
            }
            row.style.display = (matchSearch && matchFilter) ? '' : 'none';
        });
    }

    if (invSearch) { invSearch.addEventListener('input', filterRows); }

    document.querySelectorAll('.filter-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            activeFilter = this.dataset.filter;
            document.querySelectorAll('.filter-tab').forEach(function(b) {
                b.classList.remove('bg-primary', 'text-on-primary', 'shadow-sm');
                b.classList.add('text-on-surface-variant', 'bg-surface-container-high');
            });
            this.classList.add('bg-primary', 'text-on-primary', 'shadow-sm');
            this.classList.remove('text-on-surface-variant', 'bg-surface-container-high');
            filterRows();
        });
    });

    // Row menu
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.row-menu-trigger') && !e.target.closest('.row-menu')) {
            document.querySelectorAll('.row-menu').forEach(function(m) { m.classList.add('hidden'); });
        }
        var trigger = e.target.closest('.row-menu-trigger');
        if (trigger) {
            var row  = trigger.closest('tr');
            var menu = row ? row.querySelector('.row-menu') : null;
            if (menu) {
                document.querySelectorAll('.row-menu').forEach(function(m) { m.classList.add('hidden'); });
                menu.classList.remove('hidden');
            }
        }
    });

    // Edit modal
    function openEdit(btn) {
        document.querySelectorAll('.row-menu').forEach(function(m) { m.classList.add('hidden'); });
        document.getElementById('editId').value       = btn.dataset.id;
        document.getElementById('editName').value     = btn.dataset.name;
        document.getElementById('editPrice').value    = btn.dataset.price;
        document.getElementById('editStock').value    = btn.dataset.stock;
        document.getElementById('editStatus').value   = btn.dataset.status;
        document.getElementById('editCategory').value = btn.dataset.category;
        document.getElementById('editError').classList.add('hidden');
        var m = document.getElementById('editModal');
        m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeEdit() {
        var m = document.getElementById('editModal');
        m.classList.add('hidden'); m.classList.remove('flex');
    }
    document.addEventListener('click', function(e) {
        var eb = e.target.closest('.row-edit');
        if (eb) openEdit(eb);
    });
    document.getElementById('editModalClose')?.addEventListener('click', closeEdit);
    document.getElementById('editCancel')?.addEventListener('click', closeEdit);
    document.getElementById('editModal')?.addEventListener('click', function(e) { if (e.target === this) closeEdit(); });

    document.getElementById('editForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        var errEl = document.getElementById('editError');
        errEl.classList.add('hidden');
        try {
            var r    = await fetch('/api/products.php', {
                method: 'POST', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    action: 'update',
                    id: parseInt(document.getElementById('editId').value),
                    name: document.getElementById('editName').value.trim(),
                    price: parseFloat(document.getElementById('editPrice').value),
                    stock_quantity: parseInt(document.getElementById('editStock').value),
                    status: document.getElementById('editStatus').value,
                    category: document.getElementById('editCategory').value
                })
            });
            var data = await r.json();
            if (data.status === 'success') { closeEdit(); location.reload(); }
            else { errEl.textContent = data.message || 'Update failed.'; errEl.classList.remove('hidden'); }
        } catch { errEl.textContent = 'Network error.'; errEl.classList.remove('hidden'); }
    });

    // Delete
    document.addEventListener('click', async function(e) {
        var db = e.target.closest('.row-delete');
        if (!db) return;
        document.querySelectorAll('.row-menu').forEach(function(m) { m.classList.add('hidden'); });
        if (!confirm('Delete "' + db.dataset.name + '"? This cannot be undone.')) return;
        try {
            var r    = await fetch('/api/products.php', {
                method: 'POST', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({action: 'delete', id: parseInt(db.dataset.id)})
            });
            var data = await r.json();
            if (data.status === 'success') {
                var row = document.querySelector('.inv-row[data-id="' + db.dataset.id + '"]');
                if (row) { row.style.opacity = '0'; row.style.transition = 'opacity 0.3s'; setTimeout(function() { row.remove(); }, 300); }
            } else { alert(data.message || 'Could not delete.'); }
        } catch { alert('Error deleting product.'); }
    });

    // Select all
    var selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.row-check').forEach(function(cb) { cb.checked = selectAll.checked; });
            updateCount();
        });
    }
    document.addEventListener('change', function(e) { if (e.target.classList.contains('row-check')) updateCount(); });
    function updateCount() {
        var n = document.querySelectorAll('.row-check:checked').length;
        var span = document.getElementById('selectedCount');
        if (span) span.textContent = n + ' item' + (n !== 1 ? 's' : '') + ' selected';
    }

    // Export CSV
    document.getElementById('exportBtn')?.addEventListener('click', function() {
        var rows = document.querySelectorAll('.inv-row:not([style*="display: none"])');
        var csv  = ['ID,Name,Category,Price,Stock,Status'];
        rows.forEach(function(row) {
            var name  = (row.querySelector('.font-bold.text-primary')?.textContent.trim() || '').replace(/"/g, '""');
            var price = row.querySelector('.font-editorial')?.textContent.trim().replace('$', '') || '';
            var stock = (row.querySelector('.text-xs.font-bold')?.textContent.trim() || '').replace(/"/g, '""');
            csv.push(row.dataset.id + ',"' + name + '","' + row.dataset.category + '",' + price + ',"' + stock + '",' + row.dataset.status);
        });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv.join('\n')], {type: 'text/csv'}));
        a.download = 'inventory.csv'; a.click();
    });

    // Print
    document.getElementById('printBtn')?.addEventListener('click', function() { window.print(); });
})();
</script>
<script src="/js/admin.js"></script>