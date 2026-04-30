<?php include __DIR__ . '/../components/ui/navbar.php'; ?>

<main class="pt-28 bg-slate-50 text-slate-900">
    <section class="relative overflow-hidden pb-20">
        <div class="absolute inset-x-0 top-0 h-64 bg-gradient-to-b from-primary/20 to-transparent pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid gap-10 lg:grid-cols-12 items-center py-16">
                <div class="lg:col-span-6 space-y-6">
                    <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-2 text-sm font-semibold text-primary shadow-sm shadow-primary/10">New arrivals • Shop the latest trends</span>
                    <h1 class="text-5xl md:text-6xl font-black tracking-tight leading-tight">Experience beautiful shopping with premium collections.</h1>
                    <p class="max-w-2xl text-lg text-slate-600">Browse handpicked home, beauty, fashion and electronics products with fast checkout, safe payment, and delightful delivery.</p>

                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="/products" class="inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-white text-base font-semibold shadow-lg shadow-primary/20 hover:bg-primary/90 transition">Shop products</a>
                        <a href="/category" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-slate-700 text-base font-medium hover:border-primary hover:text-primary transition">Browse categories</a>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3 mt-10">
                        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
                            <p class="text-2xl font-bold text-primary">4.9/5</p>
                            <p class="mt-2 text-sm text-slate-500">Customer satisfaction</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
                            <p class="text-2xl font-bold text-primary">200+</p>
                            <p class="mt-2 text-sm text-slate-500">Trusted products</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
                            <p class="text-2xl font-bold text-primary">Fast</p>
                            <p class="mt-2 text-sm text-slate-500">Delivery experience</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 relative">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="group overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-200/70 transition-transform duration-700 hover:-translate-y-2">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=900&h=900&fit=crop&crop=center" alt="Beauty collection" class="h-64 w-full object-cover transition duration-700 group-hover:scale-105">
                            <div class="p-5">
                                <p class="text-sm uppercase tracking-[0.35em] text-slate-500 mb-3">Natural beauty</p>
                                <h3 class="text-xl font-semibold text-slate-900">Fresh skincare essentials</h3>
                            </div>
                        </div>
                        <div class="group overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-200/70 transition-transform duration-700 hover:-translate-y-2">
                            <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=900&h=900&fit=crop&crop=center" alt="Fashion collection" class="h-64 w-full object-cover transition duration-700 group-hover:scale-105">
                            <div class="p-5">
                                <p class="text-sm uppercase tracking-[0.35em] text-slate-500 mb-3">Heritage fashion</p>
                                <h3 class="text-xl font-semibold text-slate-900">Curated wardrobe picks</h3>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5 mt-5">
                        <div class="group overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-200/70 transition-transform duration-700 hover:-translate-y-2">
                            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=900&h=900&fit=crop&crop=center" alt="Electronics" class="h-64 w-full object-cover transition duration-700 group-hover:scale-105">
                            <div class="p-5">
                                <p class="text-sm uppercase tracking-[0.35em] text-slate-500 mb-3">Tech gear</p>
                                <h3 class="text-xl font-semibold text-slate-900">Modern electronics</h3>
                            </div>
                        </div>
                        <div class="group overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-200/70 transition-transform duration-700 hover:-translate-y-2">
                            <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=900&h=900&fit=crop&crop=center" alt="Home essentials" class="h-64 w-full object-cover transition duration-700 group-hover:scale-105">
                            <div class="p-5">
                                <p class="text-sm uppercase tracking-[0.35em] text-slate-500 mb-3">Home care</p>
                                <h3 class="text-xl font-semibold text-slate-900">Cozy home collection</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-[2rem] border border-slate-200/70 bg-white p-8 shadow-lg backdrop-blur-xl">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-primary/10 text-primary mb-5">
                    <span class="material-symbols-outlined">local_shipping</span>
                </div>
                <h3 class="text-2xl font-bold mb-3">Free shipping</h3>
                <p class="text-slate-600">Enjoy fast delivery across all orders with simple tracking updates.</p>
            </div>
            <div class="rounded-[2rem] border border-slate-200/70 bg-white p-8 shadow-lg backdrop-blur-xl">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-primary/10 text-primary mb-5">
                    <span class="material-symbols-outlined">thumb_up</span>
                </div>
                <h3 class="text-2xl font-bold mb-3">Trusted quality</h3>
                <p class="text-slate-600">Only top-rated products selected from our best-selling collections.</p>
            </div>
            <div class="rounded-[2rem] border border-slate-200/70 bg-white p-8 shadow-lg backdrop-blur-xl">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-primary/10 text-primary mb-5">
                    <span class="material-symbols-outlined">support_agent</span>
                </div>
                <h3 class="text-2xl font-bold mb-3">24/7 support</h3>
                <p class="text-slate-600">Ask questions anytime and receive friendly help from our team.</p>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>
