<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Atelier Electronics | Mpemba Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;700;800;900&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
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
      .no-scrollbar::-webkit-scrollbar { display: none; }
      .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-surface font-body text-on-surface">
    <?php include __DIR__ . '/../components/ui/navbar.php'; ?>
    <main class="pt-28 pb-20">
        <header class="max-w-7xl mx-auto px-8 mb-16 relative overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-end">
                <div class="md:col-span-7 z-10">
                    <span class="text-secondary font-semibold tracking-widest uppercase text-sm mb-4 block font-label">The Digital Atelier</span>
                    <h1 class="text-6xl md:text-8xl font-black font-display text-primary tracking-tighter leading-none mb-6">Electronics <br/><span class="text-secondary">Refined.</span></h1>
                    <p class="text-lg text-on-surface-variant max-w-lg leading-relaxed font-body">Where precision engineering meets minimalist aesthetic. Curated hardware for the modern high-performance lifestyle.</p>
                </div>
                <div class="md:col-span-5 relative group">
                    <div class="absolute -inset-4 bg-primary/5 rounded-xl blur-2xl group-hover:bg-primary/10 transition-all duration-500"></div>
                    <img class="rounded-xl w-full h-[400px] object-cover relative z-10 shadow-2xl transition-transform duration-700 hover:scale-105" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80" alt="Premium minimalist electronics" />
                </div>
            </div>
        </header>

        <section class="max-w-7xl mx-auto px-8 mb-12">
            <div class="bg-surface-container-low rounded-2xl p-6 flex flex-col md:flex-row gap-6 items-center justify-between">
                <div class="flex flex-wrap gap-3">
                    <button class="px-6 py-2 bg-primary-fixed text-on-primary-fixed rounded-full font-label text-sm flex items-center gap-2">
                        <span>All Categories</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </button>
                    <button class="px-6 py-2 bg-surface-container-highest text-on-surface rounded-full font-label text-sm hover:bg-surface-container-high transition-colors">Connectivity</button>
                    <button class="px-6 py-2 bg-surface-container-highest text-on-surface rounded-full font-label text-sm hover:bg-surface-container-high transition-colors">Acoustics</button>
                    <button class="px-6 py-2 bg-surface-container-highest text-on-surface rounded-full font-label text-sm hover:bg-surface-container-high transition-colors">Smart Home</button>
                    <button class="px-6 py-2 bg-surface-container-highest text-on-surface rounded-full font-label text-sm hover:bg-surface-container-high transition-colors">Wearables</button>
                </div>
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="relative flex-grow md:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span>
                        <input class="w-full pl-10 pr-4 py-2 bg-surface-container-high border-none rounded-xl text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="Search devices..." type="text" />
                    </div>
                    <button class="p-2 bg-surface-container-lowest rounded-xl shadow-sm hover:bg-primary hover:text-white transition-all group">
                        <span class="material-symbols-outlined">tune</span>
                    </button>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 group relative bg-surface-container-lowest rounded-3xl overflow-hidden flex flex-col md:flex-row shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="md:w-1/2 overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1400&q=80" alt="Premium over-ear headphones" />
                    </div>
                    <div class="md:w-1/2 p-10 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold tracking-widest uppercase">Atelier Selection</span>
                                <button class="text-outline hover:text-error transition-colors">
                                    <span class="material-symbols-outlined">favorite</span>
                                </button>
                            </div>
                            <h3 class="text-4xl font-bold font-display text-primary leading-tight mb-4">Aura V2 <br/>Adaptive Headphones</h3>
                            <p class="text-on-surface-variant font-body mb-8">Next-generation sound staging with bio-synthetic driver materials. Designed for pure acoustic fidelity.</p>
                            <div class="space-y-3 mb-8">
                                <div class="flex items-center gap-3 text-sm text-on-surface-variant">
                                    <span class="material-symbols-outlined text-primary text-lg">bolt</span>
                                    <span>60hr Active Battery Life</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-on-surface-variant">
                                    <span class="material-symbols-outlined text-primary text-lg">noise_control_off</span>
                                    <span>Hybrid Passive Isolation</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-surface-container-low pt-6">
                            <span class="text-3xl font-black text-primary font-display">$449.00</span>
                            <button class="bg-secondary px-8 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform shadow-lg shadow-secondary/20">Pre-Order</button>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-3xl p-8 flex flex-col group shadow-sm hover:shadow-xl transition-all duration-500" data-id="5" data-name="Core Hub Ultra" data-price="299" data-image="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80">
                    <div class="relative mb-8 h-64 rounded-2xl overflow-hidden bg-surface-container-low">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80" alt="Smart home hub" />
                        <button class="absolute top-4 right-4 bg-white/80 backdrop-blur-md p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-primary">add_circle</span>
                        </button>
                    </div>
                    <div class="flex-grow">
                        <span class="text-xs font-bold uppercase tracking-widest text-outline mb-2 block">Smart Home</span>
                        <h4 class="text-2xl font-bold text-primary font-display mb-4">Core Hub Ultra</h4>
                        <p class="text-sm text-on-surface-variant leading-relaxed mb-6">Centralize your entire digital atelier with zero-latency thread connectivity and localized AI processing.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-black text-primary font-display">$299.00</span>
                        <button class="p-3 bg-primary text-white rounded-xl hover:bg-primary-container transition-colors">
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </button>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-3xl p-8 flex flex-col group shadow-sm hover:shadow-xl transition-all duration-500" data-id="6" data-name="Pulse Pro Band" data-price="189" data-image="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80">
                    <div class="relative mb-8 h-64 rounded-2xl overflow-hidden bg-surface-container-low">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80" alt="Wearable device" />
                        <button class="absolute top-4 right-4 bg-white/80 backdrop-blur-md p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-primary">add_circle</span>
                        </button>
                    </div>
                    <div class="flex-grow">
                        <span class="text-xs font-bold uppercase tracking-widest text-outline mb-2 block">Wearables</span>
                        <h4 class="text-2xl font-bold text-primary font-display mb-4">Pulse Pro Band</h4>
                        <p class="text-sm text-on-surface-variant leading-relaxed mb-6">High-precision bio-sensors encased in aerospace-grade titanium. The future of performance monitoring.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-black text-primary font-display">$189.00</span>
                        <button class="p-3 bg-primary text-white rounded-xl hover:bg-primary-container transition-colors">
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-primary p-12 rounded-3xl text-white flex flex-col md:flex-row items-center gap-12 overflow-hidden relative group">
                    <div class="absolute right-0 top-0 w-64 h-64 bg-primary-container/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10 space-y-6 md:w-2/3">
                        <h3 class="text-4xl font-bold font-display tracking-tight leading-tight">Can't decide on your <br/>tech ecosystem?</h3>
                        <p class="text-primary-fixed-dim text-lg leading-relaxed">Our Atelier Comparison Tool allows you to analyze technical specs side-by-side. From chipset architecture to tactile feedback profiles.</p>
                        <button class="bg-white text-primary px-10 py-4 rounded-xl font-black tracking-tight hover:scale-105 transition-transform shadow-2xl">Compare 0/3 Devices</button>
                    </div>
                    <div class="relative md:w-1/3 flex gap-4">
                        <div class="w-32 h-48 bg-white/10 backdrop-blur-xl rounded-2xl border border-white/5 rotate-[-5deg] flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl opacity-50">developer_board</span>
                        </div>
                        <div class="w-32 h-48 bg-white/20 backdrop-blur-xl rounded-2xl border border-white/10 rotate-[5deg] -ml-12 mt-8 flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl opacity-50">memory</span>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-3xl p-8 flex flex-col group shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative mb-8 h-64 rounded-2xl overflow-hidden bg-surface-container-low">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80" alt="Desktop speakers" />
                        <button class="absolute top-4 right-4 bg-white/80 backdrop-blur-md p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-primary">add_circle</span>
                        </button>
                    </div>
                    <div class="flex-grow">
                        <span class="text-xs font-bold uppercase tracking-widest text-outline mb-2 block">Acoustics</span>
                        <h4 class="text-2xl font-bold text-primary font-display mb-4">Sonic Array 5</h4>
                        <p class="text-sm text-on-surface-variant leading-relaxed mb-6">Omni-directional desktop acoustics with carbon fiber weave transducers for distortion-free highs.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-black text-primary font-display">$650.00</span>
                        <button class="p-3 bg-primary text-white rounded-xl hover:bg-primary-container transition-colors">
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-8 mt-24">
            <div class="bg-surface-container-high rounded-[3rem] p-16 text-center">
                <h2 class="text-4xl md:text-5xl font-black font-display text-primary mb-6 tracking-tight">Stay synchronized.</h2>
                <p class="text-on-surface-variant max-w-xl mx-auto mb-10 text-lg">Receive exclusive early access to the Digital Atelier's next hardware drop and firmware insights.</p>
                <div class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto">
                    <input class="flex-grow bg-white border-none px-8 py-4 rounded-2xl focus:ring-2 focus:ring-primary" placeholder="Your work email" type="email" />
                    <button class="bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primary-container transition-all">Join Waitlist</button>
                </div>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../components/ui/footer.php'; ?>
</body>
</html>
