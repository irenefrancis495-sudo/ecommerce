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
                    <select class="bg-transparent border-none text-primary font-bold text-sm focus:ring-0 cursor-pointer p-0">
                        <option>All Collections</option>
                        <option>The Sahel Echo</option>
                        <option>Savanna Bloom</option>
                        <option>Coastal Loom</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Material</label>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-xs font-semibold cursor-pointer">Organic Cotton</span>
                        <span class="px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-xs font-semibold hover:bg-surface-variant cursor-pointer transition-colors">Artisan Silk</span>
                        <span class="px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-xs font-semibold hover:bg-surface-variant cursor-pointer transition-colors">Hemp Fiber</span>
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
                <div class="ml-auto flex items-center gap-4">
                    <span class="text-sm text-on-surface-variant font-medium">Showing 24 Artifacts</span>
                    <button class="bg-primary text-white px-6 py-2 rounded-lg flex items-center gap-2 hover:scale-102 transition-transform shadow-md">
                        <span class="material-symbols-outlined text-sm">tune</span>
                        <span class="text-sm font-bold">Advanced Filters</span>
                    </button>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-8 py-16 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="product-card md:col-span-2 md:row-span-2 group" data-id="301" data-name="The Saharan Nomad Robe" data-price="420" data-image="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1400&q=80">
                <div class="relative aspect-[4/5] overflow-hidden rounded-2xl bg-surface-container-low mb-4">
                    <img alt="Editorial look" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1400&q=80" />
                    <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md px-4 py-1 rounded-full text-white text-xs font-bold uppercase tracking-widest">Masterpiece</div>
                    <button class="absolute bottom-6 right-6 w-14 h-14 bg-secondary text-white rounded-full flex items-center justify-center shadow-xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" data-action="add-to-cart">
                        <span class="material-symbols-outlined">add_shopping_cart</span>
                    </button>
                </div>
                <div class="px-2">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="text-2xl font-bold text-primary tracking-tight">The Saharan Nomad Robe</h3>
                        <span class="text-xl font-bold text-primary">$420</span>
                    </div>
                    <p class="text-on-surface-variant text-sm mb-4">Hand-woven organic cotton with artisanal indigo vat-dyeing process.</p>
                    <div class="flex gap-2">
                        <span class="text-[10px] uppercase font-black text-secondary tracking-tighter">Artisan Made</span>
                        <span class="text-[10px] uppercase font-black text-secondary tracking-tighter">•</span>
                        <span class="text-[10px] uppercase font-black text-secondary tracking-tighter">Sustainable</span>
                    </div>
                </div>
            </div>

            <div class="product-card group" data-id="302" data-name="Veldt Tailored Vest" data-price="185" data-image="https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1200&q=80">
                <div class="relative aspect-[3/4] overflow-hidden rounded-2xl bg-surface-container-low mb-4">
                    <img alt="Linen vest" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1200&q=80" />
                    <button class="absolute bottom-4 right-4 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center shadow-lg opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" data-action="add-to-cart">
                        <span class="material-symbols-outlined text-sm">shopping_bag</span>
                    </button>
                </div>
                <div class="px-2">
                    <h3 class="text-lg font-bold text-primary tracking-tight">Veldt Tailored Vest</h3>
                    <div class="flex justify-between items-center">
                        <p class="text-on-surface-variant text-xs">Sustainable Linen</p>
                        <span class="text-md font-bold text-primary">$185</span>
                    </div>
                </div>
            </div>

            <div class="product-card group" data-id="303" data-name="Bogolan Wrap Skirt" data-price="210" data-image="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80">
                <div class="relative aspect-[3/4] overflow-hidden rounded-2xl bg-surface-container-low mb-4">
                    <img alt="Wrap skirt" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80" />
                    <button class="absolute bottom-4 right-4 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center shadow-lg opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" data-action="add-to-cart">
                        <span class="material-symbols-outlined text-sm">shopping_bag</span>
                    </button>
                </div>
                <div class="px-2">
                    <h3 class="text-lg font-bold text-primary tracking-tight">Bogolan Wrap Skirt</h3>
                    <div class="flex justify-between items-center">
                        <p class="text-on-surface-variant text-xs">Traditional Mudcloth</p>
                        <span class="text-md font-bold text-primary">$210</span>
                    </div>
                </div>
            </div>

            <div class="md:row-span-2 group">
                <div class="relative h-full flex flex-col">
                    <div class="flex-grow overflow-hidden rounded-2xl bg-surface-container-low mb-4">
                        <img alt="Silk gown" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80" />
                    </div>
                    <div class="px-2">
                        <h3 class="text-lg font-bold text-primary tracking-tight">Midnight Silk Gown</h3>
                        <div class="flex justify-between items-center">
                            <p class="text-on-surface-variant text-xs">Agbada-inspired Drape</p>
                            <span class="text-md font-bold text-primary">$540</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-card group" data-id="305" data-name="Kwara Bead Sandals" data-price="130" data-image="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80">
                <div class="relative aspect-[3/4] overflow-hidden rounded-2xl bg-surface-container-low mb-4">
                    <img alt="Leather sandals" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80" />
                    <button class="absolute bottom-4 right-4 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center shadow-lg opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" data-action="add-to-cart">
                        <span class="material-symbols-outlined text-sm">shopping_bag</span>
                    </button>
                </div>
                <div class="px-2">
                    <h3 class="text-lg font-bold text-primary tracking-tight">Kwara Bead Sandals</h3>
                    <div class="flex justify-between items-center">
                        <p class="text-on-surface-variant text-xs">Hand-stitched Leather</p>
                        <span class="text-md font-bold text-primary">$130</span>
                    </div>
                </div>
            </div>

            <div class="product-card group" data-id="306" data-name="Axum Minimalist Shirt" data-price="160" data-image="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80">
                <div class="relative aspect-[3/4] overflow-hidden rounded-2xl bg-surface-container-low mb-4">
                    <img alt="Minimalist shirt" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80" />
                    <button class="absolute bottom-4 right-4 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center shadow-lg opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" data-action="add-to-cart">
                        <span class="material-symbols-outlined text-sm">shopping_bag</span>
                    </button>
                </div>
                <div class="px-2">
                    <h3 class="text-lg font-bold text-primary tracking-tight">Axum Minimalist Shirt</h3>
                    <div class="flex justify-between items-center">
                        <p class="text-on-surface-variant text-xs">Mercerized Organic Cotton</p>
                        <span class="text-md font-bold text-primary">$160</span>
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
</body>
</html>
