<footer class="relative overflow-hidden bg-slate-950 text-white font-['Manrope'] text-sm">
    <div class="absolute inset-x-0 -top-20 h-64 bg-gradient-to-b from-primary/25 to-transparent blur-3xl opacity-60"></div>
    <div class="absolute right-0 top-10 h-56 w-56 rounded-full bg-primary/20 blur-3xl"></div>
    <div class="absolute left-0 bottom-0 h-48 w-48 rounded-full bg-cyan-500/10 blur-3xl"></div>
    <div class="relative max-w-screen-2xl mx-auto px-6 py-8">
        <div class="grid gap-8 lg:grid-cols-[1.8fr_1fr_1fr] lg:items-start">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-3 py-2 text-xs font-semibold text-white shadow-sm shadow-slate-950/40 backdrop-blur animate-[pulse_3s_ease-in-out_infinite]">
                    <span class="material-symbols-outlined">star</span>
                    Mpemba Marketplace
                </div>
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-white">Shop the best from Mpemba</h2>
                    <p class="mt-2 max-w-lg text-slate-300">Curated beauty, home, and electronics in one stylish marketplace. Fast checkout and easy support for every order.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-3xl bg-white/5 px-4 py-3 text-center text-slate-300">
                        <p class="text-sm font-semibold text-white">Fast delivery</p>
                        <p class="mt-1 text-xs text-slate-400">Quick shipping</p>
                    </div>
                    <div class="rounded-3xl bg-white/5 px-4 py-3 text-center text-slate-300">
                        <p class="text-sm font-semibold text-white">Support</p>
                        <p class="mt-1 text-xs text-slate-400">Always ready</p>
                    </div>
                    <div class="rounded-3xl bg-white/5 px-4 py-3 text-center text-slate-300">
                        <p class="text-sm font-semibold text-white">Curated picks</p>
                        <p class="mt-1 text-xs text-slate-400">Handpicked</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white">Quick links</h3>
                <div class="mt-5 grid gap-3 text-slate-300 sm:grid-cols-2">
                    <a href="/products" class="block hover:text-white transition">Products</a>
                    <a href="/category" class="block hover:text-white transition">Categories</a>
                    <a href="/cart" class="block hover:text-white transition">Cart</a>
                    <a href="/register" class="block hover:text-white transition">Register</a>
                    <a href="/login" class="block hover:text-white transition">Login</a>
                    <a href="#" class="block hover:text-white transition">Help Center</a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white">Stay connected</h3>
                <p class="mt-4 text-slate-300">Subscribe for new arrivals and special offers.</p>
                <form class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <input type="email" placeholder="Your email" class="w-full rounded-3xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
                    <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-primary px-5 py-3 text-sm font-semibold text-white transition hover:bg-primary/90">Join</button>
                </form>
                <div class="mt-4 flex items-center gap-3 text-slate-300">
                    <a href="#" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-primary hover:text-white"><span class="material-symbols-outlined">public</span></a>
                    <a href="#" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-primary hover:text-white"><span class="material-symbols-outlined">mail</span></a>
                    <a href="#" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-primary hover:text-white"><span class="material-symbols-outlined">share</span></a>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t border-white/10 pt-5 text-center text-slate-400 text-sm">© <?= date('Y') ?> Mpemba Marketplace. The Digital Atelier.</div>
    </div>
</footer>