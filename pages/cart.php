<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Mpemba Marketplace | Shopping Cart</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;900&amp;family=Manrope:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
<!-- Left Column: Cart Items -->
<div class="lg:col-span-2 space-y-8">
<div id="cart-empty-message" class="p-8 rounded-3xl bg-white text-center text-on-surface-variant">
Your cart is empty. Add products from the atelier to see them here.
</div>
<div id="cart-items" class="space-y-8"></div>
</div>
<!-- Right Column: Sidebar -->
<aside class="space-y-6">
<div class="p-8 bg-surface-container rounded-xl shadow-[0_32px_64px_-15px_rgba(25,28,30,0.04)] sticky top-32">
<h2 class="font-headline text-2xl font-black text-primary mb-8 tracking-tighter">Order Summary</h2>
<div class="space-y-4 mb-8">
<div class="flex justify-between font-label text-on-surface-variant">
<span>Subtotal</span>
<span id="cart-subtotal" class="text-primary font-semibold">$0.00</span>
</div>
<div class="flex justify-between font-label text-on-surface-variant">
<span>Estimated Shipping</span>
<span class="text-primary font-semibold">$24.00</span>
</div>
<div class="flex justify-between font-label text-on-surface-variant">
<span>Taxes</span>
<span class="text-primary font-semibold">$110.55</span>
</div>
<div class="pt-4 border-t border-outline-variant/20 flex justify-between font-headline text-xl font-bold text-primary">
<span>Total</span>
<span id="cart-total">$0.00</span>
</div>
</div>
<div class="space-y-4">
<div class="relative">
<input class="w-full bg-surface-container-high border-none rounded-lg px-4 py-3 font-label text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="Promo Code" type="text"/>
<button class="absolute right-2 top-2 px-3 py-1 bg-primary text-on-primary rounded-md text-xs font-bold font-headline uppercase tracking-widest hover:bg-primary-container transition-colors">Apply</button>
</div>
<button class="w-full bg-gradient-to-r from-secondary to-secondary-container text-on-secondary font-headline font-bold py-5 rounded-lg text-lg tracking-tight shadow-lg shadow-secondary/20 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                            Proceed to Checkout
                        </button>
<p class="text-center font-label text-[10px] text-on-surface-variant/60 pt-4">
                            FREE SHIPPING ON ORDERS OVER $2,000
                        </p>
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
</body></html>
