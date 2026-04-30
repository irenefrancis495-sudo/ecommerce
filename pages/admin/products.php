<?php
ini_set('display_errors', 0);
error_reporting(0);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /admin/login.php');
    exit;
}

$productsFile = __DIR__ . '/../../data/products.json';
$categoriesFile = __DIR__ . '/../../data/categories.json';
$products = json_decode(file_get_contents($productsFile), true) ?? [];
$categories = json_decode(file_get_contents($categoriesFile), true) ?? [];
$message = '';
$error = '';
$editProduct = null;

// Handle search
$searchQuery = trim($_GET['search'] ?? '');
if ($searchQuery !== '') {
    $products = array_filter($products, function($product) use ($searchQuery) {
        return stripos($product['name'], $searchQuery) !== false || 
               stripos($product['description'], $searchQuery) !== false || 
               stripos($product['category'], $searchQuery) !== false;
    });
}

function normalize_slug($value)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value), '-'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $deleteId = (int) ($_POST['id'] ?? 0);
        $products = array_values(array_filter($products, fn($product) => $product['id'] !== $deleteId));
        file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        header('Location: products.php?success=deleted');
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $allowedCategories = array_column($categories, 'name');
    $category = in_array($category, $allowedCategories) ? $category : ($allowedCategories[0] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);
    $image = trim($_POST['image'] ?? '');
    $status = trim($_POST['status'] ?? 'active');
    $allowedStatuses = ['active', 'draft', 'archived'];
    $status = in_array($status, $allowedStatuses) ? $status : 'active';
    $slug = normalize_slug($name ?: ($_POST['slug'] ?? ''));

    if ($name === '' || $category === '' || $price <= 0) {
        $error = 'Please provide a product name, category, and valid price.';
    } else {
        $productData = [
            'id' => 0,
            'name' => $name,
            'slug' => $slug ?: normalize_slug($name),
            'description' => $description,
            'category' => $category,
            'price' => $price,
            'stock_quantity' => $stock,
            'image' => $image ?: 'https://images.unsplash.com/photo-1513708927376-8d6b8f92ca5c?w=640&fit=crop&crop=faces',
            'status' => $status,
        ];

        $editingId = (int) ($_POST['id'] ?? 0);
        if ($editingId > 0) {
            foreach ($products as &$product) {
                if ($product['id'] === $editingId) {
                    $product = array_merge($product, $productData);
                    $product['id'] = $editingId;
                    break;
                }
            }
            unset($product);
            $message = 'Product updated successfully.';
        } else {
            $productData['id'] = empty($products) ? 1 : max(array_column($products, 'id')) + 1;
            $products[] = $productData;
            $message = 'Product added successfully.';
        }

        file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        header('Location: products.php?success=' . ($editingId > 0 ? 'updated' : 'created'));
        exit;
    }
}

if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    foreach ($products as $product) {
        if ($product['id'] === $editId) {
            $editProduct = $product;
            break;
        }
    }
}

if (isset($_GET['success'])) {
    $successMap = [
        'created' => 'Product created successfully.',
        'updated' => 'Product updated successfully.',
        'deleted' => 'Product deleted successfully.',
    ];
    $message = $successMap[$_GET['success']] ?? 'Changes saved successfully.';
}
?>

<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 z-50 flex flex-col py-6 bg-slate-50 dark:bg-slate-950 font-epilogue font-bold text-sm tracking-tight">
<div class="px-6 mb-10 flex items-center gap-3">
<div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-on-primary">
<span class="material-symbols-outlined text-lg" data-icon="token">token</span>
</div>
<span class="text-xl font-bold font-epilogue text-cyan-950 dark:text-cyan-50">Mpemba Admin</span>
</div>
<nav class="flex-1 px-4 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="index.php">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                Dashboard
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-cyan-900 dark:text-cyan-50 font-bold border-r-4 border-cyan-800 dark:border-cyan-400 bg-slate-200/50 dark:bg-slate-800/50 transition-transform duration-300 scale-102" href="products.php">
<span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                Products
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="orders.php">
<span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
                Orders
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="customers.php">
<span class="material-symbols-outlined" data-icon="people">people</span>
                Customers
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="reports.php">
<span class="material-symbols-outlined" data-icon="query_stats">query_stats</span>
                Reports
            </a>
</nav>
<div class="px-6 pt-6 mt-auto bg-slate-100/50 dark:bg-slate-900/50 py-4 flex items-center gap-3">
<img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=80&h=80&fit=crop&crop=center" />
<div class="overflow-hidden">
<p class="text-xs font-bold truncate">Admin Avatar</p>
<p class="text-[10px] text-slate-500 truncate">Marketplace Controller</p>
</div>
</div>
</aside>

<!-- Main Content -->
<main class="ml-64 min-h-screen bg-surface">
<!-- TopNavBar Component -->
<header class="sticky top-0 w-full z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl flex items-center justify-between px-8 py-4 border-b border-slate-200/10 shadow-sm shadow-slate-200/50 dark:shadow-none">
<div class="flex items-center gap-6 w-1/2">
<form method="get" class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-cyan-800 transition-all rounded-full overflow-hidden">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
<input name="search" value="<?php echo htmlspecialchars($searchQuery); ?>" class="w-full pl-12 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none text-sm focus:ring-0" placeholder="Search products..." type="text"/>
</form>
</div>
<div class="flex items-center gap-4">
<?php if ($searchQuery): ?>
<a href="products.php" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-300 transition">Clear Search</a>
<?php endif; ?>
<a href="products.php" class="px-6 py-3 bg-primary text-on-primary rounded-lg text-sm font-bold flex items-center gap-2 transition-transform hover:scale-102">
<span class="material-symbols-outlined text-sm">refresh</span>
                        Refresh
                    </a>
<div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700 mx-2"></div>
<div class="relative group">
<div class="flex items-center gap-3 cursor-pointer">
<span class="font-manrope text-sm font-semibold text-cyan-900 dark:text-cyan-100">Administrator</span>
<img alt="Administrator Profile" class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=80&h=80&fit=crop&crop=center" />
</div>
<div class="absolute top-full right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
<a href="#" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Profile</a>
<a href="#" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Settings</a>
<a href="logout.php" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Logout</a>
</div>
</div>
</div>
</header>

<section class="p-8 space-y-8">
<!-- Header -->
<div class="flex items-end justify-between">
<div>
<span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">Product Management</span>
<h1 class="text-4xl font-black font-display text-primary leading-tight"><?php echo $editProduct ? 'Edit Product' : 'Create New Product'; ?></h1>
<p class="text-on-surface-variant mt-2">Manage your catalog, pricing, and inventory levels.</p>
</div>
<div class="flex gap-4">
<span class="px-4 py-2 bg-surface-container text-on-surface-variant rounded-lg text-sm font-medium">
<?php echo count($products); ?> products<?php echo $searchQuery ? ' found' : ' total'; ?>
</span>
</div>
</div>

<?php if ($message): ?>
<div class="rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-sm text-green-900">
<?php echo htmlspecialchars($message); ?>
</div>
<?php endif; ?>
<?php if ($error): ?>
<div class="rounded-2xl border border-red-200 bg-red-50 px-6 py-4 text-sm text-red-900">
<?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<div class="grid gap-8 lg:grid-cols-[1.35fr_0.65fr]">
<div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
<form method="post" class="space-y-6">
<input type="hidden" name="action" value="save">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($editProduct['id'] ?? ''); ?>">
<div class="grid gap-6 md:grid-cols-2">
<div class="space-y-2">
<label class="text-sm font-semibold text-slate-700">Product Name</label>
<input name="name" value="<?php echo htmlspecialchars($editProduct['name'] ?? ''); ?>" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" type="text" placeholder="Enter product name">
</div>
<div class="space-y-2">
<label class="text-sm font-semibold text-slate-700">Category</label>
<select name="category" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
<option value="">Select category</option>
<?php foreach ($categories as $category): ?>
<option value="<?php echo htmlspecialchars($category['name']); ?>" <?php echo isset($editProduct['category']) && $editProduct['category'] === $category['name'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['name']); ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="space-y-2">
<label class="text-sm font-semibold text-slate-700">Price</label>
<input name="price" value="<?php echo htmlspecialchars($editProduct['price'] ?? ''); ?>" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" type="number" step="0.01" min="0" placeholder="0.00">
</div>
<div class="space-y-2">
<label class="text-sm font-semibold text-slate-700">Stock Quantity</label>
<input name="stock" value="<?php echo htmlspecialchars($editProduct['stock_quantity'] ?? ''); ?>" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" type="number" min="0" placeholder="0">
</div>
<div class="space-y-2 md:col-span-2">
<label class="text-sm font-semibold text-slate-700">Image URL</label>
<input name="image" value="<?php echo htmlspecialchars($editProduct['image'] ?? ''); ?>" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" type="url" placeholder="https://example.com/image.jpg">
</div>
<div class="space-y-2 md:col-span-2">
<label class="text-sm font-semibold text-slate-700">Description</label>
<textarea name="description" rows="4" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" placeholder="Short product description"><?php echo htmlspecialchars($editProduct['description'] ?? ''); ?></textarea>
</div>
<div class="space-y-2">
<label class="text-sm font-semibold text-slate-700">Status</label>
<select name="status" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
<option value="active" <?php echo isset($editProduct['status']) && $editProduct['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
<option value="draft" <?php echo isset($editProduct['status']) && $editProduct['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
<option value="archived" <?php echo isset($editProduct['status']) && $editProduct['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
</select>
</div>
<div class="space-y-2">
<label class="text-sm font-semibold text-slate-700">Slug</label>
<input name="slug" value="<?php echo htmlspecialchars($editProduct['slug'] ?? ''); ?>" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" type="text" placeholder="optional slug">
</div>
</div>
<div class="flex flex-wrap gap-3 items-center justify-between pt-4 border-t border-slate-200">
<button type="submit" class="px-6 py-3 bg-primary text-on-primary rounded-2xl text-sm font-bold transition hover:bg-primary-dark">
<?php echo $editProduct ? 'Save Changes' : 'Create Product'; ?>
</button>
<?php if ($editProduct): ?>
<a href="products.php" class="text-sm font-bold text-slate-600 hover:text-slate-900">Cancel edit</a>
<?php endif; ?>
</div>
</form>
</div>

<div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
<h2 class="text-xl font-bold text-primary mb-4">Quick Actions</h2>
<p class="text-sm text-on-surface-variant mb-6">Manage product catalog items from a single screen. Use the edit button to update product details or remove items that are no longer available.</p>
<ul class="space-y-3 text-sm">
<li class="flex items-center gap-3">
<span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-secondary/10 text-secondary">+</span>
<strong>Create new product</strong> to add items quickly.
</li>
<li class="flex items-center gap-3">
<span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-primary/10 text-primary">✎</span>
<strong>Edit existing product</strong> to adjust pricing or inventory.
</li>
<li class="flex items-center gap-3">
<span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-red-100 text-red-600">–</span>
<strong>Delete inventory</strong> to remove discontinued items safely.
</li>
</ul>
</div>
</div>

<div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm">
<div class="p-6 border-b border-surface-container-highest flex items-center justify-between">
<h2 class="text-xl font-bold text-primary">Product Catalog</h2>
</div>
<div class="overflow-x-auto">
<table class="w-full min-w-[900px] border-separate border-spacing-0">
<thead class="bg-surface-container-highest">
<tr>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Product</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Category</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Price</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Stock</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Status</th>
<th class="px-6 py-4 text-left text-xs font-bold text-outline uppercase tracking-wider">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container-highest bg-white">
<?php foreach ($products as $product): ?>
<tr class="hover:bg-surface-container transition-colors">
<td class="px-6 py-4 align-top">
<div class="flex items-center gap-4">
<img class="w-14 h-14 rounded-2xl object-cover" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
<div>
<p class="font-bold text-primary"><?php echo htmlspecialchars($product['name']); ?></p>
<p class="text-xs text-on-surface-variant">ID: <?php echo $product['id']; ?></p>
</div>
</div>
</td>
<td class="px-6 py-4 align-top">
<?php echo htmlspecialchars($product['category']); ?>
</td>
<td class="px-6 py-4 align-top font-bold text-primary">
$<?php echo number_format($product['price'], 2); ?>
</td>
<td class="px-6 py-4 align-top">
<?php if ($product['stock_quantity'] > 10): ?>
<span class="text-green-600 font-medium"><?php echo $product['stock_quantity']; ?> in stock</span>
<?php elseif ($product['stock_quantity'] > 0): ?>
<span class="text-yellow-600 font-medium"><?php echo $product['stock_quantity']; ?> low stock</span>
<?php else: ?>
<span class="text-red-600 font-medium">Out of stock</span>
<?php endif; ?>
</td>
<td class="px-6 py-4 align-top">
<?php 
$status = $product['status'] ?? 'active';
$statusClass = match($status) {
    'active' => 'bg-green-100 text-green-800',
    'draft' => 'bg-slate-100 text-slate-800',
    'archived' => 'bg-red-100 text-red-800',
    default => 'bg-gray-100 text-gray-800'
};
$statusText = ucfirst($status);
?>
<span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $statusClass; ?>">
<?php echo htmlspecialchars($statusText); ?>
</span>
</td>
<td class="px-6 py-4 align-top">
<div class="flex flex-wrap gap-2">
<a href="products.php?edit=<?php echo $product['id']; ?>" class="inline-flex items-center gap-1 rounded-2xl border border-slate-200 px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 transition">Edit</a>
<form method="post" class="inline-block" onsubmit="return confirm('Delete this product?');">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="id" value="<?php echo $product['id']; ?>">
<button type="submit" class="inline-flex items-center gap-1 rounded-2xl bg-red-600 px-3 py-2 text-xs font-bold text-white hover:bg-red-700 transition">Delete</button>
</form>
</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</section>
</main>