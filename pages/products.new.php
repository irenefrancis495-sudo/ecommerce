<?php
require __DIR__ . '/../config/bootstrap.php';
use Mpemba\Entity\Product;

$products = Product::getProducts();
?>
<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Products | Mpemba Marketplace</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&amp;family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-container-lowest": "#ffffff",
                    "surface-container-low": "#f2f4f6",
                    "on-background": "#191c1e",
                    "surface-dim": "#d9dadc",
                    "on-tertiary-fixed": "#221b00",
                    "tertiary-container": "#c9a900",
                    "secondary-fixed": "#ffdcc3",
                    "on-tertiary-container": "#4c3f00",
                    "secondary-container": "#ffa454",
                    "inverse-primary": "#96ceeb",
                    "on-error": "#ffffff",
                    "primary": "#003345",
                    "surface-bright": "#f8f9fb",
                    "on-secondary": "#ffffff",
                    "on-primary-fixed": "#001f2b",
                    "surface-container-high": "#e7e8ea",
                    "tertiary-fixed": "#ffe16d",
                    "on-error-container": "#93000a",
                    "on-secondary-fixed-variant": "#6e3900",
                    "inverse-on-surface": "#f0f1f3",
                    "outline-variant": "#c0c7cd",
                    "surface": "#f8f9fb",
                    "error": "#ba1a1a",
                    "surface-container": "#edeef0",
                    "inverse-surface": "#2e3133",
                    "background": "#f8f9fb",
                    "outline": "#71787d",
                    "error-container": "#ffdad6",
                    "on-tertiary": "#ffffff",
                    "primary-fixed-dim": "#96ceeb",
                    "primary-fixed": "#bfe8ff",
                    "on-surface-variant": "#40484c",
                    "secondary-fixed-dim": "#ffb77d",
                    "secondary": "#904d00",
                    "primary-container": "#004b63",
                    "on-primary-fixed-variant": "#044d65",
                    "on-secondary-container": "#713b00",
                    "surface-variant": "#e1e2e5",
                    "on-primary": "#ffffff",
                    "surface-container-highest": "#e1e2e5",
                    "surface-tint": "#2a657e",
                    "on-secondary-fixed": "#2f1500",
                    "on-tertiary-fixed-variant": "#544600",
                    "tertiary": "#705d00",
                    "on-primary-container": "#83bad6",
                    "on-surface": "#191c1e",
                    "tertiary-fixed-dim": "#e9c400"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Epilogue"],
                    "body": ["Manrope"],
                    "label": ["Manrope"]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .text- editorial-shadow {
            text-shadow: 0 4px 12px rgba(0, 51, 69, 0.1);
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm dark:shadow-none">
<div class="flex justify-between items-center px-8 py-4 max-w-screen-2xl mx-auto">
<div class="text-2xl font-black text-[#003345] dark:text-white font-['Epilogue'] tracking-tight">Mpemba Marketplace</div>
<div class="hidden md:flex items-center space-x-8">
<a class="text-slate-500 dark:text-slate-400 hover:text-[#003345] dark:hover:text-white transition-colors font-['Epilogue'] tracking-tight" href="#">Shop</a>
<a class="text-slate-500 dark:text-slate-400 hover:text-[#003345] dark:hover:text-white transition-colors font-['Epilogue'] tracking-tight" href="#">Collections</a>
<a class="text-slate-500 dark:text-slate-400 hover:text-[#003345] dark:hover:text-white transition-colors font-['Epilogue'] tracking-tight" href="#">New Arrivals</a>
<a class="text-slate-500 dark:text-slate-400 hover:text-[#003345] dark:hover:text-white transition-colors font-['Epilogue'] tracking-tight" href="#">About</a>
</div>
<div class="flex items-center space-x-6">
<button class="text-[#003345] dark:text-[#bfe8ff] hover:bg-slate-50 dark:hover:bg-slate-800 p-2 rounded-full transition-all scale-102 duration-200 ease-in-out">
<span class="material-symbols-outlined">person</span>
</button>
<button class="text-[#003345] dark:text-white border-b-2 border-[#904d00] pb-1 hover:bg-slate-50 dark:hover:bg-slate-800 p-2 rounded-t-lg transition-all scale-102 duration-200 ease-in-out relative">
<span class="material-symbols-outlined">shopping_cart</span>
<span class="absolute -top-1 -right-1 bg-secondary text-on-secondary text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">3</span>
</button>
</div>
</div>
</nav>
<main class="pt-28 pb-20 px-8 max-w-screen-2xl mx-auto">
    <header class="mb-12">
        <h1 class="font-headline font-black text-5xl md:text-6xl text-primary tracking-tighter mb-2">Browse Products</h1>
        <p class="text-slate-600 max-w-lg">Discover items from all categories. Add products to the cart and continue shopping or checkout anytime.</p>
    </header>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php if (empty($products)): ?>
            <div class="col-span-full rounded-3xl bg-white p-10 shadow-sm text-center text-slate-700">
                <p class="text-lg font-semibold">No products available yet.</p>
                <p class="mt-2 text-sm text-slate-500">Please refresh or check back later.</p>
            </div>
        <?php endif; ?>
        <?php foreach ($products as $product): ?>
            <article class="rounded-3xl bg-white p-6 shadow-sm hover:shadow-lg transition-shadow duration-200">
                <div class="mb-4 h-52 rounded-3xl bg-slate-100 overflow-hidden">
                    <img class="w-full h-full object-cover" src="https://via.placeholder.com/600x400?text=<?= urlencode($product['name']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
                <div class="mb-4">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400"><?= htmlspecialchars($product['category']) ?></p>
                    <h2 class="text-2xl font-bold text-slate-900 mt-2 mb-3"><?= htmlspecialchars($product['name']) ?></h2>
                    <p class="text-slate-600 line-clamp-3"><?= htmlspecialchars($product['description'] ?: 'No description available.') ?></p>
                </div>
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <span class="text-2xl font-extrabold text-slate-900">Tsh <?= number_format($product['price'], 2) ?></span>
                    <div class="flex items-center gap-2">
                        <a href="/product-details?id=<?= urlencode($product['id']) ?>" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Details</a>
                        <button type="button" class="add-to-cart-btn inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700" data-id="<?= htmlspecialchars($product['id']) ?>" data-name="<?= htmlspecialchars($product['name']) ?>" data-price="<?= htmlspecialchars($product['price']) ?>">Add</button>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</main>
<!-- Footer -->
<footer class="w-full py-12 mt-20 bg-[#003345] dark:bg-black text-white font-['Manrope'] text-sm">
<div class="flex flex-col md:flex-row justify-between items-center px-12 max-w-screen-2xl mx-auto gap-8">
<div class="flex flex-col gap-4 items-center md:items-start">
<div class="text-xl font-bold text-white">Mpemba Marketplace</div>
<p class="text-slate-300 opacity-80">© 2024 Mpemba Marketplace. The Digital Atelier.</p>
</div>
<div class="flex gap-8">
<a class="text-slate-300 hover:text-white transition-colors hover:underline opacity-80 hover:opacity-100 transition-opacity" href="#">Privacy Policy</a>
<a class="text-slate-300 hover:text-white transition-colors hover:underline opacity-80 hover:opacity-100 transition-opacity" href="#">Terms of Service</a>
<a class="text-slate-300 hover:text-white transition-colors hover:underline opacity-80 hover:opacity-100 transition-opacity" href="#">Shipping</a>
<a class="text-slate-300 hover:text-white transition-colors hover:underline opacity-80 hover:opacity-100 transition-opacity" href="#">Returns</a>
<a class="text-slate-300 hover:text-white transition-colors hover:underline opacity-80 hover:opacity-100 transition-opacity" href="#">Contact</a>
</div>
<div class="flex gap-6">
<button class="opacity-80 hover:opacity-100 transition-opacity"><span class="material-symbols-outlined">public</span></button>
<button class="opacity-80 hover:opacity-100 transition-opacity"><span class="material-symbols-outlined">mail</span></button>
<button class="opacity-80 hover:opacity-100 transition-opacity"><span class="material-symbols-outlined">share</span></button>
</div>
</div>
</footer>
</body></html>
