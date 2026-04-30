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

    <section class="grid gap-8 md:grid-cols-2 xl:grid-cols-4">
        <article class="group rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:shadow-xl">
            <div class="relative overflow-hidden rounded-t-[2rem] aspect-[4/5] bg-slate-100">
                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&h=750&fit=crop&crop=center" alt="Organic Face Serum">
                <div class="absolute top-4 right-4 rounded-full bg-white/90 p-3 shadow-sm">
                    <span class="material-symbols-outlined text-slate-900">favorite</span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-700">Skincare</span>
                    <div class="flex items-center gap-1 text-sm text-slate-600">
                        <span class="material-symbols-outlined text-yellow-500">star</span>
                        <span>4.8</span>
                    </div>
                </div>
                <h2 class="text-xl font-semibold text-slate-950 mb-3">Organic Face Serum</h2>
                <p class="text-sm leading-6 text-slate-600 mb-6">Hydrating serum with aloe vera and hyaluronic acid for radiant, healthy skin.</p>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-2xl font-bold text-slate-950">$49</span>
                    <button class="add-to-cart inline-flex items-center gap-2 rounded-2xl bg-primary px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary/90" data-id="501" data-name="Organic Face Serum" data-price="49">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        Add
                    </button>
                </div>
            </div>
        </article>

        <article class="group rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:shadow-xl">
            <div class="relative overflow-hidden rounded-t-[2rem] aspect-[4/5] bg-slate-100">
                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?w=600&h=750&fit=crop&crop=center" alt="Natural Shampoo">
                <div class="absolute top-4 right-4 rounded-full bg-white/90 p-3 shadow-sm">
                    <span class="material-symbols-outlined text-slate-900">favorite</span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <span class="rounded-full bg-cyan-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-cyan-800">Hair Care</span>
                    <div class="flex items-center gap-1 text-sm text-slate-600">
                        <span class="material-symbols-outlined text-yellow-500">star</span>
                        <span>4.9</span>
                    </div>
                </div>
                <h2 class="text-xl font-semibold text-slate-950 mb-3">Natural Shampoo</h2>
                <p class="text-sm leading-6 text-slate-600 mb-6">A gentle botanical shampoo that strengthens and softens every strand.</p>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-2xl font-bold text-slate-950">$29</span>
                    <button class="add-to-cart inline-flex items-center gap-2 rounded-2xl bg-primary px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary/90" data-id="502" data-name="Natural Shampoo" data-price="29">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        Add
                    </button>
                </div>
            </div>
        </article>

        <article class="group rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:shadow-xl">
            <div class="relative overflow-hidden rounded-t-[2rem] aspect-[4/5] bg-slate-100">
                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1556228578-0d191d7056ac?w=600&h=750&fit=crop&crop=center" alt="Moisturizing Cream">
                <div class="absolute top-4 right-4 rounded-full bg-white/90 p-3 shadow-sm">
                    <span class="material-symbols-outlined text-slate-900">favorite</span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-800">Skincare</span>
                    <div class="flex items-center gap-1 text-sm text-slate-600">
                        <span class="material-symbols-outlined text-yellow-500">star</span>
                        <span>4.7</span>
                    </div>
                </div>
                <h2 class="text-xl font-semibold text-slate-950 mb-3">Moisturizing Cream</h2>
                <p class="text-sm leading-6 text-slate-600 mb-6">Rich moisturizer built for dry skin with calming shea and chamomile.</p>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-2xl font-bold text-slate-950">$39</span>
                    <button class="add-to-cart inline-flex items-center gap-2 rounded-2xl bg-primary px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary/90" data-id="503" data-name="Moisturizing Cream" data-price="39">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        Add
                    </button>
                </div>
            </div>
        </article>

        <article class="group rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:shadow-xl">
            <div class="relative overflow-hidden rounded-t-[2rem] aspect-[4/5] bg-slate-100">
                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&h=750&fit=crop&crop=center" alt="Rose Geranium Oil">
                <div class="absolute top-4 right-4 rounded-full bg-white/90 p-3 shadow-sm">
                    <span class="material-symbols-outlined text-slate-900">favorite</span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <span class="rounded-full bg-pink-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-pink-800">Essential Oils</span>
                    <div class="flex items-center gap-1 text-sm text-slate-600">
                        <span class="material-symbols-outlined text-yellow-500">star</span>
                        <span>4.9</span>
                    </div>
                </div>
                <h2 class="text-xl font-semibold text-slate-950 mb-3">Rose Geranium Oil</h2>
                <p class="text-sm leading-6 text-slate-600 mb-6">A calming aromatherapy oil for uplifted, balanced skin and mood.</p>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-2xl font-bold text-slate-950">$27</span>
                    <button class="add-to-cart inline-flex items-center gap-2 rounded-2xl bg-primary px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary/90" data-id="504" data-name="Rose Geranium Oil" data-price="27">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        Add
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

<?php include __DIR__ . '/../components/ui/footer.php'; ?>
<script src="assets/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/js/app.js"></script>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-16">
        <!-- Product Card 1 -->
        <div class="group bg-surface rounded-2xl shadow-sm border border-outline/50 overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="aspect-square bg-gradient-to-br from-primary/5 to-secondary/5 relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400&h=400&fit=crop&crop=center" alt="Organic Face Serum" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <button class="absolute top-4 right-4 w-10 h-10 bg-surface/80 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-lg">favorite</span>
                </button>
            </div>
                    <span class="material-symbols-outlined text-lg">favorite</span>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="px-3 py-1 bg-tertiary-container text-on-tertiary-container text-xs font-medium rounded-full">Skincare</span>
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-yellow-500">star</span>
                        <span class="text-sm font-medium">4.8</span>
                        <span class="text-sm text-on-surface-variant">(124)</span>
                    </div>
                </div>
                <h3 class="font-semibold text-lg mb-2">Organic Face Serum</h3>
                <p class="text-on-surface-variant text-sm mb-4 line-clamp-2">Hydrating serum with aloe vera and hyaluronic acid for radiant, healthy skin.</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-bold text-primary">$49.99</span>
                    <button onclick="addToCart('Organic Face Serum', 49.99)" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-medium hover:bg-primary/90 transition-colors">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Card 2 -->
        <div class="group bg-surface rounded-2xl shadow-sm border border-outline/50 overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="aspect-square bg-gradient-to-br from-secondary/5 to-tertiary/5 relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?w=400&h=400&fit=crop&crop=center" alt="Natural Shampoo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <button class="absolute top-4 right-4 w-10 h-10 bg-surface/80 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-lg">favorite</span>
                </button>
            </div>
                    <span class="material-symbols-outlined text-lg">favorite</span>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-xs font-medium rounded-full">Hair Care</span>
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-yellow-500">star</span>
                        <span class="text-sm font-medium">4.9</span>
                        <span class="text-sm text-on-surface-variant">(89)</span>
                    </div>
                </div>
                <h3 class="font-semibold text-lg mb-2">Natural Shampoo</h3>
                <p class="text-on-surface-variant text-sm mb-4 line-clamp-2">Organic shampoo for all hair types</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-bold text-primary">$19.99</span>
                    <button onclick="addToCart('Natural Shampoo', 19.99)" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-medium hover:bg-primary/90 transition-colors">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Card 3 -->
        <div class="group bg-surface rounded-2xl shadow-sm border border-outline/50 overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="aspect-square bg-gradient-to-br from-tertiary/5 to-primary/5 relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1556228578-0d191d7056ac?w=400&h=400&fit=crop&crop=center" alt="Moisturizing Cream" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <button class="absolute top-4 right-4 w-10 h-10 bg-surface/80 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-outlined text-lg">favorite</span>
                </button>
            </div>
                    <span class="material-symbols-outlined text-lg">favorite</span>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="px-3 py-1 bg-primary-container text-on-primary-container text-xs font-medium rounded-full">Skincare</span>
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-yellow-500">star</span>
                        <span class="text-sm font-medium">4.7</span>
                        <span class="text-sm text-on-surface-variant">(156)</span>
                    </div>
                </div>
                <h3 class="font-semibold text-lg mb-2">Moisturizing Cream</h3>
                <p class="text-on-surface-variant text-sm mb-4 line-clamp-2">Hydrating cream for dry skin</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-bold text-primary">$39.99</span>
                    <button onclick="addToCart('Moisturizing Cream', 39.99)" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-medium hover:bg-primary/90 transition-colors">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 rounded-lg bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined text-lg">chevron_left</span>
            </button>
            <button class="px-4 py-2 rounded-lg bg-primary text-on-primary font-medium">1</button>
            <button class="px-4 py-2 rounded-lg bg-surface text-on-surface hover:bg-surface-variant transition-colors">2</button>
            <button class="px-4 py-2 rounded-lg bg-surface text-on-surface hover:bg-surface-variant transition-colors">3</button>
            <button class="px-4 py-2 rounded-lg bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined text-lg">chevron_right</span>
            </button>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>

<script>
function addToCart(productName, price) {
    // Get existing cart from localStorage
    let cart = JSON.parse(localStorage.getItem('mpemba_cart') || '[]');

    // Check if product already exists
    const existingProduct = cart.find(item => item.name === productName);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({
            name: productName,
            price: price,
            quantity: 1,
            addedAt: new Date().toISOString()
        });
    }

    // Save back to localStorage
    localStorage.setItem('mpemba_cart', JSON.stringify(cart));

    // Show success message
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Added to Cart!',
            text: `${productName} has been added to your cart.`,
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    } else {
        alert(`${productName} has been added to your cart!`);
    }

    // Update cart count in navbar if function exists
    if (typeof updateCartCount === 'function') {
        updateCartCount();
    }
}
</script>