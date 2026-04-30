<?php
// No backend required - static categories
$categories = [
    'Heritage Fashion' => [],
    'Sanctuary Home' => [],
    'Atelier Electronics' => [],
    'Natural Beauty' => [],
    'Lifestyle Essentials' => [],
];
$categoryImages = [
    'Heritage Fashion' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&h=800&fit=crop&crop=center',
    'Sanctuary Home' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=1200&h=800&fit=crop&crop=center',
    'Atelier Electronics' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=1200&h=800&fit=crop&crop=center',
    'Natural Beauty' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1200&h=800&fit=crop&crop=center',
    'Lifestyle Essentials' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=1200&h=800&fit=crop&crop=center',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curated Collections | Mpemba Marketplace</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700;800;900&family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'surface-dim': '#d9dadc',
                        'on-primary': '#ffffff',
                        'tertiary-container': '#c9a900',
                        'surface-container-low': '#f2f4f6',
                        'tertiary-fixed': '#ffe16d',
                        'surface-variant': '#e1e2e5',
                        'surface-tint': '#2a657e',
                        'on-tertiary': '#ffffff',
                        'tertiary-fixed-dim': '#e9c400',
                        'secondary-fixed-dim': '#ffb77d',
                        'on-error-container': '#93000a',
                        'on-surface-variant': '#40484c',
                        'error': '#ba1a1a',
                        'surface-container-lowest': '#ffffff',
                        'on-secondary': '#ffffff',
                        'on-primary-fixed': '#001f2b',
                        'inverse-on-surface': '#f0f1f3',
                        'inverse-surface': '#2e3133',
                        'surface': '#f8f9fb',
                        'on-tertiary-container': '#4c3f00',
                        'on-tertiary-fixed-variant': '#544600',
                        'on-primary-fixed-variant': '#044d65',
                        'primary': '#003345',
                        'outline-variant': '#c0c7cd',
                        'on-error': '#ffffff',
                        'surface-bright': '#f8f9fb',
                        'secondary-container': '#ffa454',
                        'on-secondary-fixed': '#2f1500',
                        'on-secondary-fixed-variant': '#6e3900',
                        'tertiary': '#705d00',
                        'surface-container-high': '#e7e8ea',
                        'on-secondary-container': '#713b00',
                        'inverse-primary': '#96ceeb',
                        'background': '#f8f9fb',
                        'outline': '#71787d',
                        'surface-container': '#edeef0',
                        'on-background': '#191c1e',
                        'secondary': '#904d00',
                        'on-primary-container': '#83bad6',
                        'on-tertiary-fixed': '#221b00',
                        'secondary-fixed': '#ffdcc3',
                        'primary-fixed-dim': '#96ceeb',
                        'error-container': '#ffdad6',
                        'primary-container': '#004b63',
                        'on-surface': '#191c1e',
                        'primary-fixed': '#bfe8ff',
                        'surface-container-highest': '#e1e2e5'
                    },
                    borderRadius: {
                        DEFAULT: '0.25rem',
                        lg: '0.5rem',
                        xl: '0.75rem',
                        full: '9999px'
                    },
                    fontFamily: {
                        headline: ['Epilogue'],
                        display: ['Epilogue'],
                        body: ['Manrope'],
                        label: ['Manrope']
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .editorial-gradient {
            background: linear-gradient(135deg, #003345 0%, #004b63 100%);
        }
        .glass-header {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-surface text-on-background font-body">
    <?php include __DIR__ . '/../components/ui/navbar.php'; ?>
    <main class="pt-20">
        <section class="relative h-[409px] min-h-[400px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 editorial-gradient z-0"></div>
            <div class="absolute inset-0 opacity-40 z-0">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1400&q=80" alt="Marketplace curated collections background">
            </div>
            <div class="relative z-10 text-center px-6">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs uppercase tracking-[0.4em] text-white/90">Curated categories</span>
                <h1 class="font-display font-black text-5xl md:text-7xl text-white tracking-tighter mb-4 mt-6">Collections for every lifestyle</h1>
                <p class="font-body text-white/80 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed">Browse signature categories that blend craftsmanship, technology and wellness into one elevated marketplace experience.</p>
            </div>
        </section>

        <section class="max-w-[1440px] mx-auto px-8 py-24 bg-surface">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 group cursor-pointer">
                    <div class="relative h-[600px] rounded-xl overflow-hidden bg-surface-container-lowest transition-all duration-500 hover:shadow-2xl">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1400&q=80" alt="Heritage Fashion" />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-12 text-on-primary">
                            <span class="font-label uppercase tracking-widest text-sm text-secondary-container mb-2 block">Couture Excellence</span>
                            <h2 class="font-display font-bold text-4xl mb-4">Heritage Fashion</h2>
                            <p class="font-body text-surface-variant max-w-md mb-6">Explore garments built on centuries of craftsmanship, redefined for today's silhouette.</p>
                            <a class="inline-flex items-center gap-2 font-label font-bold text-secondary-fixed group-hover:gap-4 transition-all" href="/heritage-fashion">Explore Collection <span class="material-symbols-outlined">arrow_forward</span></a>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4 group cursor-pointer">
                    <div class="relative h-[600px] rounded-xl overflow-hidden bg-surface-container-lowest transition-all duration-500 hover:shadow-2xl">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80" alt="Sanctuary Home" />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-on-primary">
                            <h2 class="font-display font-bold text-3xl mb-3">Sanctuary Home</h2>
                            <p class="font-body text-surface-variant text-sm mb-4">Quiet luxury for your private spaces.</p>
                            <a class="inline-flex items-center gap-2 font-label font-bold text-secondary-fixed" href="/sanctuary-home">Explore Collection <span class="material-symbols-outlined">arrow_forward</span></a>
                        <p class="mt-4 text-sm text-white/80 max-w-sm">Handpicked home pieces to elevate daily living with calm minimalism.</p>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4 group cursor-pointer">
                    <div class="relative h-[400px] rounded-xl overflow-hidden bg-surface-container-lowest transition-all duration-500 hover:shadow-xl">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80" alt="Atelier Electronics" />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-on-primary">
                            <h2 class="font-display font-bold text-2xl mb-2">Atelier Electronics</h2>
                            <a class="inline-flex items-center gap-2 font-label font-bold text-secondary-fixed" href="/atelier-electronics">Explore Collection <span class="material-symbols-outlined">arrow_forward</span></a>
                        <p class="mt-4 text-sm text-white/80 max-w-sm">Sleek electronics designed for creative work and effortless living.</p>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4 group cursor-pointer">
                    <div class="relative h-[400px] rounded-xl overflow-hidden bg-surface-container-lowest transition-all duration-500 hover:shadow-xl">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=80" alt="Natural Beauty" />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-on-primary">
                            <h2 class="font-display font-bold text-2xl mb-2">Natural Beauty</h2>
                            <a class="inline-flex items-center gap-2 font-label font-bold text-secondary-fixed" href="/natural-beauty">Explore Collection <span class="material-symbols-outlined">arrow_forward</span></a>
                        <p class="mt-4 text-sm text-white/80 max-w-sm">Beauty essentials made from botanicals and thoughtfully sourced ingredients.</p>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4 group cursor-pointer">
                    <div class="relative h-[400px] rounded-xl overflow-hidden bg-surface-container-lowest transition-all duration-500 hover:shadow-xl">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80" alt="Lifestyle Essentials" />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-on-primary">
                            <h2 class="font-display font-bold text-2xl mb-2">Lifestyle Essentials</h2>
                            <a class="inline-flex items-center gap-2 font-label font-bold text-secondary-fixed" href="/lifestyle-essentials">Explore Collection <span class="material-symbols-outlined">arrow_forward</span></a>
                        <p class="mt-4 text-sm text-white/80 max-w-sm">Everyday essentials designed for thoughtful routines and elevated comfort.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-surface-container-low py-24">
            <div class="max-w-[800px] mx-auto text-center px-8">
                <span class="font-label font-bold text-secondary tracking-widest text-sm mb-4 block uppercase">Join the Atelier</span>
                <h2 class="font-display font-bold text-4xl text-primary mb-6">Stay Inspired</h2>
                <p class="font-body text-on-surface-variant mb-10 text-lg">Receive a weekly curation of new artisans, exclusive collections, and design stories from our marketplace.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <input class="flex-grow px-6 py-4 bg-surface-container-lowest rounded-lg border-none focus:ring-2 focus:ring-primary shadow-sm transition-all" placeholder="Enter your email" type="email" />
                    <button class="px-8 py-4 bg-secondary text-on-secondary font-bold rounded-lg hover:scale-105 transition-all shadow-md">Subscribe Now</button>
                </div>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../components/ui/footer.php'; ?>
</body>
</html>
