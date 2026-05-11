<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Heritage Fashion | Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;600;700;800;900&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
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
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    fontFamily: {
                        headline: ["Epilogue"],
                        display: ["Epilogue"],
                        body: ["Manrope"],
                        label: ["Manrope"]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Manrope', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Epilogue', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-secondary-container">
    <?php include __DIR__ . '/../components/ui/navbar.php'; ?>
    <main class="pt-24 min-h-screen">
        <section class="max-w-7xl mx-auto px-8 py-12 md:py-20 flex flex-col md:flex-row items-end justify-between gap-8">
            <div class="max-w-2xl">
                <span class="text-secondary font-semibold tracking-widest uppercase text-sm mb-4 block">Collection 2026</span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-primary tracking-tighter leading-none mb-6">Heritage Fashion</h1>
                <p class="text-on-surface-variant text-lg max-w-md leading-relaxed">A curated dialogue between ancestral craftsmanship and contemporary silhouettes. Discover artisan-made garments that honor tradition through sustainable textiles and modern African aesthetics.</p>
            </div>
            <div class="flex gap-4">
                <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-outline-variant p-1">
                    <img alt="Heritage textile" class="w-full h-full object-cover rounded-full" src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=500&q=80" />
                </div>
                <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-outline-variant p-1 translate-y-8">
                    <img alt="Indigo fabric" class="w-full h-full object-cover rounded-full" src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=500&q=80" />
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-8 sticky top-20 z-40 mb-6">
            <div class="bg-surface-container-low/90 backdrop-blur-md rounded-xl p-4 flex flex-wrap items-center gap-8 shadow-sm">
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Collection</label>
                    <select id="heritage-collection-select" class="bg-transparent border-none text-primary font-bold text-sm focus:ring-0 cursor-pointer p-0">
                        <option>All Collections</option>
                        <option>The Sahel Echo</option>
                        <option>Savanna Bloom</option>
                        <option>Coastal Loom</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Material</label>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-xs font-semibold cursor-pointer" data-material-pill="all">All</span>
                        <span class="px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-xs font-semibold hover:bg-surface-variant cursor-pointer transition-colors" data-material-pill="Organic Cotton">Organic Cotton</span>
                        <span class="px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-xs font-semibold hover:bg-surface-variant cursor-pointer transition-colors" data-material-pill="Artisan Silk">Artisan Silk</span>
                        <span class="px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-xs font-semibold hover:bg-surface-variant cursor-pointer transition-colors" data-material-pill="Hemp Fiber">Hemp Fiber</span>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Size</label>
                    <div class="flex gap-1">
                        <button class="w-8 h-8 rounded-lg text-xs font-bold bg-surface-container-highest text-on-surface-variant hover:bg-primary hover:text-white transition-all">S</button>
                        <button class="w-8 h-8 rounded-lg text-xs font-bold bg-primary text-white">M</button>
                        <button class="w-8 h-8 rounded-lg text-xs font-bold bg-surface-container-highest text-on-surface-variant hover:bg-primary hover:text-white transition-all">L</button>
                        <button class="w-8 h-8 rounded-lg text-xs font-bold bg-surface-container-highest text-on-surface-variant hover:bg-primary hover:text-white transition-all">XL</button>
                    </div>
                </div>
                <div class="flex flex-col gap-1 flex-grow max-w-xs">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Search</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span>
                        <input type="search" data-search-target="cards" placeholder="Search pieces..." class="w-full pl-10 pr-4 py-1.5 bg-surface-container-high border-none rounded-xl text-sm focus:ring-2 focus:ring-primary transition-all" />
                    </div>
                </div>
                <div class="ml-auto flex items-center gap-4">
                    <span id="heritage-count-label" class="text-sm text-on-surface-variant font-medium">Showing 6 Artifacts</span>
                    <button id="heritage-advanced-filters-btn" class="bg-primary text-white px-6 py-2 rounded-lg flex items-center gap-2 hover:scale-102 transition-transform shadow-md">
                        <span class="material-symbols-outlined text-sm">tune</span>
                        <span class="text-sm font-bold">Advanced Filters</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Product Grid - 3 items per row with enhanced styling -->
        <section class="max-w-7xl mx-auto px-8 py-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Product 1: Saharan Nomad Robe -->
            <div class="group bg-white rounded-2xl border border-outline-variant/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-collection="The Sahel Echo" data-material="Organic Cotton">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/10 via-white to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="The Saharan Nomad Robe"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Artisan Wear</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Saharan Nomad Robe</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Hand-woven organic cotton with artisanal indigo vat-dyeing process.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline-variant/20">
                        <span class="text-xl font-bold text-primary">$420</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="401" data-name="The Saharan Nomad Robe" data-price="420" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 2: Veldt Tailored Vest -->
            <div class="group bg-white rounded-2xl border border-outline-variant/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-collection="Savanna Bloom" data-material="Artisan Silk">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/10 via-white to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1495020689067-958852a7765e?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Veldt Tailored Vest"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Vest</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Veldt Tailored Vest</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Sustainable linen vest with precision tailoring and comfort fit.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline-variant/20">
                        <span class="text-xl font-bold text-primary">$185</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="402" data-name="Veldt Tailored Vest" data-price="185" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 3: Bogolan Wrap Skirt -->
            <div class="group bg-white rounded-2xl border border-outline-variant/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-collection="Coastal Loom" data-material="Organic Cotton">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/10 via-white to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Bogolan Wrap Skirt"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Skirt</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Bogolan Wrap Skirt</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Traditional mudcloth with authentic African patterns and wrap design.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline-variant/20">
                        <span class="text-xl font-bold text-primary">$210</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="403" data-name="Bogolan Wrap Skirt" data-price="210" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 4: Midnight Silk Gown -->
            <div class="group bg-white rounded-2xl border border-outline-variant/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-collection="The Sahel Echo" data-material="Artisan Silk">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/10 via-white to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Midnight Silk Gown"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Gown</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Midnight Silk Gown</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Elegant agbada-inspired drape in premium silk with luxurious finish.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline-variant/20">
                        <span class="text-xl font-bold text-primary">$540</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="404" data-name="Midnight Silk Gown" data-price="540" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 5: Kwara Bead Sandals -->
            <div class="group bg-white rounded-2xl border border-outline-variant/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-collection="Savanna Bloom" data-material="Hemp Fiber">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/10 via-white to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Kwara Bead Sandals"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Sandals</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Kwara Bead Sandals</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Hand-stitched leather sandals with traditional beadwork detail.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline-variant/20">
                        <span class="text-xl font-bold text-primary">$130</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="405" data-name="Kwara Bead Sandals" data-price="130" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 6: Axum Minimalist Shirt -->
            <div class="group bg-white rounded-2xl border border-outline-variant/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-collection="Coastal Loom" data-material="Organic Cotton">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/10 via-white to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Axum Minimalist Shirt"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Shirt</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Axum Minimalist Shirt</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Mercerized organic cotton with minimalist design and comfort fit.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline-variant/20">
                        <span class="text-xl font-bold text-primary">$160</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="406" data-name="Axum Minimalist Shirt" data-price="160" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-8 mb-20">
            <div class="bg-primary-container rounded-3xl p-12 md:p-20 relative overflow-hidden flex flex-col md:flex-row items-center gap-12">
                <div class="z-10 relative max-w-xl text-left">
                    <h2 class="text-3xl md:text-5xl font-bold text-on-primary-container tracking-tighter mb-6">The Story in Every Stitch</h2>
                    <p class="text-on-primary-container/80 text-lg leading-relaxed mb-8">Our Digital Atelier is more than a store. It is a bridge connecting remote artisan clusters to global connoisseurs. Each piece is shipped with a digital heritage certificate, tracing the material source and the hands that crafted it.</p>
                    <button class="bg-secondary text-white px-8 py-4 rounded-xl font-bold hover:scale-105 transition-transform flex items-center gap-3 shadow-2xl">Explore the Heritage Map <span class="material-symbols-outlined">arrow_forward</span></button>
                </div>
                <div class="z-10 relative flex-grow w-full md:w-auto h-64 md:h-96 rounded-2xl overflow-hidden shadow-2xl rotate-2">
                    <img alt="Artisan weaving" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80" />
                </div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-secondary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../components/ui/footer.php'; ?>
<script src="/js/app.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var productGrid = document.querySelector('section.grid.gap-6');
    var countLabel = document.getElementById('heritage-count-label');
    var activeCollection = 'all';
    var activeMaterial = 'all';
    var activeSize = 'M';

    function getCards() {
        return productGrid ? Array.from(productGrid.querySelectorAll('[data-collection]')) : [];
    }

    function getProductId(card) {
        var btn = card.querySelector('.add-to-cart');
        return btn ? String(btn.dataset.id) : null;
    }

    function getWishlist() { return JSON.parse(localStorage.getItem('wishlist') || '[]'); }
    function setWishlist(l) { localStorage.setItem('wishlist', JSON.stringify(l)); }

    function applyFilters() {
        var cards = getCards();
        var visible = 0;
        cards.forEach(function (card) {
            var col = card.dataset.collection || '';
            var mat = card.dataset.material || '';
            var showCol = activeCollection === 'all' || col === activeCollection;
            var showMat = activeMaterial === 'all' || mat === activeMaterial;
            var show = showCol && showMat;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        if (countLabel) countLabel.textContent = 'Showing ' + visible + ' Artifact' + (visible !== 1 ? 's' : '');
    }

    // --- Collection select ---
    var collectionSelect = document.getElementById('heritage-collection-select');
    if (collectionSelect) {
        collectionSelect.addEventListener('change', function () {
            activeCollection = this.value === 'All Collections' ? 'all' : this.value;
            applyFilters();
        });
    }

    // --- Material pills (with data-material-pill) ---
    var pills = document.querySelectorAll('[data-material-pill]');
    pills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            var mat = this.dataset.materialPill;
            activeMaterial = mat;
            pills.forEach(function (p) {
                p.classList.remove('bg-primary-fixed', 'text-on-primary-fixed');
                p.classList.add('bg-surface-container-highest', 'text-on-surface-variant');
            });
            this.classList.remove('bg-surface-container-highest', 'text-on-surface-variant');
            this.classList.add('bg-primary-fixed', 'text-on-primary-fixed');
            applyFilters();
        });
    });

    // --- Size buttons ---
    var sizeBtns = document.querySelectorAll('.flex.gap-1 button');
    sizeBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            activeSize = this.textContent.trim();
            sizeBtns.forEach(function (b) {
                b.classList.remove('bg-primary', 'text-white');
                b.classList.add('bg-surface-container-highest', 'text-on-surface-variant');
            });
            this.classList.remove('bg-surface-container-highest', 'text-on-surface-variant');
            this.classList.add('bg-primary', 'text-white');
        });
    });

    // --- Favorites ---
    getCards().forEach(function (card) {
        var favBtn = card.querySelector('button:not(.add-to-cart)');
        if (!favBtn) return;
        var icon = favBtn.querySelector('.material-symbols-outlined');
        if (!icon) return;
        var id = getProductId(card);
        var wishlist = getWishlist();
        if (id && wishlist.includes(id)) {
            icon.style.fontVariationSettings = "'FILL' 1";
            icon.classList.add('text-red-500');
            icon.classList.remove('text-primary');
        }
        favBtn.addEventListener('click', function () {
            var list = getWishlist();
            var idx = list.indexOf(id);
            if (idx > -1) {
                list.splice(idx, 1);
                icon.style.fontVariationSettings = "'FILL' 0";
                icon.classList.remove('text-red-500');
                icon.classList.add('text-primary');
            } else {
                if (id) list.push(id);
                icon.style.fontVariationSettings = "'FILL' 1";
                icon.classList.add('text-red-500');
                icon.classList.remove('text-primary');
            }
            setWishlist(list);
        });
    });

    // --- "Explore the Heritage Map" button ---
    var heritageMapBtn = document.querySelector('section.max-w-7xl.mx-auto.px-8.mb-20 button.bg-secondary');
    if (heritageMapBtn) {
        heritageMapBtn.addEventListener('click', function () {
            var target = productGrid ? productGrid.closest('section') : null;
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    // --- Advanced Filters button (reset) ---
    var advBtn = document.getElementById('heritage-advanced-filters-btn');
    if (advBtn) {
        advBtn.addEventListener('click', function () {
            activeCollection = 'all';
            activeMaterial = 'all';
            if (collectionSelect) collectionSelect.value = 'All Collections';
            pills.forEach(function (p, i) {
                p.classList.remove('bg-primary-fixed', 'text-on-primary-fixed');
                p.classList.add('bg-surface-container-highest', 'text-on-surface-variant');
                if (i === 0) {
                    p.classList.remove('bg-surface-container-highest', 'text-on-surface-variant');
                    p.classList.add('bg-primary-fixed', 'text-on-primary-fixed');
                }
            });
            applyFilters();
        });
    }

    applyFilters();
});
</script>
</body>
</html>
