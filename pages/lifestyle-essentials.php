<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Lifestyle Essentials | Mpemba Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700;800;900&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
        .text-shadow-sm {
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-background font-body text-on-surface selection:bg-secondary-fixed selection:text-on-secondary-fixed">
    <?php require_once __DIR__ . '/../config/bootstrap.php';
    include __DIR__ . '/../components/ui/navbar.php'; ?>
    <main class="pt-32 pb-20">
        <section class="max-w-7xl mx-auto px-8 mb-20">
            <div class="relative overflow-hidden rounded-xl h-[450px] flex items-center group">
                <img alt="Lifestyle essentials background" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1400&q=80" />
                <div class="absolute inset-0 bg-gradient-to-r from-primary/80 to-transparent"></div>
                <div class="relative z-10 px-12 max-w-2xl">
                    <span class="text-secondary-fixed font-label tracking-widest text-sm uppercase mb-4 block">Selected for You</span>
                    <h1 class="text-5xl md:text-7xl font-display font-black text-white leading-tight tracking-tighter mb-6">Lifestyle <br />Essentials</h1>
                    <p class="text-white/80 text-lg font-body leading-relaxed max-w-md">The modern archive of everyday artifacts. Timeless leather, precision stationery, and the tools of a life well-lived.</p>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-8 mb-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="flex flex-wrap gap-3">
                    <button data-category-filter="all" class="px-6 py-2 rounded-full bg-primary-fixed text-on-primary-fixed font-label text-sm font-semibold transition-all shadow-sm">All Essentials</button>
                    <button data-category-filter="Leather Goods" class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-label text-sm hover:bg-surface-container-high transition-all">Leather Goods</button>
                    <button data-category-filter="Stationery" class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-label text-sm hover:bg-surface-container-high transition-all">Stationery</button>
                    <button data-category-filter="Travel Gear" class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-label text-sm hover:bg-surface-container-high transition-all">Travel Gear</button>
                    <button data-category-filter="Personal Care" class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-label text-sm hover:bg-surface-container-high transition-all">Personal Care</button>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative flex-grow md:max-w-xs">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span>
                        <input type="search" data-search-target="cards" placeholder="Search essentials..." class="w-full pl-10 pr-4 py-2 bg-surface-container-high border-none rounded-xl text-sm focus:ring-2 focus:ring-primary transition-all" />
                    </div>
                    <div class="relative">
                        <select id="lifestyle-sort" class="appearance-none bg-surface-container-low border-none rounded-lg px-6 py-2 pr-12 font-label text-sm text-on-surface-variant focus:ring-2 focus:ring-primary">
                            <option value="">Sort by: Curated</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="newest">Newest Arrivals</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                    </div>
                    <button id="filters-reset-btn" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-surface-container-low text-on-surface-variant font-label text-sm hover:bg-surface-container-high transition-all">
                        <span class="material-symbols-outlined text-xl">tune</span>
                        Filters
                    </button>
                </div>
            </div>
        </section>

        <!-- Product Grid - 3 items per row with enhanced styling -->
        <section class="max-w-7xl mx-auto px-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Product 1: Heritage Leather Bag -->
            <div class="group bg-surface-container-lowest rounded-2xl border border-outline/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-category="Leather Goods" data-price="480">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/20 via-surface to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Heritage Leather Bag"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="wishlist-btn absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200" data-id="401">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Leather Goods</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Heritage Leather Bag</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Full-grain vegetable-tanned leather, handcrafted for the modern traveler.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline/20">
                        <span class="text-xl font-bold text-primary">$480</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="401" data-name="Heritage Leather Bag" data-price="480" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 2: Obsidian Scent Candle -->
            <div class="group bg-surface-container-lowest rounded-2xl border border-outline/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-category="Personal Care" data-price="62">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/20 via-surface to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Obsidian & Driftwood Scent"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="wishlist-btn absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200" data-id="402">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Home Care</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Obsidian & Driftwood</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Premium scented candle with rich woodsy and mineral notes for ambiance.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline/20">
                        <span class="text-xl font-bold text-primary">$62</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="402" data-name="Obsidian & Driftwood Scent" data-price="62" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 3: Pebble Wallet -->
            <div class="group bg-surface-container-lowest rounded-2xl border border-outline/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-category="Leather Goods" data-price="85">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/20 via-surface to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Slimline Pebble Wallet"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="wishlist-btn absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200" data-id="403">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Daily Carry</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Pebble Wallet</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Minimalist leather wallet designed for everyday essentials and travel.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline/20">
                        <span class="text-xl font-bold text-primary">$85</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="403" data-name="Slimline Pebble Wallet" data-price="85" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 4: Eclipse Eyewear -->
            <div class="group bg-surface-container-lowest rounded-2xl border border-outline/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-category="Personal Care" data-price="185">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/20 via-surface to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Eclipse Frame Eyewear"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="wishlist-btn absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200" data-id="404">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Accessories</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Eclipse Frame</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Premium titanium frames with anti-glare coating and adjustable fit.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline/20">
                        <span class="text-xl font-bold text-primary">$185</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="404" data-name="Eclipse Frame Eyewear" data-price="185" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 5: Archive Journal -->
            <div class="group bg-surface-container-lowest rounded-2xl border border-outline/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-category="Stationery" data-price="45">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/20 via-surface to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Gilded Edge Journal"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="wishlist-btn absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200" data-id="405">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Stationery</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Archive Journal</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Luxury hardcover journal with gilded edges and premium paper.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline/20">
                        <span class="text-xl font-bold text-primary">$45</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="405" data-name="Gilded Edge Archive Journal" data-price="45" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 6: Travel Gear -->
            <div class="group bg-surface-container-lowest rounded-2xl border border-outline/20 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full" data-category="Travel Gear" data-price="95">
                <div class="relative overflow-hidden bg-gradient-to-br from-secondary/20 via-surface to-transparent aspect-[3/4]">
                    <img 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=600&h=750&fit=crop&crop=center&q=80" 
                        alt="Premium Travel Kit"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="wishlist-btn absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition-colors hover:scale-110 transform duration-200" data-id="406">
                        <span class="material-symbols-outlined text-primary text-lg">favorite</span>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-block rounded-full bg-secondary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-on-secondary-fixed">Travel</span>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2 line-clamp-2">Premium Travel Kit</h3>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow line-clamp-2">Compact organizer set designed for efficient travel and daily use.</p>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-outline/20">
                        <span class="text-xl font-bold text-primary">$95</span>
                        <button class="add-to-cart inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm hover:shadow-md active:scale-95" 
                            data-id="406" data-name="Premium Travel Kit" data-price="95" title="Add to cart">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-8 mt-24">
            <div class="bg-surface-container-high rounded-2xl p-12 md:p-20 flex flex-col md:flex-row items-center gap-12 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative z-10 flex-1">
                    <h2 class="text-4xl font-display font-black text-primary mb-6 leading-tight">Join the Digital Atelier Experience</h2>
                    <p class="text-on-surface-variant font-body text-lg leading-relaxed max-w-lg">Receive early access to seasonal drops, heritage stories, and curated lifestyle insights from our editors.</p>
                </div>
                <div class="relative z-10 w-full md:w-auto">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input class="px-6 py-4 rounded-lg bg-white border-none focus:ring-2 focus:ring-secondary w-full sm:w-80 font-body" placeholder="atelier@member.com" type="email" />
                        <button data-join-btn class="bg-primary text-white px-10 py-4 rounded-lg font-label font-bold uppercase tracking-widest hover:bg-primary/90 transition-colors whitespace-nowrap">Join Now</button>
                    </div>
                    <p class="mt-4 text-xs text-outline font-label">By joining, you agree to our heritage standards and privacy policy.</p>
                </div>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../components/ui/footer.php'; ?>
    <script src="/js/app.js"></script>
    <script>
    (function(){
      // Category filter
      var allCards=Array.from(document.querySelectorAll('[data-category]'));
      var origOrder=allCards.slice();
      function renderCards(cards){
        var grid=document.querySelector('section.max-w-7xl.mx-auto.px-8.grid');
        if(!grid)return;
        cards.forEach(function(c){grid.appendChild(c);});
      }
      document.querySelectorAll('[data-category-filter]').forEach(function(btn){
        btn.addEventListener('click',function(){
          var cat=this.dataset.categoryFilter;
          document.querySelectorAll('[data-category-filter]').forEach(function(b){
            b.classList.remove('bg-primary-fixed','text-on-primary-fixed');
            b.classList.add('bg-surface-container-highest','text-on-surface-variant');
          });
          this.classList.remove('bg-surface-container-highest','text-on-surface-variant');
          this.classList.add('bg-primary-fixed','text-on-primary-fixed');
          allCards.forEach(function(c){
            c.style.display=(cat==='all'||c.dataset.category===cat)?'':'none';
          });
        });
      });
      // Sort
      var sortSel=document.getElementById('lifestyle-sort');
      if(sortSel) sortSel.addEventListener('change',function(){
        var val=this.value;
        var grid=document.querySelector('section.max-w-7xl.mx-auto.px-8.grid');
        if(!grid)return;
        var visible=allCards.filter(function(c){return c.style.display!=='none';});
        if(val==='price-asc') visible.sort(function(a,b){return parseFloat(a.dataset.price||0)-parseFloat(b.dataset.price||0);});
        else if(val==='price-desc') visible.sort(function(a,b){return parseFloat(b.dataset.price||0)-parseFloat(a.dataset.price||0);});
        else visible=origOrder.filter(function(c){return c.style.display!=='none';});
        visible.forEach(function(c){grid.appendChild(c);});
      });
      // Reset filters button
      var resetBtn=document.getElementById('filters-reset-btn');
      if(resetBtn) resetBtn.addEventListener('click',function(){
        allCards.forEach(function(c){c.style.display='';});
        if(sortSel) sortSel.value='';
        document.querySelectorAll('[data-category-filter]').forEach(function(b){
          b.classList.remove('bg-primary-fixed','text-on-primary-fixed');
          b.classList.add('bg-surface-container-highest','text-on-surface-variant');
        });
        var allBtn=document.querySelector('[data-category-filter="all"]');
        if(allBtn){ allBtn.classList.add('bg-primary-fixed','text-on-primary-fixed'); allBtn.classList.remove('bg-surface-container-highest','text-on-surface-variant'); }
      });
      // Wishlist buttons
      document.querySelectorAll('.wishlist-btn').forEach(function(btn){
        var id=String(btn.dataset.id);
        var icon=btn.querySelector('.material-symbols-outlined');
        var wl=JSON.parse(localStorage.getItem('wishlist')||'[]');
        if(icon) icon.style.color=wl.includes(id)?'#e11d48':'';
        btn.addEventListener('click',function(e){
          e.stopPropagation();
          var wl2=JSON.parse(localStorage.getItem('wishlist')||'[]');
          var idx=wl2.indexOf(id);
          if(idx===-1){wl2.push(id);if(icon)icon.style.color='#e11d48';}
          else{wl2.splice(idx,1);if(icon)icon.style.color='';}
          localStorage.setItem('wishlist',JSON.stringify(wl2));
        });
      });
      // Join Now button
      var joinBtn=document.querySelector('[data-join-btn]');
      if(joinBtn) joinBtn.addEventListener('click',function(){
        var inp=document.querySelector('input[type="email"]');
        if(!inp||!inp.value.trim()||!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inp.value)){
          if(typeof Swal!=='undefined') Swal.fire({icon:'warning',title:'Email Required',text:'Please enter a valid email address to join.',confirmButtonColor:'#003345'});
          else alert('Please enter a valid email.');
          return;
        }
        inp.value='';
        if(typeof Swal!=='undefined') Swal.fire({icon:'success',title:'Welcome to the Atelier!',text:'You now have early access to seasonal drops and curated lifestyle insights.',confirmButtonColor:'#003345'});
        else alert('Welcome! You have joined successfully.');
      });
    })();
    </script>
</body>
</html>
