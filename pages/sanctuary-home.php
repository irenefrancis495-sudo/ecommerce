<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sanctuary Home | Mpemba Marketplace</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;600;700;800&amp;family=Manrope:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
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
        body { font-family: 'Manrope', sans-serif; background-color: #f8f9fb; }
        h1, h2, h3 { font-family: 'Epilogue', sans-serif; }
    </style>
</head>
<body class="text-on-surface">
<?php include __DIR__ . '/../components/ui/navbar.php'; ?>
<main class="pt-32 pb-20">
<!-- Hero Section: Digital Atelier Editorial -->
<section class="max-w-7xl mx-auto px-8 mb-20">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end">
<div class="lg:col-span-7">
<h1 class="text-5xl md:text-7xl font-extrabold tracking-tighter text-primary mb-6 leading-none">
                        Sanctuary <br/><span class="text-secondary italic font-light">Home</span>
</h1>
<p class="text-lg text-on-surface-variant max-w-xl font-body leading-relaxed">
                        Curated architectural objects and handcrafted ceramics designed to transform living spaces into meditative landscapes. Experience the intersection of heritage craft and modern minimalism.
                    </p>
</div>
<div class="lg:col-span-5 relative">
<div class="aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low shadow-lg">
                <img class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=1200&h=800&fit=crop&crop=center" alt="Minimalist living room with ceramic vase" />
</div>
<div class="absolute -bottom-6 -left-12 hidden lg:block bg-secondary p-8 rounded-xl text-on-secondary shadow-xl max-w-[200px]">
<span class="text-xs uppercase tracking-widest font-label block mb-2 opacity-80">Season Focus</span>
<p class="font-headline font-bold text-xl leading-tight">The Earth &amp; Form Collection</p>
</div>
</div>
</div>
</section>
<!-- Filters Section -->
<section class="max-w-7xl mx-auto px-8 mb-12">
<div class="flex flex-col md:flex-row gap-8 justify-between items-start md:items-center">
<div class="flex flex-wrap gap-3">
<span class="text-sm font-bold uppercase tracking-widest text-primary/40 mr-2 flex items-center">Room</span>
<button class="px-6 py-2 rounded-full bg-primary-fixed text-on-primary-fixed font-medium text-sm transition-all hover:scale-105">All Spaces</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Lounge</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Dining</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Bedroom</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Studio</button>
</div>
<div class="flex flex-wrap gap-3">
<span class="text-sm font-bold uppercase tracking-widest text-primary/40 mr-2 flex items-center">Material</span>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Raw Ceramic</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Oak Wood</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Brushed Brass</button>
</div>
</div>
</section>
<!-- Product Grid: Asymmetric Composition -->
<section class="max-w-7xl mx-auto px-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
<!-- Product 1 -->
<div class="flex flex-col group">
<div class="aspect-square bg-surface-container-lowest overflow-hidden mb-6 relative">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=600&fit=crop&crop=center" alt="Handcrafted ceramic bowl" />
<div class="absolute top-4 right-4 bg-white/60 backdrop-blur-md px-3 py-1 rounded-full text-[10px] uppercase tracking-widest font-bold">Limited Edition</div>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Obsidian Rimmed Vessel</h3>
<p class="text-sm text-on-surface-variant font-body">Hand-thrown Stoneware</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$124.00</span>
</div>
<button class="mt-6 w-full py-4 bg-primary text-white font-bold tracking-widest uppercase text-xs hover:bg-primary-container transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 duration-300">
                        View Piece
                        <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
</button>
</div>
<!-- Product 2 (Large Vertical) -->
<div class="flex flex-col group lg:row-span-2">
<div class="aspect-[3/4] bg-surface-container-lowest overflow-hidden mb-6">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=800&fit=crop&crop=center" alt="Minimalist wooden floor lamp" />
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Nordic Oak Luminary</h3>
<p class="text-sm text-on-surface-variant font-body">Sustainably Sourced Oak</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$490.00</span>
</div>
<button class="mt-6 w-full py-4 bg-secondary text-on-secondary font-bold tracking-widest uppercase text-xs hover:scale-102 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 duration-300">
                        Add to Collection
                        <span class="material-symbols-outlined text-sm" data-icon="add">add</span>
</button>
</div>
<!-- Product 3 -->
<div class="flex flex-col group">
<div class="aspect-square bg-surface-container-lowest overflow-hidden mb-6">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&h=600&fit=crop&crop=center" alt="Architectural lounge chair" />
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Void Lounge Chair</h3>
<p class="text-sm text-on-surface-variant font-body">Powder Coated Steel</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$1,200.00</span>
</div>
<button class="mt-6 w-full py-4 bg-primary text-white font-bold tracking-widest uppercase text-xs hover:bg-primary-container transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 duration-300">
                        Inquire
                    </button>
</div>
<!-- Product 4 -->
<div class="flex flex-col group">
<div class="aspect-square bg-surface-container-lowest overflow-hidden mb-6 relative">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=600&fit=crop&crop=center" alt="Clay bud vases" />
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Triptych Bud Vases</h3>
<p class="text-sm text-on-surface-variant font-body">Hand-sculpted Clay</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$85.00</span>
</div>
</div>
<!-- Product 5 -->
<div class="flex flex-col group">
<div class="aspect-square bg-surface-container-lowest overflow-hidden mb-6">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://images.unsplash.com/photo-1585399363000-c9ffd4e4b308?w=600&h=600&fit=crop&crop=center" alt="Linen throw blanket" />
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Raw Edge Linen Throw</h3>
<p class="text-sm text-on-surface-variant font-body">100% Organic Linen</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$110.00</span>
</div>
</div>
</div>
</section>
<!-- CTA Section -->
<section class="max-w-7xl mx-auto px-8 mt-40">
<div class="bg-primary-container rounded-xl p-12 md:p-20 relative overflow-hidden text-center md:text-left flex flex-col md:flex-row items-center gap-12">
<div class="relative z-10 max-w-2xl">
<span class="text-primary-fixed uppercase tracking-widest font-bold text-xs mb-4 block">Personal Consultation</span>
<h2 class="text-4xl md:text-5xl font-bold text-on-primary-container font-headline mb-6">Create your bespoke living sanctuary</h2>
<p class="text-on-primary-container opacity-80 mb-8 text-lg">Work with our interior curators to select the perfect architectural pieces for your space.</p>
<button class="px-10 py-4 bg-secondary text-white font-bold rounded-lg hover:scale-105 transition-all shadow-lg">Book Studio Tour</button>
</div>
<div class="w-full md:w-1/3 aspect-square rounded-full overflow-hidden border-8 border-white/10 relative z-10">
<img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1494526585095-c41746248156?w=800&h=800&fit=crop&crop=center" alt="Interior designer with blueprints" />
</div>
<!-- Abstract Texture Background -->
<div class="absolute -right-20 -top-20 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
<div class="absolute -left-20 -bottom-20 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
</div>
</section>
</main>
<?php include __DIR__ . '/../components/ui/footer.php'; ?>
</body></html>