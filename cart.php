<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart - Mpemba Marketplace</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <main>
        <section class="cart-section">
            <h2>Your Cart</h2>
            <div class="cart-list" id="cart-list">
                <p>Loading cart...</p
            </div>
        </section>
    </main>
    <?php include 'partials/footer.php'; ?>
    <script src="js/app.js"></script>
    <script>
    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const cartList = document.getElementById('cart-list');
        if (!cart.length) {
            cartList.innerHTML = '<p>Your cart is empty.</p>';
            return;
        }
        let html = '<table style="width:100%;max-width:500px;margin:0 auto;border-collapse:collapse;">';
        html += '<tr style="background:#f4f4f4;"><th style="padding:8px 4px;text-align:left;">Product</th><th style="padding:8px 4px;">Qty</th><th style="padding:8px 4px;">Price</th><th style="padding:8px 4px;">Subtotal</th></tr>';
        let total = 0;
        cart.forEach(item => {
            const subtotal = item.price * item.qty;
            total += subtotal;
            html += `<tr><td style='padding:8px 4px;'>${item.name}</td><td style='padding:8px 4px;text-align:center;'>${item.qty}</td><td style='padding:8px 4px;text-align:right;'>Tsh ${item.price.toLocaleString()}</td><td style='padding:8px 4px;text-align:right;'>Tsh ${(subtotal).toLocaleString()}</td></tr>`;
        });
        html += `<tr style='font-weight:bold;background:#f4f4f4;'><td colspan='3' style='padding:8px 4px;text-align:right;'>Total</td><td style='padding:8px 4px;text-align:right;'>Tsh ${total.toLocaleString()}</td></tr>`;
        html += '</table>';
        cartList.innerHTML = html;
    }
    document.addEventListener('DOMContentLoaded', renderCart);
    </script>
</body>
</html>
