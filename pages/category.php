<?php
require __DIR__ . '/../config/bootstrap.php';
use Mpemba\Entity\Product;

$products = Product::getProducts();
$categories = [];
foreach ($products as $product) {
    $categories[$product['category']][] = $product;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main class="max-w-6xl mx-auto px-6 py-10">
        <header class="mb-8">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-3">Product Categories</h1>
            <p class="text-slate-600">Browse product groups and jump to the items you need.</p>
        </header>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($categories as $category => $items): ?>
                <article class="rounded-3xl bg-white p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <h2 class="text-2xl font-bold text-slate-900 mb-3"><?= htmlspecialchars($category) ?></h2>
                    <p class="text-slate-600 mb-4"><?= count($items) ?> products</p>
                    <a href="/products" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Browse all</a>
                </article>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
