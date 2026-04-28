<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart - Mpemba Marketplace</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main class="max-w-5xl mx-auto px-6 py-10">
        <section class="bg-white rounded-3xl shadow-sm p-8">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-6">Your Cart</h1>
            <div id="cart-list" class="space-y-4 text-slate-700">
                <p>Loading cart...</p>
            </div>
            <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <a href="/products" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-6 py-3 text-slate-700 hover:bg-slate-100">Continue shopping</a>
                <a href="/order-status" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-white hover:bg-blue-700">Checkout</a>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
    <script>
        function renderCart() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const cartList = document.getElementById('cart-list');
            if (!cart.length) {
                cartList.innerHTML = '<p>Your cart is empty.</p>';
                return;
            }

            let total = 0;
            let html = '<div class="overflow-x-auto rounded-3xl border border-slate-200"><table class="min-w-full text-left text-sm text-slate-700"><thead class="bg-slate-100"><tr><th class="px-4 py-3">Product</th><th class="px-4 py-3">Qty</th><th class="px-4 py-3">Price</th><th class="px-4 py-3">Subtotal</th></tr></thead><tbody>';
            cart.forEach(item => {
                const subtotal = item.price * item.qty;
                total += subtotal;
                html += `<tr class="border-t border-slate-200"><td class="px-4 py-3">${item.name}</td><td class="px-4 py-3">${item.qty}</td><td class="px-4 py-3">Tsh ${item.price.toLocaleString()}</td><td class="px-4 py-3">Tsh ${subtotal.toLocaleString()}</td></tr>`;
            });
            html += `</tbody></table></div>`;
            html += `<div class="mt-6 rounded-3xl bg-slate-100 p-5 text-right text-lg font-semibold">Total: Tsh ${total.toLocaleString()}</div>`;
            cartList.innerHTML = html;
        }
        document.addEventListener('DOMContentLoaded', renderCart);
    </script>
</body>
</html>
