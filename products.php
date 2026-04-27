<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shop - Mpemba Marketplace</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <main>
        <section class="search-filter-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search products...">
                <select name="category">
                    <option value="">Allyuewruwehrhwe Categories</option>
                    <!-- PHP: Loop categories -->
                </select>
                <button type="submit">Search</button>
            </form>
        </section>
        <section class="product-list">
            <!-- PHP: Loop products -->
            <div class="product-card">
                <h3>Product Name</h3>
                <p>$10</p>
                <p>Stock: <span class="stock-indicator in-stock">In Stock</span></p>
                <form method="POST" action="add-to-cart.php">
                    <input type="hidden" name="product_id" value="1">
                    <input type="number" name="quantity" value="1" min="1" max="15">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
            <!-- End loop -->
        </section>
        <a href="cart.php" class="btn">View Cart</a>
    </main>
    <?php include 'partials/footer.php'; ?>
    <script src="js/app.js"></script>
</body>
</html>
