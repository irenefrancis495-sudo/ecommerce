<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin User';
$flash = '';
$flashType = 'success';
$categories = [
    'atelier-electronics' => 'Electronics',
    'heritage-fashion' => 'Heritage Fashion',
    'natural-beauty' => 'Natural Beauty',
    'lifestyle-essentials' => 'Lifestyle Essentials',
    'sanctuary-home' => 'Sanctuary Home',
];
$statuses = ['active' => 'Active', 'inactive' => 'Inactive'];
$featuredOptions = ['1' => 'Yes', '0' => 'No'];

$formData = [
    'name' => '',
    'description' => '',
    'price' => '',
    'stock_quantity' => '',
    'category' => 'atelier-electronics',
    'image_url' => '',
    'featured' => '0',
    'status' => 'active',
];

function slugify(string $text): string {
    $text = preg_replace('~[^\r\n\pL\d]+~u', '-', $text);
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text ?: 'product-' . time());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'name' => trim((string) ($_POST['name'] ?? '')),
        'description' => trim((string) ($_POST['description'] ?? '')),
        'price' => trim((string) ($_POST['price'] ?? '')),
        'stock_quantity' => trim((string) ($_POST['stock_quantity'] ?? '')),
        'category' => trim((string) ($_POST['category'] ?? 'atelier-electronics')),
        'image_url' => trim((string) ($_POST['image_url'] ?? '')),
        'featured' => isset($_POST['featured']) && $_POST['featured'] === '1' ? '1' : '0',
        'status' => trim((string) ($_POST['status'] ?? 'active')),
    ];

    $errors = [];
    if ($formData['name'] === '') {
        $errors[] = 'Product name is required.';
    }
    if (!is_numeric($formData['price']) || (float)$formData['price'] < 0) {
        $errors[] = 'Please enter a valid price.';
    }
    if (!ctype_digit((string) $formData['stock_quantity']) || (int)$formData['stock_quantity'] < 0) {
        $errors[] = 'Stock quantity must be a valid number.';
    }
    if (!isset($categories[$formData['category']])) {
        $errors[] = 'Please choose a valid category.';
    }
    if (!in_array($formData['status'], array_keys($statuses), true)) {
        $formData['status'] = 'active';
    }

    if (empty($errors)) {
        $productsFile = __DIR__ . '/../../data/products.json';
        $products = [];
        if (file_exists($productsFile)) {
            $decoded = json_decode((string) file_get_contents($productsFile), true);
            if (is_array($decoded)) {
                $products = $decoded;
            }
        }

        $nextId = 1;
        $existingSlugs = [];
        foreach ($products as $item) {
            $existingSlugs[] = $item['slug'] ?? '';
            if (isset($item['id']) && is_numeric($item['id'])) {
                $nextId = max($nextId, (int) $item['id'] + 1);
            }
        }

        $slug = slugify($formData['name']);
        $baseSlug = $slug;
        $suffix = 1;
        while (in_array($slug, $existingSlugs, true)) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        $newProduct = [
            'id' => $nextId,
            'name' => $formData['name'],
            'slug' => $slug,
            'description' => $formData['description'],
            'price' => (float) $formData['price'],
            'stock_quantity' => (int) $formData['stock_quantity'],
            'category' => $formData['category'],
            'image_url' => $formData['image_url'] !== '' ? $formData['image_url'] : 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=400&h=400&fit=crop&crop=center',
            'featured' => (int) $formData['featured'],
            'rating' => 0,
            'status' => $formData['status'],
        ];

        $products[] = $newProduct;
        $saved = @file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        if ($saved === false) {
            $flash = 'Unable to save the product. Check file permissions for the data folder.';
            $flashType = 'error';
        } else {
            $flash = 'New product added successfully.';
            $flashType = 'success';
            $formData = [
                'name' => '',
                'description' => '',
                'price' => '',
                'stock_quantity' => '',
                'category' => 'atelier-electronics',
                'image_url' => '',
                'featured' => '0',
                'status' => 'active',
            ];
        }
    } else {
        $flash = implode(' ', $errors);
        $flashType = 'error';
    }
}
?>

<style>
    body { font-family: 'Manrope', sans-serif; }
    .font-editorial { font-family: 'Epilogue', sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>

<div class="bg-background text-on-background min-h-screen">
  <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 flex flex-col p-4 z-50">
    <div class="mb-10 px-2">
      <h1 class="text-teal-900 font-black tracking-tighter text-2xl">Mpemba Heritage</h1>
      <p class="font-['Epilogue'] tracking-tight font-bold text-sm text-slate-500">Digital Atelier Console</p>
    </div>
    <nav class="flex-1 space-y-1">
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/index"><span class="material-symbols-outlined">dashboard</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Dashboard</span></a>
      <a class="flex items-center gap-3 px-4 py-3 bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/inventory"><span class="material-symbols-outlined">inventory_2</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Inventory</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/add-product"><span class="material-symbols-outlined">add</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Add Product</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/orders"><span class="material-symbols-outlined">shopping_cart</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/customers"><span class="material-symbols-outlined">group</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Users</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/reports"><span class="material-symbols-outlined">analytics</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Analytics</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/settings"><span class="material-symbols-outlined">settings</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Settings</span></a>
    </nav>
    <div class="mt-auto space-y-2">
      <a class="group w-full bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary py-3.5 px-4 rounded-xl font-black tracking-wide uppercase text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/25 border border-primary/20 hover:scale-[1.03] hover:shadow-xl hover:shadow-primary/35 transition-all duration-300" href="/admin/reports"><span class="material-symbols-outlined text-base group-hover:rotate-90 transition-transform duration-300">add</span>NEW REPORT<span class="text-[9px] px-1.5 py-0.5 rounded-full bg-white/20 border border-white/30">AI</span></a>
      <a class="w-full bg-surface-container-high text-primary py-2.5 px-4 rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-colors" href="/admin/logout"><span class="material-symbols-outlined text-sm">logout</span>Logout</a>
    </div>
  </aside>

  <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input class="w-full bg-surface-container-high border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-0" placeholder="Search inventory or products..." type="text"/>
      </div>
    </div>
    <div class="flex items-center gap-6">
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">notifications</span></button>
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">help_outline</span></button>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <div class="text-right">
          <p class="text-sm font-bold text-primary leading-tight"><?php echo htmlspecialchars($adminName); ?></p>
          <p class="text-[10px] text-slate-500 uppercase tracking-tighter">Inventory Curator</p>
        </div>
        <img alt="Administrator Profile" class="w-9 h-9 rounded-full bg-slate-200 object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
      </div>
    </div>
  </header>

  <main class="ml-64 pt-24 pb-12 px-10 min-h-screen">
    <div class="max-w-5xl mx-auto space-y-8">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div class="max-w-2xl">
          <h2 class="text-5xl font-editorial font-black text-primary tracking-tight leading-none mb-4">Add New Product</h2>
          <p class="text-on-surface-variant text-lg max-w-xl leading-relaxed">Create a new inventory item and publish it instantly to the product catalog.</p>
        </div>
        <div class="flex gap-3">
          <a href="/admin/inventory" class="inline-flex items-center gap-2 px-5 py-3 bg-surface-container-high text-primary rounded-xl font-bold hover:bg-surface-container-highest transition-colors"><span class="material-symbols-outlined">arrow_back</span>Back to Inventory</a>
        </div>
      </div>

      <?php if ($flash !== ''): ?>
        <div class="rounded-2xl px-5 py-4 text-sm font-semibold <?php echo $flashType === 'error' ? 'bg-error-container text-on-error-container border border-error/20' : 'bg-teal-50 text-teal-700 border border-teal-200'; ?>">
          <?php echo htmlspecialchars($flash); ?>
        </div>
      <?php endif; ?>

      <form method="post" action="/admin/add-product" class="grid gap-6 lg:grid-cols-2">
        <section class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/15">
          <div class="grid gap-6 lg:grid-cols-2">
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Product Name</span>
              <input name="name" value="<?php echo htmlspecialchars($formData['name']); ?>" class="mt-2 w-full rounded-3xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="text" required />
            </label>
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Category</span>
              <select name="category" class="mt-2 w-full rounded-3xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                <?php foreach ($categories as $key => $label): ?>
                  <option value="<?php echo htmlspecialchars($key); ?>" <?php echo $formData['category'] === $key ? 'selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                <?php endforeach; ?>
              </select>
            </label>
          </div>

          <div class="grid gap-6 lg:grid-cols-2">
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Price (USD)</span>
              <input name="price" value="<?php echo htmlspecialchars($formData['price']); ?>" class="mt-2 w-full rounded-3xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="number" step="0.01" min="0" required />
            </label>
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Stock Quantity</span>
              <input name="stock_quantity" value="<?php echo htmlspecialchars($formData['stock_quantity']); ?>" class="mt-2 w-full rounded-3xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="number" min="0" required />
            </label>
          </div>

          <label class="block">
            <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Image URL</span>
            <input name="image_url" value="<?php echo htmlspecialchars($formData['image_url']); ?>" class="mt-2 w-full rounded-3xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="url" placeholder="https://example.com/image.jpg" />
          </label>

          <label class="block lg:col-span-2">
            <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Description</span>
            <textarea name="description" rows="5" class="mt-2 w-full rounded-3xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20"><?php echo htmlspecialchars($formData['description']); ?></textarea>
          </label>

          <div class="grid gap-6 lg:grid-cols-3">
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Featured</span>
              <select name="featured" class="mt-2 w-full rounded-3xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                <?php foreach ($featuredOptions as $value => $label): ?>
                  <option value="<?php echo htmlspecialchars($value); ?>" <?php echo $formData['featured'] === $value ? 'selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Status</span>
              <select name="status" class="mt-2 w-full rounded-3xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                <?php foreach ($statuses as $value => $label): ?>
                  <option value="<?php echo htmlspecialchars($value); ?>" <?php echo $formData['status'] === $value ? 'selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <div class="flex items-end">
              <button type="submit" class="w-full rounded-3xl bg-primary py-4 text-sm font-bold text-white shadow-lg shadow-primary/20 hover:bg-primary/90 transition">Save Product</button>
            </div>
          </div>
        </section>
      </form>
    </div>
  </main>
</div>
