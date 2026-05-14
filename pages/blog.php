<?php require_once __DIR__ . '/../config/bootstrap.php';
include __DIR__ . '/../components/ui/navbar.php'; ?>

<main class="min-h-screen">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 pt-32 pb-20">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-2 text-sm font-semibold text-primary mb-6">
                <span class="material-symbols-outlined text-base">article</span>
                Stories & Insights
            </span>
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-6">Mpemba Blog</h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">Discover stories from our artisans, shopping tips, and insights into African heritage and contemporary craft.</p>
        </div>
    </section>

    <!-- Featured Post -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="rounded-3xl overflow-hidden bg-white shadow-lg border border-slate-200">
            <div class="grid gap-8 lg:grid-cols-2 items-center">
                <div class="h-96 lg:h-auto bg-gradient-to-br from-primary/20 to-cyan-500/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-9xl text-primary/30">image</span>
                </div>
                <div class="p-8 lg:p-12">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            Featured
                        </span>
                        <span class="text-xs text-slate-500">May 2, 2026</span>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 mb-4">Preserving Heritage Through Modern Craft</h2>
                    <p class="text-slate-600 mb-6">Discover how traditional weaving techniques are being transformed into contemporary fashion. Learn from Studio Kaji's journey of bridging ancient traditions with modern design.</p>
                    <div class="flex items-center gap-3 pb-6 border-b border-slate-200 mb-6">
                        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">SK</div>
                        <div>
                            <p class="font-semibold text-slate-900">Studio Kaji</p>
                            <p class="text-xs text-slate-500">Master Artisan</p>
                        </div>
                    </div>
                    <a href="#" class="inline-flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all">
                        Read Full Story
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Posts Grid -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <h2 class="text-3xl font-black text-slate-900 mb-12">Latest Stories</h2>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <!-- Post 1 -->
            <article class="rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg transition-shadow group cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-primary/10 to-cyan-500/10 flex items-center justify-center group-hover:from-primary/20 group-hover:to-cyan-500/20 transition-colors">
                    <span class="material-symbols-outlined text-6xl text-primary/30 group-hover:text-primary/40 transition-colors">handcraft</span>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-primary">ARTISAN PROFILE</span>
                    <h3 class="text-xl font-black text-slate-900 mt-2 mb-3">Meet Amina: Master of Leather</h3>
                    <p class="text-sm text-slate-600 mb-4">Exploring the craftsmanship behind hand-stitched leather goods from Ethiopia.</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        April 28, 2026
                    </div>
                </div>
            </article>

            <!-- Post 2 -->
            <article class="rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg transition-shadow group cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-primary/10 to-cyan-500/10 flex items-center justify-center group-hover:from-primary/20 group-hover:to-cyan-500/20 transition-colors">
                    <span class="material-symbols-outlined text-6xl text-primary/30 group-hover:text-primary/40 transition-colors">shopping_bag</span>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-primary">SHOPPING GUIDE</span>
                    <h3 class="text-xl font-black text-slate-900 mt-2 mb-3">Sustainable Shopping Guide</h3>
                    <p class="text-sm text-slate-600 mb-4">How to make eco-conscious choices while supporting African artisans.</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        April 25, 2026
                    </div>
                </div>
            </article>

            <!-- Post 3 -->
            <article class="rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg transition-shadow group cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-primary/10 to-cyan-500/10 flex items-center justify-center group-hover:from-primary/20 group-hover:to-cyan-500/20 transition-colors">
                    <span class="material-symbols-outlined text-6xl text-primary/30 group-hover:text-primary/40 transition-colors">celebration</span>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-primary">CULTURAL HERITAGE</span>
                    <h3 class="text-xl font-black text-slate-900 mt-2 mb-3">Celebrating Kente Cloth</h3>
                    <p class="text-sm text-slate-600 mb-4">The rich history and significance of Ghanaian Kente weaving traditions.</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        April 20, 2026
                    </div>
                </div>
            </article>

            <!-- Post 4 -->
            <article class="rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg transition-shadow group cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-primary/10 to-cyan-500/10 flex items-center justify-center group-hover:from-primary/20 group-hover:to-cyan-500/20 transition-colors">
                    <span class="material-symbols-outlined text-6xl text-primary/30 group-hover:text-primary/40 transition-colors">spa</span>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-primary">BEAUTY & WELLNESS</span>
                    <h3 class="text-xl font-black text-slate-900 mt-2 mb-3">Natural Beauty Secrets</h3>
                    <p class="text-sm text-slate-600 mb-4">Discovering ancient beauty rituals and natural skincare from Africa.</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        April 15, 2026
                    </div>
                </div>
            </article>

            <!-- Post 5 -->
            <article class="rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg transition-shadow group cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-primary/10 to-cyan-500/10 flex items-center justify-center group-hover:from-primary/20 group-hover:to-cyan-500/20 transition-colors">
                    <span class="material-symbols-outlined text-6xl text-primary/30 group-hover:text-primary/40 transition-colors">home</span>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-primary">HOME INSPIRATION</span>
                    <h3 class="text-xl font-black text-slate-900 mt-2 mb-3">Interior Design Trends</h3>
                    <p class="text-sm text-slate-600 mb-4">Incorporating artisan pieces into your home decor with style.</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        April 10, 2026
                    </div>
                </div>
            </article>

            <!-- Post 6 -->
            <article class="rounded-2xl border border-slate-200 bg-white overflow-hidden hover:shadow-lg transition-shadow group cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-primary/10 to-cyan-500/10 flex items-center justify-center group-hover:from-primary/20 group-hover:to-cyan-500/20 transition-colors">
                    <span class="material-symbols-outlined text-6xl text-primary/30 group-hover:text-primary/40 transition-colors">travel</span>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-primary">TRAVEL & CULTURE</span>
                    <h3 class="text-xl font-black text-slate-900 mt-2 mb-3">Markets of West Africa</h3>
                    <p class="text-sm text-slate-600 mb-4">A journey through vibrant traditional markets and artisan communities.</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        April 5, 2026
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="bg-gradient-to-r from-primary to-cyan-500 rounded-3xl p-12 text-white text-center">
            <h2 class="text-3xl font-black mb-4">Get Stories Delivered</h2>
            <p class="mb-8 text-white/90 max-w-xl mx-auto">Subscribe to our newsletter for weekly artisan stories, cultural insights, and exclusive shopping recommendations.</p>
            <form class="flex gap-3 max-w-md mx-auto" data-subscribe data-source="blog">
                <input type="email" placeholder="Enter your email" required class="flex-1 rounded-full px-6 py-3 text-slate-900 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-white/30" />
                <button type="submit" class="bg-white text-primary px-8 py-3 rounded-full font-bold hover:bg-white/90 transition">Subscribe</button>
            </form>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>
