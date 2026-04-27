<?php
// Render top-selling electronics as a featured "Alibaba-like" top-sellers strip
if (!function_exists('get_top_selling')) {
    include_once __DIR__ . '/../data/mock_data.php';
}
$top = function_exists('get_top_selling') ? get_top_selling() : [];
if (empty($top)) {
    $top = [
        ["id"=>1, "name"=>"Smartphone X", "price"=>750000, "img"=>"https://via.placeholder.com/300x300?text=Smartphone"],
    ];
}
foreach ($top as $product): ?>
    <div class="product-card top-seller" data-id="<?php echo $product['id'] ?? ''; ?>">
        <div class="top-seller-badge">Top Seller</div>
        <img src="<?php echo $product['img']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
        <p class="price">Tsh <?php echo number_format($product['price'] ?? 0, 0); ?></p>
        <button class="btn-secondary add-to-cart" data-id="<?php echo $product['id'] ?? ''; ?>" data-name="<?php echo htmlspecialchars($product['name']); ?>" data-price="<?php echo $product['price'] ?? 0; ?>">Add to Cart</button>
    </div>
<?php endforeach; ?>
