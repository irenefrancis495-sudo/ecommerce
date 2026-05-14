<?php require_once __DIR__ . '/../config/bootstrap.php';
include __DIR__ . '/../components/ui/navbar.php'; ?>

<main class="min-h-screen">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 pt-32 pb-20">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-2 text-sm font-semibold text-primary mb-6">
                <span class="material-symbols-outlined text-base">info</span>
                About Our Heritage
            </span>
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-6">Mpemba Marketplace Heritage</h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">Celebrating Africa's finest artisans and craftspeople through a modern digital platform that connects tradition with contemporary commerce.</p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid gap-12 lg:grid-cols-2 items-center">
            <div>
                <h2 class="text-4xl font-black text-slate-900 mb-6">Our Story</h2>
                <div class="space-y-4 text-slate-600">
                    <p>Mpemba Marketplace was born from a vision to preserve and celebrate African heritage while embracing modern commerce. We believe every handcrafted piece tells a story—a story of tradition, skill, and cultural pride.</p>
                    <p>Founded to bridge the gap between artisans and global consumers, we provide a platform where tradition meets innovation. Our name, Mpemba, pays homage to African heritage and the artisans who keep these traditions alive.</p>
                    <p>Today, we're proud to connect thousands of customers with authentic, handcrafted products from talented artisans across the continent and beyond.</p>
                </div>
            </div>
            <div class="rounded-3xl bg-gradient-to-br from-primary/10 to-cyan-500/10 p-12 border border-primary/20">
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary text-white">
                                <span class="material-symbols-outlined">store</span>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Founded with Purpose</h3>
                            <p class="text-sm text-slate-600 mt-1">Creating sustainable income for artisans worldwide</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary text-white">
                                <span class="material-symbols-outlined">people</span>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Community Driven</h3>
                            <p class="text-sm text-slate-600 mt-1">Supporting 1000+ artisans across multiple countries</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary text-white">
                                <span class="material-symbols-outlined">verified</span>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Quality Assured</h3>
                            <p class="text-sm text-slate-600 mt-1">Every item handpicked and verified by our team</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-slate-900 mb-4">Our Values</h2>
            <p class="text-lg text-slate-600">What drives us every single day</p>
        </div>
        <div class="grid gap-8 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-lg transition-shadow">
                <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 text-primary mb-4">
                    <span class="material-symbols-outlined">favorite</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Authenticity</h3>
                <p class="text-slate-600">We celebrate genuine craftsmanship and cultural authenticity in every product we feature.</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-lg transition-shadow">
                <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 text-primary mb-4">
                    <span class="material-symbols-outlined">handshake</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Fair Trade</h3>
                <p class="text-slate-600">We ensure artisans receive fair compensation and sustainable income for their work.</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-lg transition-shadow">
                <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 text-primary mb-4">
                    <span class="material-symbols-outlined">eco</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Sustainability</h3>
                <p class="text-slate-600">Environmental responsibility and ethical practices are core to our operations.</p>
            </div>
        </div>
    </section>

    <!-- Team Stats -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="bg-gradient-to-r from-primary to-cyan-500 rounded-3xl p-12 text-white">
            <div class="grid gap-8 md:grid-cols-4 text-center">
                <div>
                    <p class="text-4xl font-black mb-2">1000+</p>
                    <p class="text-sm font-semibold text-white/80">Artisans</p>
                </div>
                <div>
                    <p class="text-4xl font-black mb-2">50K+</p>
                    <p class="text-sm font-semibold text-white/80">Happy Customers</p>
                </div>
                <div>
                    <p class="text-4xl font-black mb-2">15+</p>
                    <p class="text-sm font-semibold text-white/80">Countries</p>
                </div>
                <div>
                    <p class="text-4xl font-black mb-2">$2M+</p>
                    <p class="text-sm font-semibold text-white/80">Artisan Revenue</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>
