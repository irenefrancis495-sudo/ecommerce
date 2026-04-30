<?php
// Static product details - no backend required
$id = $_GET['id'] ?? 1;

// Mock product data with proper images
$products = [
    1 => [
        'id' => 1, 
        'name' => 'Wireless Headphones', 
        'price' => 129.99, 
        'category' => 'Electronics', 
        'stock' => 50,
        'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=900&h=500&fit=crop&crop=center',
        'description' => 'Premium wireless headphones with active noise cancellation and superior sound quality.'
    ],
    2 => [
        'id' => 2, 
        'name' => 'Heritage Kanga Dress', 
        'price' => 89.99, 
        'category' => 'Fashion', 
        'stock' => 25,
        'image' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=900&h=500&fit=crop&crop=center',
        'description' => 'Traditional African print dress made from sustainable cotton with modern tailoring.'
    ],
    3 => [
        'id' => 3, 
        'name' => 'Ceramic Vase', 
        'price' => 65.00, 
        'category' => 'Home', 
        'stock' => 15,
        'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=900&h=500&fit=crop&crop=center',
        'description' => 'Handcrafted ceramic vase with matte glaze finish, perfect for modern home decor.'
    ],
    11 => [
        'id' => 11,
        'name' => 'Organic Face Serum',
        'price' => 49.99,
        'category' => 'Beauty',
        'stock' => 75,
        'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=900&h=500&fit=crop&crop=center',
        'description' => 'Natural vitamin C face serum with hyaluronic acid for radiant, glowing skin.'
    ],
    12 => [
        'id' => 12,
        'name' => 'Natural Shampoo',
        'price' => 19.99,
        'category' => 'Beauty',
        'stock' => 120,
        'image' => 'https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?w=900&h=500&fit=crop&crop=center',
        'description' => 'Organic shampoo made with natural ingredients, gentle on all hair types.'
    ],
    13 => [
        'id' => 13,
        'name' => 'Moisturizing Cream',
        'price' => 39.99,
        'category' => 'Beauty',
        'stock' => 90,
        'image' => 'https://images.unsplash.com/photo-1556228578-0d191d7056ac?w=900&h=500&fit=crop&crop=center',
        'description' => 'Hydrating cream formulated with natural oils for deep moisture and nourishment.'
    ],
];

$product = $products[$id] ?? null;

if (!$product) {
    http_response_code(404);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Product Not Found</title></head><body><h1>Product not found</h1><p>The requested product does not exist.</p><a href="/products">Back to products</a></body></html>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> | Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main class="max-w-5xl mx-auto px-6 py-10">
        <div class="grid gap-10 lg:grid-cols-[1.2fr,_0.8fr]">
            <section class="rounded-3xl bg-white p-8 shadow-sm">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full rounded-3xl mb-6">
                <h1 class="text-4xl font-extrabold mb-4"><?= htmlspecialchars($product['name']) ?></h1>
                <p class="text-slate-600 mb-6">Category: <?= htmlspecialchars($product['category']) ?> | Stock: <?= (int)$product['stock'] ?></p>
                <div class="flex items-center gap-4 mb-6">
                    <span class="rounded-full bg-green-100 text-green-700 px-4 py-2">Available</span>
                    <span class="text-3xl font-bold">$<?= number_format($product['price'], 2) ?></span>
                </div>
                <p class="text-slate-600 mb-8"><?= htmlspecialchars($product['description']) ?></p>
                <button id="add-to-cart" class="add-to-cart rounded-full bg-blue-600 px-8 py-3 text-white font-semibold hover:bg-blue-700" data-id="<?= $product['id'] ?>" data-name="<?= htmlspecialchars($product['name']) ?>" data-price="<?= $product['price'] ?>" type="button">Add to Cart</button>
            </section>
            <aside class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-3">Product details</h2>
                    <ul class="space-y-2 text-slate-600">
                        <li>Category: <?= htmlspecialchars($product['category']) ?></li>
                        <li>Price: Tsh <?= number_format($product['price'], 2) ?></li>
                        <li>Stock available: <?= (int)$product['stock'] ?></li>
                        <li>Delivery: 1-2 business days</li>
                        <li>Returns: 7-day satisfaction guarantee</li>
                    </ul>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-3">More actions</h2>
                    <a href="/products" class="block rounded-2xl bg-slate-100 px-4 py-3 hover:bg-slate-200">Back to products</a>
                    <a href="/cart" class="block rounded-2xl bg-slate-100 px-4 py-3 hover:bg-slate-200">View cart</a>
                </div>
            </aside>
        </div>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
    <script src="assets/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/js/app.js"></script>
    <script>
        document.getElementById('add-to-cart').addEventListener('click', function () {
            const product = {
                id: <?= json_encode($product['id']) ?>,
                name: <?= json_encode($product['name']) ?>,
                price: <?= json_encode($product['price']) ?>
            };
            addToCart(product);
        });
    </script>
</body>
</html>
