<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Natural Beauty | Mpemba Marketplace</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700;800;900&amp;family=Manrope:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-primary": "#96ceeb",
                        "surface-bright": "#f8f9fb",
                        "primary-fixed-dim": "#96ceeb",
                        "surface": "#f8f9fb",
                        "on-secondary-fixed": "#2f1500",
                        "surface-variant": "#e1e2e5",
                        "outline": "#71787d",
                        "on-tertiary-fixed-variant": "#544600",
                        "surface-container-low": "#f2f4f6",
                        "on-surface": "#191c1e",
                        "on-error": "#ffffff",
                        "surface-container-highest": "#e1e2e5",
                        "on-tertiary-fixed": "#221b00",
                        "secondary-fixed": "#ffdcc3",
                        "on-tertiary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "error": "#ba1a1a",
                        "tertiary-container": "#c9a900",
                        "surface-container-high": "#e7e8ea",
                        "on-secondary-container": "#713b00",
                        "on-primary-fixed-variant": "#044d65",
                        "on-secondary-fixed-variant": "#6e3900",
                        "outline-variant": "#c0c7cd",
                        "secondary-fixed-dim": "#ffb77d",
                        "surface-dim": "#d9dadc",
                        "tertiary-fixed-dim": "#e9c400",
                        "inverse-surface": "#2e3133",
                        "secondary": "#904d00",
                        "on-surface-variant": "#40484c",
                        "background": "#f8f9fb",
                        "primary-fixed": "#bfe8ff",
                        "primary": "#003345",
                        "surface-tint": "#2a657e",
                        "surface-container": "#edeef0",
                        "primary-container": "#004b63",
                        "secondary-container": "#ffa454",
                        "on-error-container": "#93000a",
                        "on-primary-fixed": "#001f2b",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#83bad6",
                        "error-container": "#ffdad6",
                        "on-background": "#191c1e",
                        "tertiary": "#705d00",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed": "#ffe16d",
                        "inverse-on-surface": "#f0f1f3",
                        "on-tertiary-container": "#4c3f00"
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
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-nav {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
<?php include __DIR__ . '/../components/ui/navbar.php'; ?>

<main class="pt-32 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
    <section class="grid gap-10 lg:grid-cols-[1.4fr_0.95fr] items-center mb-16">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full bg-secondary/10 px-4 py-2 text-xs uppercase tracking-[0.35em] font-semibold text-secondary">Natural Beauty</span>
            <h1 class="mt-6 text-5xl md:text-6xl font-black tracking-tight text-slate-950">Clean skincare, botanical wellness, and gentle ritual beauty.</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">Explore a premium collection of organic serums, restorative hair care, and ritual oils designed to restore glow and balance. Each product is crafted with plant-powered actives and modern elegance.</p>
            <div class="mt-10 grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-surface shadow-sm p-5">
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Clean Formulas</p>
                    <p class="mt-3 font-semibold text-slate-900">No parabens, no sulfates</p>
                </div>
                <div class="rounded-3xl bg-surface shadow-sm p-5">
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Locally Sourced</p>
                    <p class="mt-3 font-semibold text-slate-900">Tanzania botanical blends</p>
                </div>
                <div class="rounded-3xl bg-surface shadow-sm p-5">
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Eco Luxury</p>
                    <p class="mt-3 font-semibold text-slate-900">Recyclable glass packaging</p>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-secondary/20 via-white to-transparent shadow-2xl">
            <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=900&h=900&fit=crop&crop=center" alt="Natural beauty products" class="h-[520px] w-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/30 to-transparent"></div>
            <div class="absolute bottom-8 left-8 right-8 rounded-3xl bg-white/90 backdrop-blur px-6 py-5 shadow-lg">
                <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Ritual Oil</p>
                <h2 class="mt-2 text-2xl font-bold text-slate-950">Botanical Glow Elixir</h2>
                <p class="mt-2 text-sm text-slate-600">A lightweight blend that smooths, softens, and adds luminous hydration.</p>
            </div>
        </div>
    </section>

    <section class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-12">
        <div class="flex flex-wrap gap-3">
            <button class="rounded-full border border-slate-200 bg-primary px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary/90 transition">All Products</button>
            <button class="rounded-full border border-slate-200 bg-white px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 transition">Skincare</button>
            <button class="rounded-full border border-slate-200 bg-white px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 transition">Hair Care</button>
            <button class="rounded-full border border-slate-200 bg-white px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 transition">Essential Oils</button>
        </div>
        <div class="flex items-center gap-4">
            <label class="text-sm font-medium text-slate-600">Sort by</label>
            <select class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition">
                <option>Featured</option>
                <option>Best Seller</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
            </select>
        </div>
    </section>

    <!-- Product Grid - 3-4 items per row with enhanced styling -->
    <section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <!-- Product 1: Organic Face Serum -->
        <article class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            <div class="relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-50 aspect-[3/4]">
                <img 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                    src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&h=750&fit=crop&crop=center&q=80" 
                    alt="Organic Face Serum"
                    loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                    <span class="material-symbols-outlined text-slate-700 text-xl">favorite</span>
                </button>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="inline-block rounded-full bg-amber-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-amber-700">Skincare</span>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                        <span class="font-semibold text-slate-700">4.8</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2 line-clamp-2">Organic Face Serum</h3>
                <p class="text-sm text-slate-600 mb-4 flex-grow line-clamp-2">Hydrating serum with aloe vera and hyaluronic acid for radiant, healthy skin.</p>
                <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-200">
                    <span class="text-xl font-bold text-slate-950">$49</span>
                    <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                        data-id="11" data-name="Organic Face Serum" data-price="49" title="Add to cart">
                        <span class="material-symbols-outlined text-lg">add</span>
                    </button>
                </div>
            </div>
        </article>

        <!-- Product 2: Natural Shampoo -->
        <article class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            <div class="relative overflow-hidden bg-gradient-to-br from-cyan-50 to-blue-50 aspect-[3/4]">
                <img 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                    src="https://images.unsplash.com/photo-1585232351009-aa874380f189?w=600&h=750&fit=crop&crop=center&q=80" 
                    alt="Natural Shampoo"
                    loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                    <span class="material-symbols-outlined text-slate-700 text-xl">favorite</span>
                </button>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="inline-block rounded-full bg-cyan-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-cyan-800">Hair Care</span>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                        <span class="font-semibold text-slate-700">4.9</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2 line-clamp-2">Natural Shampoo</h3>
                <p class="text-sm text-slate-600 mb-4 flex-grow line-clamp-2">Organic botanical shampoo with aloe vera and essential oils for healthy hair.</p>
                <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-200">
                    <span class="text-xl font-bold text-slate-950">$19</span>
                    <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                        data-id="12" data-name="Natural Shampoo" data-price="19" title="Add to cart">
                        <span class="material-symbols-outlined text-lg">add</span>
                    </button>
                </div>
            </div>
        </article>

        <!-- Product 3: Moisturizing Cream -->
        <article class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            <div class="relative overflow-hidden bg-gradient-to-br from-emerald-50 to-green-50 aspect-[3/4]">
                <img 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                    src="https://images.unsplash.com/photo-1556228578-0d191d7056ac?w=600&h=750&fit=crop&crop=center&q=80" 
                    alt="Moisturizing Cream"
                    loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                    <span class="material-symbols-outlined text-slate-700 text-xl">favorite</span>
                </button>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-emerald-800">Skincare</span>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                        <span class="font-semibold text-slate-700">4.7</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2 line-clamp-2">Moisturizing Cream</h3>
                <p class="text-sm text-slate-600 mb-4 flex-grow line-clamp-2">Hydrating face cream with shea butter and natural oils for deep nourishment.</p>
                <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-200">
                    <span class="text-xl font-bold text-slate-950">$39</span>
                    <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                        data-id="13" data-name="Moisturizing Cream" data-price="39" title="Add to cart">
                        <span class="material-symbols-outlined text-lg">add</span>
                    </button>
                </div>
            </div>
        </article>

        <!-- Product 4: Essential Oil Blend -->
        <article class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-50 to-violet-50 aspect-[3/4]">
                <img 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                    src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=600&h=750&fit=crop&crop=center&q=80" 
                    alt="Essential Oil Blend"
                    loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                    <span class="material-symbols-outlined text-slate-700 text-xl">favorite</span>
                </button>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="inline-block rounded-full bg-purple-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-purple-800">Essential Oils</span>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                        <span class="font-semibold text-slate-700">4.8</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2 line-clamp-2">Essential Oil Blend</h3>
                <p class="text-sm text-slate-600 mb-4 flex-grow line-clamp-2">Therapeutic essential oil blend with lavender and chamomile for relaxation.</p>
                <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-200">
                    <span class="text-xl font-bold text-slate-950">$24</span>
                    <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                        data-id="14" data-name="Essential Oil Blend" data-price="24" title="Add to cart">
                        <span class="material-symbols-outlined text-lg">add</span>
                    </button>
                </div>
            </div>
        </article>

        <!-- Product 5: Herbal Face Mask -->
        <article class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            <div class="relative overflow-hidden bg-gradient-to-br from-green-50 to-lime-50 aspect-[3/4]">
                <img 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                    src="https://images.unsplash.com/photo-1570194065650-d99fb4bedf0a?w=600&h=750&fit=crop&crop=center&q=80" 
                    alt="Herbal Face Mask"
                    loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                    <span class="material-symbols-outlined text-slate-700 text-xl">favorite</span>
                </button>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="inline-block rounded-full bg-green-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-green-800">Skincare</span>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                        <span class="font-semibold text-slate-700">4.5</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2 line-clamp-2">Herbal Face Mask</h3>
                <p class="text-sm text-slate-600 mb-4 flex-grow line-clamp-2">Clay face mask with herbal extracts for deep cleansing and detoxification.</p>
                <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-200">
                    <span class="text-xl font-bold text-slate-950">$16</span>
                    <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                        data-id="15" data-name="Herbal Face Mask" data-price="16" title="Add to cart">
                        <span class="material-symbols-outlined text-lg">add</span>
                    </button>
                </div>
            </div>
        </article>

        <!-- Product 6: Botanical Hair Oil -->
        <article class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            <div class="relative overflow-hidden bg-gradient-to-br from-orange-50 to-amber-50 aspect-[3/4]">
                <img 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                    src="https://images.unsplash.com/photo-1585232351009-aa874380f189?w=600&h=750&fit=crop&crop=center&q=80" 
                    alt="Botanical Hair Oil"
                    loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                    <span class="material-symbols-outlined text-slate-700 text-xl">favorite</span>
                </button>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="inline-block rounded-full bg-orange-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-orange-800">Hair Care</span>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                        <span class="font-semibold text-slate-700">4.7</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2 line-clamp-2">Botanical Hair Oil</h3>
                <p class="text-sm text-slate-600 mb-4 flex-grow line-clamp-2">Nourishing hair oil blend with argan and jojoba oils for healthy, shiny hair.</p>
                <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-200">
                    <span class="text-xl font-bold text-slate-950">$22</span>
                    <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                        data-id="17" data-name="Botanical Hair Oil" data-price="22" title="Add to cart">
                        <span class="material-symbols-outlined text-lg">add</span>
                    </button>
                </div>
            </div>
        </article>

        <!-- Product 7: Natural Lip Balm -->
        <article class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            <div class="relative overflow-hidden bg-gradient-to-br from-rose-50 to-pink-50 aspect-[3/4]">
                <img 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                    src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&h=750&fit=crop&crop=center&q=80" 
                    alt="Natural Lip Balm"
                    loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                    <span class="material-symbols-outlined text-slate-700 text-xl">favorite</span>
                </button>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="inline-block rounded-full bg-rose-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-rose-800">Lip Care</span>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                        <span class="font-semibold text-slate-700">4.3</span>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2 line-clamp-2">Natural Lip Balm</h3>
                <p class="text-sm text-slate-600 mb-4 flex-grow line-clamp-2">Beeswax lip balm with natural oils for soft, hydrated lips.</p>
                <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-200">
                    <span class="text-xl font-bold text-slate-950">$8</span>
                    <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                        data-id="16" data-name="Natural Lip Balm" data-price="8" title="Add to cart">
                        <span class="material-symbols-outlined text-lg">add</span>
                    </button>
                </div>
            </div>
        </article>
    </section>

    <section class="mt-16 rounded-[2rem] bg-slate-950 px-8 py-12 text-white shadow-2xl">
        <div class="grid gap-8 lg:grid-cols-[1.3fr_0.7fr] items-center">
            <div>
                <p class="text-sm uppercase tracking-[0.4em] text-secondary/80 font-semibold">Natural beauty ritual</p>
                <h2 class="mt-4 text-4xl font-black tracking-tight">Your everyday botanical wellness ritual, simplified.</h2>
                <p class="mt-4 max-w-xl text-slate-300 leading-7">Crafted for gentle self-care, this collection blends modern skincare science with plant-first ingredients for balanced radiance.</p>
            </div>
            <div class="grid gap-4">
                <div class="rounded-3xl bg-white/10 p-5">
                    <h3 class="font-semibold text-white">Herbal extracts</h3>
                    <p class="mt-3 text-sm text-slate-300">Calming aloe, cleansing charcoal and nourishing moringa.</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <h3 class="font-semibold text-white">Sustainable packaging</h3>
                    <p class="mt-3 text-sm text-slate-300">Refill-ready glass jars with recyclable labels.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="assets/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/js/app.js"></script>
