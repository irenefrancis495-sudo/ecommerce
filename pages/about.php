<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include __DIR__ . '/../components/ui/navbar.php'; ?>
    <main class="mt-24 max-w-6xl mx-auto px-6 py-12">
        <section class="rounded-3xl bg-white p-10 shadow-lg">
            <div class="grid gap-10 lg:grid-cols-[1fr_0.9fr] lg:items-center">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-700 mb-3">About Mpemba</p>
                    <h1 class="text-4xl font-extrabold text-slate-900 mb-5">Your trusted Tanzanian marketplace for everyday essentials.</h1>
                    <p class="text-lg leading-8 text-slate-600">Mpemba Marketplace brings local sellers and shoppers together in a modern online storefront. We make browsing, ordering, and tracking products simple from the first click to delivery.</p>
                </div>
                <div class="rounded-[32px] bg-slate-50 p-8 ring-1 ring-slate-200">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4">Our mission</h2>
                    <p class="text-slate-600 leading-7 mb-4">We exist to support small businesses and make quality products accessible nationwide. Every product page is designed for clear details, dependable pricing, and an easy shopping experience.</p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <h3 class="font-semibold text-slate-900">Local vendors</h3>
                            <p class="mt-2 text-slate-600">Discover trusted sellers and authentic products from across Tanzania.</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <h3 class="font-semibold text-slate-900">Fast checkout</h3>
                            <p class="mt-2 text-slate-600">Add items to cart, choose payment, and complete orders without friction.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-10 grid gap-6 md:grid-cols-3">
            <div class="rounded-3xl bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Customer focus</h3>
                <p class="text-slate-600">We build every page around the shopper’s journey, from product discovery to order updates.</p>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Secure experience</h3>
                <p class="text-slate-600">Your account and checkout details are handled securely with trusted validation.</p>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Future-ready</h3>
                <p class="text-slate-600">Built for growth, Mpemba is ready to expand with more categories, offers, and customer features.</p>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../components/ui/footer.php'; ?>
</body>
</html>
