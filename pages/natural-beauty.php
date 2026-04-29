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
<main class="pt-32 pb-20 max-w-7xl mx-auto px-8">
<!-- Hero Header Composition -->
<header class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-20 items-end">
<div class="md:col-span-7">
<p class="font-label text-primary uppercase tracking-[0.3em] text-sm mb-4">The Digital Atelier</p>
<h1 class="font-display text-5xl md:text-7xl font-bold text-primary leading-tight tracking-tighter">Natural <br/><span class="text-secondary italic font-light">Beauty</span></h1>
<p class="mt-6 text-on-surface-variant max-w-lg leading-relaxed text-lg">
                    A curated collection of organic skincare, botanical infusions, and ancestral herbal remedies. Consciously crafted for the modern soul.
                </p>
</div>
<div class="md:col-span-5 hidden md:block">
<div class="aspect-[4/3] rounded-xl overflow-hidden shadow-2xl rotate-2">
<img class="w-full h-full object-cover" data-alt="Close-up of minimalist aesthetic skincare products on a neutral stone background with soft natural morning sunlight and leaf shadows" src="https://lh3.googleusercontent.com/aida-public/AB6AXuANOoHSSSY4zXCTYV_wwjSjDF_xQNZ9vSK33mJEO8mkGWy1suX9-gzjPutgj3JP1hDkhwuk1gMGajMCu1y6N6QNczs6cyBuYOAb8BuXiVUgmif7OQy_GPjLbVxeU3oVQQwUfGHa2Dtc3DpB2XuqItPCq_CcDdPdXVe3LY-MzqmSsaBkp8seFG7o63WgSjS7Euzc1Jgv-60RiMTA4zTP35tDD_05hZiF9EQbiehp0H2ligtCTxQ6QZ2Koqa6wRKbADLugeAjSTHTWVc"/>
</div>
</div>
</header>
<!-- Filters & Sorting Section -->
<section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 py-6 sticky top-20 bg-surface/90 backdrop-blur-md z-40">
<div class="flex flex-wrap gap-3">
<div class="group relative">
<button class="px-6 py-2 rounded-full bg-surface-container-high text-on-surface hover:bg-surface-container-lowest transition-all flex items-center gap-2">
<span>Skin Type</span>
<span class="material-symbols-outlined text-sm">expand_more</span>
</button>
</div>
<div class="group relative">
<button class="px-6 py-2 rounded-full bg-surface-container-high text-on-surface hover:bg-surface-container-lowest transition-all flex items-center gap-2">
<span>Ingredients</span>
<span class="material-symbols-outlined text-sm">expand_more</span>
</button>
</div>
<div class="flex items-center gap-2 px-2">
<div class="w-2 h-2 rounded-full bg-secondary"></div>
<span class="font-label text-sm uppercase tracking-widest text-primary/60">64 Results</span>
</div>
</div>
<div class="flex items-center gap-4 w-full md:w-auto">
<div class="flex-grow md:flex-grow-0 relative">
<input class="w-full md:w-64 bg-surface-container-high border-none rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/10 focus:bg-surface-container-lowest transition-all" placeholder="Search Atelier..." type="text"/>
</div>
<button class="p-2 text-primary hover:bg-primary-fixed rounded-lg transition-colors">
<span class="material-symbols-outlined">tune</span>
</button>
</div>
</section>
<!-- Product Grid: Asymmetric Layout -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-12">
<!-- Product 1: Botanical Oil -->
<article class="group">
<div class="relative overflow-hidden rounded-xl bg-surface-container-lowest aspect-[3/4] mb-6">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A frosted glass bottle of golden botanical oil sitting on a piece of raw cedar wood with dried wildflowers nearby" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjDV-ajlBPebFHy5x3hZgWy7cHarjuTrSQ8POTQkv2PA1AY5FtApjK2KBr5tbsyYKbmJdw6mIySypIWizIl6MOgYMIF3qmTHeuRja-EqrrXdZyslSUQSioicIOEZ6EnZqlrYEDA2D8lvf9KifqKUY_4MooUZ_oppjNXs2atndz8p_Rb5Vft1F3PkdFxXnexb9LiYorN__cc0LHwjNhzF3yiALDw5hzTUhHtFQ3ud1pZnLiYqUxMxylB-pknRMiPxsNQ_7Q70RqhSg"/>
<button class="absolute top-4 right-4 p-2 bg-white/50 backdrop-blur-md rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-primary">favorite</span>
</button>
</div>
<div class="flex justify-between items-start">
<div>
<p class="font-label text-xs text-primary/50 uppercase tracking-widest mb-1">Face &amp; Body</p>
<h3 class="font-display text-xl font-semibold text-primary">Golden Marula Elixir</h3>
<div class="flex items-center gap-1 mt-1 text-tertiary">
<span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="text-xs font-bold">4.9</span>
<span class="text-xs text-on-surface-variant font-normal ml-1">(128 reviews)</span>
</div>
</div>
<p class="font-display text-xl font-bold text-primary">$84</p>
</div>
<button class="mt-6 w-full py-4 rounded-lg bg-primary text-on-primary font-label text-xs uppercase tracking-widest hover:bg-primary-container hover:text-on-primary-container transition-all scale-102 flex justify-center items-center gap-2">
                    Add to Collection
                </button>
</article>
<!-- Product 2: Skincare Cream (Larger focus) -->
<article class="group md:mt-12">
<div class="relative overflow-hidden rounded-xl bg-surface-container-lowest aspect-[3/4] mb-6">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="Texture shot of creamy white facial moisturizer in a white ceramic jar with a silver spatula and fresh sage leaves" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnDQhvC4xVHRMCZxAnmT3Dxvjt5ASIyC-y9g2872CABitqw-k_aK1UwuajYemnXhCxG-csA936qjB99EFVJ2BGEO9QBynaYrkllcOCEyZwsIGcW6gW3OgQ4Wf8Msk6vDVPYdWxZSG64Zyl6WRzMSsRE3X4-IiF42rzvnOdti5GAgET7fMyWsPRw-jJt2fyPDfSKrW46wlcbhXy13oh6bFKIh3nXqQLzEPZIfWTJ3bC7kfeXbuj09lATNfT9O_m4CjhOOw2w21K3Ec"/>
<div class="absolute bottom-4 left-4">
<span class="px-3 py-1 bg-secondary text-on-secondary text-[10px] font-bold uppercase tracking-widest rounded-full">Atelier Choice</span>
</div>
</div>
<div class="flex justify-between items-start">
<div>
<p class="font-label text-xs text-primary/50 uppercase tracking-widest mb-1">Hydration</p>
<h3 class="font-display text-xl font-semibold text-primary">Wild Sage Repair Cream</h3>
<div class="flex items-center gap-1 mt-1 text-tertiary">
<span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="text-xs font-bold">4.8</span>
<span class="text-xs text-on-surface-variant font-normal ml-1">(254 reviews)</span>
</div>
</div>
<p class="font-display text-xl font-bold text-primary">$62</p>
</div>
<button class="mt-6 w-full py-4 rounded-lg bg-primary text-on-primary font-label text-xs uppercase tracking-widest hover:bg-primary-container hover:text-on-primary-container transition-all scale-102 flex justify-center items-center gap-2">
                    Add to Collection
                </button>
</article>
<!-- Product 3: Herbal Remedy -->
<article class="group">
<div class="relative overflow-hidden rounded-xl bg-surface-container-lowest aspect-[3/4] mb-6">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="Handcrafted pottery bowls containing various dried herbs and botanical powders for traditional natural skincare recipes" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDKiw7y-i-WMnTyAE9vVrfQpV8vomGN4h71LBwiR8ux9uaVTM8nC7mbfSSBBgTGwE-n1DA563XqAm1HXd1zwCM472TsOFvS2NhtzSbkDk607A_CcPVdo2L_G3YjRVxRjf-6RQD2sxg8iHc_bV5YoB0SPOxNCuNmeBF6Fn0ICa0BKR16SbW67EPflYS2Iiv3p0wvw5b9veoFCvCsBDdaAojDDy5mHVzAX7TDfTE1VXDc342Rr4lAN4cDHTcZi8PRrDoc9gXl3VeC9dM"/>
</div>
<div class="flex justify-between items-start">
<div>
<p class="font-label text-xs text-primary/50 uppercase tracking-widest mb-1">Remedy</p>
<h3 class="font-display text-xl font-semibold text-primary">Ancient Bark Cleansing Grains</h3>
<div class="flex items-center gap-1 mt-1 text-tertiary">
<span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="text-xs font-bold">5.0</span>
<span class="text-xs text-on-surface-variant font-normal ml-1">(89 reviews)</span>
</div>
</div>
<p class="font-display text-xl font-bold text-primary">$45</p>
</div>
<button class="mt-6 w-full py-4 rounded-lg bg-primary text-on-primary font-label text-xs uppercase tracking-widest hover:bg-primary-container hover:text-on-primary-container transition-all scale-102 flex justify-center items-center gap-2">
                    Add to Collection
                </button>
</article>
<!-- Row 2 -->
<!-- Product 4 -->
<article class="group md:mt-[-3rem]">
<div class="relative overflow-hidden rounded-xl bg-surface-container-lowest aspect-[3/4] mb-6 shadow-xl shadow-primary/5">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A minimalist dark amber bottle with a dropper labeled in elegant serif typography on a marble surface with soft shadows" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhZyMVLZ8NrQeq420GG3OAdn28YABBWp0oNZ6T8iSVhAts54_xYkRCpSKjA_Fu-a97g5Sfj3QaOZSxjR5fXL3WDozDwywPGh0er0C5ekywT00Y6kvPgFk084ohR2xz5GfUt4b0x1MWaqM32FK2J5BbGBnMfGkicmIRNojWnPmW5ctixXswilvWyCDKKDRt-tCHT0pqZRh8iq01EnNKDBV93Jzz_M9i0XPYIOKnqo5ISqIYIQfqVf3hFPKWnC3BOlaU4BN0apB1cKs"/>
</div>
<div class="flex justify-between items-start">
<div>
<p class="font-label text-xs text-primary/50 uppercase tracking-widest mb-1">Serums</p>
<h3 class="font-display text-xl font-semibold text-primary">Vitamin C Glow Serum</h3>
<div class="flex items-center gap-1 mt-1 text-tertiary">
<span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="text-xs font-bold">4.7</span>
</div>
</div>
<p class="font-display text-xl font-bold text-primary">$78</p>
</div>
<button class="mt-6 w-full py-4 rounded-lg bg-primary text-on-primary font-label text-xs uppercase tracking-widest hover:bg-primary-container hover:text-on-primary-container transition-all scale-102 flex justify-center items-center gap-2">
                    Add to Collection
                </button>
</article>
<!-- Featured CTA Bento Slot -->
<div class="md:col-span-2 rounded-xl bg-[#001f2b] p-12 flex flex-col md:flex-row items-center gap-8 text-white overflow-hidden relative">
<div class="relative z-10 md:w-3/5">
<h2 class="font-display text-4xl font-bold leading-tight tracking-tight mb-4 text-primary-fixed">The Skin Ritual Guide</h2>
<p class="text-on-primary-container font-body leading-relaxed mb-8">Not sure where to begin? Our digital atelier experts have crafted personalized rituals based on your skin's heritage and environment.</p>
<button class="px-8 py-3 bg-[#904d00] rounded-lg font-label text-xs uppercase tracking-widest hover:bg-[#ffa454] transition-colors inline-flex items-center gap-3">
                        Take the Quiz
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
</button>
</div>
<div class="md:w-2/5 flex justify-center">
<div class="w-48 h-48 rounded-full border-4 border-primary-container flex items-center justify-center p-4">
<img class="w-full h-full object-cover rounded-full" data-alt="Abstract macro shot of a single water drop hitting a clear surface, creating elegant ripples in shades of deep teal and gold" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBAn_4M7kuWUacI-IDwzSaNMPL-uZ1KoCvF0WIx8WzRyK0tQpu74GE2p9oFZHisvnYLUSw0Mh16tYvPvNrF6j-PxSYgDF34IphFnz-JWSIvFbN_4Gw7PHzgeRyyEKsJCD3FvODN2lanrlYRqXFwVdOU9BGWLTiZZ2pdkcDG5hSE0snQt_FSswtN0ptCnd426NVFKtDev69pBZ1BaEnEtDpYXXyH481TWFy8CsFstvVVci3tiSOov08R6kAJdU8e1xwbq10A7bpSBeY"/>
</div>
</div>
<div class="absolute top-0 right-0 w-64 h-64 bg-primary-container/20 rounded-full blur-3xl -mr-32 -mt-32"></div>
</div>
</div>
<!-- Pagination / Load More -->
<div class="mt-24 flex flex-col items-center gap-8">
<div class="flex gap-4">
<button class="w-12 h-12 rounded-full border border-outline-variant flex items-center justify-center text-primary hover:bg-surface-container-high">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="px-6 h-12 rounded-full bg-primary text-on-primary font-bold">1</button>
<button class="w-12 h-12 rounded-full text-on-surface-variant hover:bg-surface-container-high">2</button>
<button class="w-12 h-12 rounded-full text-on-surface-variant hover:bg-surface-container-high">3</button>
<button class="w-12 h-12 rounded-full border border-outline-variant flex items-center justify-center text-primary hover:bg-surface-container-high">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
<p class="font-label text-xs text-on-surface-variant uppercase tracking-widest">Showing 6 of 64 products</p>
</div>
</main>
<?php include __DIR__ . '/../components/ui/footer.php'; ?>
<!-- FAB for Category Filtering -->
<button class="fixed bottom-8 right-8 w-14 h-14 bg-secondary text-on-secondary rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-transform z-50 md:hidden">
<span class="material-symbols-outlined">filter_list</span>
</button>
</body></html>