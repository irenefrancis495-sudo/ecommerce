<?php require_once __DIR__ . '/../config/bootstrap.php';
include __DIR__ . '/../components/ui/navbar.php';

$itemsPerPage = 10;

// Read filters from querystring (search, category, page, sort)
$currentSearch = trim((string) ($_GET['search'] ?? ''));
$currentCategory = trim((string) ($_GET['category'] ?? ''));
$currentPage = max(1, (int) ($_GET['page'] ?? 1));
$currentSort = trim((string) ($_GET['sort'] ?? 'featured'));

$products = [];
$categories = [];
try {
    $products = \Mpemba\Entity\Product::getAllProducts($itemsPerPage);
    $categories = \Mpemba\Entity\Category::getAllCategories();
} catch (\Throwable $e) {
    // In production, you would log this error and show a user-friendly message
    $products = ['products' => [], 'total' => 0, 'pages' => 1];
    $categories = [];
}

$pages = range(1, max(1, (int) ($products['pages'] ?? 1)));
?>

<main class="pt-40 pb-24 max-w-7xl mx-auto px-6 sm:px-8">
    <!-- Hero Header Composition -->
    <header class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-24 items-end">
        <div class="md:col-span-7">
            <p class="font-label text-primary uppercase tracking-[0.3em] text-xs mb-6 font-bold">The Digital Atelier</p>
            <h1 class="font-display text-6xl md:text-7xl lg:text-8xl font-black text-slate-900 leading-none tracking-tighter mb-6">All <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Products</span></h1>
            <p class="mt-8 text-slate-600 max-w-lg leading-relaxed text-lg font-medium">
                Discover our curated collection of premium products across all categories. From cutting-edge electronics to natural beauty essentials, handpicked for quality and style.
            </p>
        </div>
        <div class="md:col-span-5">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-secondary/10 to-tertiary/20 rounded-3xl blur-2xl"></div>
                <div class="aspect-[4/3] rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-12 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.3),transparent_50%)]"></div>
                    <div class="text-center relative z-10">
                        <span class="material-symbols-outlined text-9xl text-white/40 mb-4 block">shopping_bag</span>
                        <p class="text-white font-bold text-2xl">Premium Collection</p>
                        <p class="text-slate-400 text-sm mt-2">Quality & Style Combined</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Filters and Controls -->
    <div class="mb-16">
            <!-- Search & Filter Form -->
            <div class="mb-8">
                <form id="productFilterForm" method="get" action="/products" class="relative max-w-2xl focus-within:ring-2 focus-within:ring-primary/30 rounded-2xl">
                    <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                    <input id="productSearchInput" name="search" value="<?= htmlspecialchars($currentSearch) ?>" class="w-full bg-white border-2 border-slate-200 text-slate-900 placeholder-slate-400 rounded-2xl py-4 pl-14 pr-6 text-base focus:outline-none focus:border-primary focus:ring-0 transition-all shadow-sm hover:border-slate-300" placeholder="Search by name, category, or description..." type="search" />
                    <input type="hidden" name="page" value="1" />
                </form>
            </div>

        <!-- Filter and Sort Controls -->
        <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
            <!-- Category Filters -->
            <div class="flex flex-wrap gap-3">
                <?php
                // Build a base query keeping current search and sort but resetting page when changing category
                $baseQuery = $_GET;
                // helper to build href with category (use id when available)
                function categoryHref($baseQuery, $catVal = null) {
                    if ($catVal === null) {
                        unset($baseQuery['category']);
                    } else {
                        $baseQuery['category'] = $catVal;
                    }
                    $baseQuery['page'] = 1;
                    $q = http_build_query($baseQuery);
                    return $q ? ('?' . $q) : '/products';
                }
                ?>
                <a class="px-5 py-2.5 rounded-full <?= $currentCategory === '' ? 'bg-primary text-white font-semibold' : 'bg-white border-2 border-slate-200 text-slate-700 font-medium' ?> hover:bg-primary/90 hover:text-white transition-all duration-200" href="<?= categoryHref($baseQuery, null) ?>">All Products</a>
                <?php foreach ($categories as $category):
                    $catId = $category['id'] ?? $category['name'];
                    $isActive = ((string)$currentCategory === (string)$catId);
                ?>
                    <a class="px-5 py-2.5 rounded-full <?= $isActive ? 'bg-primary text-white font-semibold' : 'bg-white border-2 border-slate-200 text-slate-700 font-medium' ?> hover:border-primary hover:text-primary hover:bg-primary/5 transition-all duration-200" href="<?= categoryHref($baseQuery, $catId) ?>"><?= htmlspecialchars($category['name']) ?></a>
                <?php endforeach; ?>
          
            </div>

            <!-- Sort Dropdown -->
            <div class="relative min-w-max">
                <select class="appearance-none px-6 py-2.5 rounded-lg bg-white border-2 border-slate-200 text-slate-700 font-medium focus:outline-none focus:border-primary transition-all cursor-pointer hover:border-slate-300 pr-10" id="sortSelect">
                    <option value="featured">Featured</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="rating">Top Rated</option>
                    <option value="name">A-Z</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">unfold_more</span>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-20" id="productsGrid">
        <?php if (empty($products['products'])): ?>
            <div class="col-span-full rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-br from-slate-50 to-slate-100 p-20 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300 block mb-4">shopping_bag</span>
                <p class="text-2xl font-bold text-slate-700 mb-2">No products found</p>
                <p class="text-slate-500 max-w-lg mx-auto">Try adjusting your filters, search terms, or explore other categories to find what you're looking for.</p>
            </div>
        <?php else: ?>
            <?php foreach ($products['products'] as $product):
                $imageUrl = \Mpemba\Utils\Utility::getProductImageUrl($product, $product['category_name'] ?? null);
            ?>
                <div class="group bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden hover:shadow-xl hover:border-slate-300 transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                    <div class="aspect-square bg-gradient-to-br from-slate-100 to-slate-200 relative overflow-hidden">
                        <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=400&h=400&fit=crop&crop=center'">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                        <button class="absolute top-4 right-4 w-11 h-11 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg hover:bg-white transform hover:scale-110">
                            <span class="material-symbols-outlined text-lg text-red-500">favorite</span>
                        </button>
                        <?php if ($product['featured']): ?>
                            <span class="absolute top-4 left-4 px-3 py-1 bg-gradient-to-r from-primary to-secondary text-white text-xs font-bold rounded-full shadow-lg">✨ Featured</span>
                        <?php endif; ?>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-full capitalize"><?= htmlspecialchars($product['category_name']) ?></span>
                            <div class="flex items-center gap-1.5 bg-amber-50 px-2.5 py-1 rounded-lg">
                                <span class="material-symbols-outlined text-sm text-amber-500">star</span>
                                <span class="text-sm font-bold text-amber-900"><?= htmlspecialchars($product['rating']) ?></span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="text-slate-600 mb-4"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="flex items-center justify-between gap-4 mt-auto">
                            <span class="text-2xl font-bold text-primary">$<?= number_format($product['price'], 2) ?></span>
                            <form method="post" action="/pages/cart_add.php" class="m-0">
                                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>" />
                                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
     <?php if (count($pages) > 1): ?>
    <div class="flex justify-center items-center">
        <div class="flex items-center gap-2 bg-white rounded-xl p-2 border border-slate-200 shadow-md">
            <?php
            $queryBase = $_GET;
            $prevDisabled = $currentPage <= 1;
            $nextDisabled = $currentPage >= count($pages);
            $prevPage = max(1, $currentPage - 1);
            $nextPage = min(count($pages), $currentPage + 1);
            ?>
            <a class="p-2.5 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all <?= $prevDisabled ? 'opacity-50 pointer-events-none' : '' ?>" href="?<?= http_build_query(array_merge($queryBase, ['page' => $prevPage])) ?>" title="Previous page">
                <span class="material-symbols-outlined">chevron_left</span>
            </a>
            <div class="flex gap-1.5">
                <?php foreach ($pages as $p): ?>
                    <?php $active = $p === $currentPage; ?>
                    <a class="px-3.5 py-1.5 rounded-lg font-semibold transition-all duration-200 <?= $active ? 'bg-gradient-to-r from-primary to-primary/90 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>" href="?<?= http_build_query(array_merge($queryBase, ['page' => $p])) ?>"><?= $p ?></a>
                <?php endforeach; ?>
            </div>
            <a class="p-2.5 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all <?= $nextDisabled ? 'opacity-50 pointer-events-none' : '' ?>" href="?<?= http_build_query(array_merge($queryBase, ['page' => $nextPage])) ?>" title="Next page">
                <span class="material-symbols-outlined">chevron_right</span>
            </a>
        </div>
    </div>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/../components/ui/footer.php'; ?>
<script>
    (function(){
        const form = document.getElementById('productFilterForm');
        const sort = document.getElementById('sortSelect');
        const search = document.getElementById('productSearchInput');

        if (sort && form) {
            sort.addEventListener('change', function(){
                // keep current page at 1 when changing sort
                const pageInput = form.querySelector('input[name="page"]');
                if (pageInput) pageInput.value = '1';
                form.submit();
            });
        }

        if (search && form) {
            search.addEventListener('keydown', function(e){
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const pageInput = form.querySelector('input[name="page"]');
                    if (pageInput) pageInput.value = '1';
                    form.submit();
                }
            });
        }
    })();
</script>