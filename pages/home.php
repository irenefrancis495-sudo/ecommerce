<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include 'partials/header.php'; ?>
    <main class="max-w-6xl mx-auto px-6 py-10">
        <section class="rounded-3xl bg-white shadow-lg p-10 mb-10">
            <div class="grid gap-8 lg:grid-cols-2 items-center">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-700 mb-3">Mpemba Marketplace</p>
                    <h1 class="text-5xl font-extrabold leading-tight mb-6">Discover premium products and checkout with confidence.</h1>
                    <p class="text-slate-600 text-lg mb-8">From trending merchandise to reliable delivery, our storefront makes shopping fast, secure, and easy for every customer.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="/products" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700">Browse Products</a>
                        <a href="/cart" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-6 py-3 text-slate-700 hover:bg-slate-100">View Cart</a>
                    </div>
                </div>
                <div class="space-y-6">
                    <article class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                        <h2 class="text-xl font-bold mb-3">Easy orders</h2>
                        <p class="text-slate-600">Add items to your cart, complete checkout, and track orders from one dashboard.</p>
                    </article>
                    <article class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                        <h2 class="text-xl font-bold mb-3">Secure payment</h2>
                        <p class="text-slate-600">Choose your payment method and pay with confidence using our secure flow.</p>
                    </article>
                </div>
            </div>
        </section>
        <section class="grid gap-6 md:grid-cols-3">
            <div class="rounded-3xl bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Browse Collections</h3>
                <p class="text-slate-600">Explore product categories and discover what fits your needs.</p>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Track Orders</h3>
                <p class="text-slate-600">Check your order status and delivery updates in real time.</p>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Manage Payments</h3>
                <p class="text-slate-600">Save cards and mobile money options for faster checkout.</p>
            </div>
        </section>
    </main>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
