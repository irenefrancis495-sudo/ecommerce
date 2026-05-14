<?php require_once __DIR__ . '/../config/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Mpemba Marketplace | Shopping Cart</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;900&amp;family=Manrope:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary": "#ffffff",
                        "surface": "#f8f9fb",
                        "primary": "#003345",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed-dim": "#ffb77d",
                        "inverse-on-surface": "#f0f1f3",
                        "secondary-fixed": "#ffdcc3",
                        "surface-container-high": "#e7e8ea",
                        "primary-fixed-dim": "#96ceeb",
                        "on-tertiary-fixed-variant": "#544600",
                        "on-secondary-container": "#713b00",
                        "surface-container-highest": "#e1e2e5",
                        "tertiary": "#705d00",
                        "on-error-container": "#93000a",
                        "on-secondary-fixed": "#2f1500",
                        "surface-container": "#edeef0",
                        "on-surface": "#191c1e",
                        "on-primary-fixed": "#001f2b",
                        "outline": "#71787d",
                        "on-error": "#ffffff",
                        "outline-variant": "#c0c7cd",
                        "on-primary-fixed-variant": "#044d65",
                        "surface-variant": "#e1e2e5",
                        "on-tertiary-container": "#4c3f00",
                        "on-primary": "#ffffff",
                        "tertiary-fixed": "#ffe16d",
                        "primary-fixed": "#bfe8ff",
                        "on-surface-variant": "#40484c",
                        "secondary": "#904d00",
                        "secondary-container": "#ffa454",
                        "primary-container": "#004b63",
                        "on-secondary-fixed-variant": "#6e3900",
                        "on-primary-container": "#83bad6",
                        "error": "#ba1a1a",
                        "tertiary-fixed-dim": "#e9c400",
                        "surface-container-low": "#f2f4f6",
                        "on-background": "#191c1e",
                        "inverse-primary": "#96ceeb",
                        "background": "#f8f9fb",
                        "surface-dim": "#d9dadc",
                        "error-container": "#ffdad6",
                        "inverse-surface": "#2e3133",
                        "surface-bright": "#f8f9fb",
                        "on-tertiary-fixed": "#221b00",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-container": "#c9a900",
                        "surface-tint": "#2a657e"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Epilogue"],
                        "display": ["Epilogue"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface">
<?php include __DIR__ . '/../components/ui/navbar.php'; ?>
<main class="pt-32 pb-20 px-6 md:px-12 max-w-7xl mx-auto min-h-screen">
<div class="mb-12">
<h1 class="font-display text-4xl font-black tracking-tighter text-primary mb-2">Your Atelier Selection</h1>
<p class="font-body text-on-surface-variant">Review your curated artisan pieces before proceeding to checkout.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
    <div class="lg:col-span-2 space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <h2 class="font-display text-3xl font-black text-primary mb-2">Your Cart</h2>
            <p class="text-slate-600">Items you added to your cart are shown below. Update quantities or remove items before checkout.</p>
        </div>

        <?php
        if (session_status() === PHP_SESSION_NONE) session_start();
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            ?>
            <div class="rounded-3xl bg-white p-8 text-center text-slate-500">
                <p class="text-xl font-semibold text-slate-900">Your cart is currently empty.</p>
                <p class="mt-3">Browse our catalog and start adding items to your cart.</p>
                <a href="/products" class="inline-flex mt-5 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white hover:bg-primary/90 transition">Shop products</a>
            </div>
            <?php
        } else {
            foreach ($cart as $item) {
                $lineTotal = number_format($item['price'] * $item['qty'], 2);
                ?>
                <div class="rounded-3xl bg-white p-6 shadow-sm flex items-center gap-6">
                    <img src="<?= htmlspecialchars($item['image'] ?? '/assets/placeholder.png') ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-24 h-24 object-cover rounded-md">
                    <div class="flex-1">
                        <h3 class="font-display text-lg font-bold text-primary"><?= htmlspecialchars($item['name']) ?></h3>
                        <p class="text-sm text-on-surface-variant">Unit: $<?= number_format($item['price'], 2) ?></p>
                        <form method="post" action="/pages/cart_update.php" class="mt-3 flex items-center gap-3">
                            <input type="hidden" name="product_id" value="<?= (int) $item['id'] ?>" />
                            <input type="number" name="qty" value="<?= (int) $item['qty'] ?>" min="0" class="w-20 rounded-md border px-2 py-1" />
                            <button type="submit" class="px-3 py-1 bg-primary text-white rounded-md">Update</button>
                        </form>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-on-surface-variant">Line total</p>
                        <p class="font-bold text-primary text-lg">$<?= $lineTotal ?></p>
                        <form method="post" action="/pages/cart_remove.php" class="mt-2">
                            <input type="hidden" name="product_id" value="<?= (int) $item['id'] ?>" />
                            <button type="submit" class="text-sm text-red-600">Remove</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <aside class="space-y-6">
        <div class="p-8 bg-surface-container rounded-xl shadow-[0_32px_64px_-15px_rgba(25,28,30,0.04)] sticky top-32">
            <h2 class="font-headline text-2xl font-black text-primary mb-6 tracking-tighter">Order Summary</h2>
            <?php
            // compute summary from session cart
            $cart = $_SESSION['cart'] ?? [];
            $subtotal = 0.0;
            $itemCount = 0;
            foreach ($cart as $ci) {
                $subtotal += ($ci['price'] ?? 0) * ($ci['qty'] ?? 1);
                $itemCount += ($ci['qty'] ?? 1);
            }
            $shipping = $subtotal > 0 ? 24.00 : 0.00;
            $tax = round($subtotal * 0.07, 2);
            $total = round($subtotal + $shipping + $tax, 2);
            ?>
            <div class="space-y-4 mb-6">
                <div class="flex justify-between font-label text-on-surface-variant">
                    <span>Subtotal</span>
                    <span class="text-primary font-semibold">$<?= number_format($subtotal, 2) ?></span>
                </div>
                <div class="flex justify-between font-label text-on-surface-variant">
                    <span>Shipping</span>
                    <span class="text-primary font-semibold">$<?= number_format($shipping, 2) ?></span>
                </div>
                <div class="flex justify-between font-label text-on-surface-variant">
                    <span>Taxes</span>
                    <span class="text-primary font-semibold">$<?= number_format($tax, 2) ?></span>
                </div>
                <div class="pt-4 border-t border-outline-variant/20 flex justify-between font-headline text-xl font-bold text-primary">
                    <span>Total</span>
                    <span>$<?= number_format($total, 2) ?></span>
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <input class="w-full bg-surface-container-high border-none rounded-lg px-4 py-3 font-label text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="Promo Code" type="text" />
                    <button class="absolute right-2 top-2 px-3 py-1 bg-primary text-on-primary rounded-md text-xs font-bold font-headline uppercase tracking-widest hover:bg-primary-container transition-colors">Apply</button>
                </div>
                <?php if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>
                    <form method="post" action="/pages/checkout_process.php">
                        <button type="submit" class="w-full bg-gradient-to-r from-secondary to-secondary-container text-on-secondary font-headline font-bold py-4 rounded-lg text-base tracking-tight shadow-lg shadow-secondary/20 hover:scale-[1.02] active:scale-95 transition-all duration-300">Proceed to Checkout</button>
                    </form>
                <?php else: ?>
                    <a href="/login?next=%2Fpayment-methods" class="w-full inline-flex justify-center bg-gradient-to-r from-secondary to-secondary-container text-on-secondary font-headline font-bold py-4 rounded-lg text-base tracking-tight shadow-lg shadow-secondary/20 hover:scale-[1.02] active:scale-95 transition-all duration-300">Login to Checkout</a>
                <?php endif; ?>
                <p class="text-center font-label text-[10px] text-on-surface-variant/60 pt-4">FREE SHIPPING ON ORDERS OVER $2,000</p>
            </div>
        </div>

        <div class="p-6 bg-primary-container/10 rounded-xl flex items-start gap-4">
            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            <div>
                <h4 class="font-headline text-sm font-bold text-primary">Secure Transaction</h4>
                <p class="font-label text-xs text-on-primary-fixed-variant leading-relaxed">Your data is encrypted with enterprise-grade SSL certificates for your safety.</p>
            </div>
        </div>
    </aside>
</div>
</main>
<?php include __DIR__ . '/../components/ui/footer.php'; ?>
<script src="assets/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/js/app.js"></script>
<script>
    async function updateCheckoutButton() {
        const button = document.getElementById('checkout-button');
        if (!button) return;

        const cart = getCart();
        const hasItems = cart.length > 0;
        const defaultText = 'Proceed to Checkout';

        if (!hasItems) {
            button.textContent = defaultText;
            button.disabled = true;
            button.onclick = null;
            return;
        }

        try {
            const response = await fetch('/api/auth.php?action=check');
            const result = await response.json();
            const loggedIn = result.success && result.user;

            if (loggedIn) {
                button.textContent = defaultText;
                button.disabled = false;
                button.onclick = function () {
                    window.location.href = '/payment-methods';
                };
            } else {
                button.textContent = 'Login to Checkout';
                button.disabled = false;
                button.onclick = function () {
                    window.location.href = '/login?next=%2Fpayment-methods';
                };
            }
        } catch (error) {
            button.textContent = 'Login to Checkout';
            button.disabled = false;
            button.onclick = function () {
                window.location.href = '/login?next=%2Fpayment-methods';
            };
        }
    }

    // Initialize cart display when page loads
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof renderCart === 'function') {
            renderCart();
        }
        if (typeof updateCartCount === 'function') {
            updateCartCount();
        }
        if (typeof updateCheckoutButton === 'function') {
            updateCheckoutButton();
        }
    });
</script>
</body></html>
