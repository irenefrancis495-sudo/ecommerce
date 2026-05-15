<?php
require_once __DIR__ . '/../config/bootstrap.php';

use Mpemba\Entity\Product;
use Mpemba\Utils\Utility;

$featuredProducts = [];
try {
    $featuredData = Product::getAllProducts(4);
    $featuredProducts = $featuredData['products'] ?? [];
} catch (\Throwable $e) {
    $featuredProducts = [];
}

if (empty($featuredProducts)) {
    $featuredProducts = [
        [
            'id' => 1,
            'name' => 'Smartphone X',
            'price' => 750000,
            'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300&h=300&fit=crop&crop=center',
            'category_name' => 'Electronics',
        ],
    ];
}
foreach ($featuredProducts as $product): ?>
    <?php $productImage = Utility::getProductImageUrl($product, $product['category_name'] ?? null); ?>
    <div class="product-card top-seller" data-id="<?php echo $product['id'] ?? ''; ?>">
        <div class="top-seller-badge">Top Seller</div>
        <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
        <p class="price">Tsh <?php echo number_format($product['price'] ?? 0, 0); ?></p>
        <button class="btn-secondary add-to-cart" data-id="<?php echo $product['id'] ?? ''; ?>" data-name="<?php echo htmlspecialchars($product['name']); ?>" data-price="<?php echo $product['price'] ?? 0; ?>">Add to Cart</button>
    </div>
<?php endforeach; ?>
