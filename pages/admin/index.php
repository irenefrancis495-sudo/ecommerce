<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Mpemba Admin | Marketplace Controller</title>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&amp;family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-secondary": "#ffffff",
                    "surface-container": "#edeef0",
                    "on-error-container": "#93000a",
                    "tertiary": "#705d00",
                    "secondary-container": "#ffa454",
                    "surface-variant": "#e1e2e5",
                    "on-secondary-fixed-variant": "#6e3900",
                    "on-background": "#191c1e",
                    "tertiary-fixed-dim": "#e9c400",
                    "outline-variant": "#c0c7cd",
                    "surface-dim": "#d9dadc",
                    "error-container": "#ffdad6",
                    "on-primary-fixed-variant": "#044d65",
                    "primary-container": "#004b63",
                    "surface": "#f8f9fb",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary": "#ffffff",
                    "on-tertiary-fixed": "#221b00",
                    "surface-container-low": "#f2f4f6",
                    "on-secondary-container": "#713b00",
                    "inverse-surface": "#2e3133",
                    "on-primary-container": "#83bad6",
                    "on-error": "#ffffff",
                    "tertiary-fixed": "#ffe16d",
                    "on-tertiary-container": "#4c3f00",
                    "primary-fixed-dim": "#96ceeb",
                    "tertiary-container": "#c9a900",
                    "inverse-on-surface": "#f0f1f3",
                    "primary-fixed": "#bfe8ff",
                    "surface-tint": "#2a657e",
                    "primary": "#003345",
                    "error": "#ba1a1a",
                    "on-primary": "#ffffff",
                    "surface-container-high": "#e7e8ea",
                    "secondary-fixed-dim": "#ffb77d",
                    "on-surface": "#191c1e",
                    "secondary": "#904d00",
                    "on-secondary-fixed": "#2f1500",
                    "surface-bright": "#f8f9fb",
                    "on-primary-fixed": "#001f2b",
                    "secondary-fixed": "#ffdcc3",
                    "surface-container-highest": "#e1e2e5",
                    "on-surface-variant": "#40484c",
                    "background": "#f8f9fb",
                    "outline": "#71787d",
                    "inverse-primary": "#96ceeb",
                    "on-tertiary-fixed-variant": "#544600"
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
          }
        }
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .editorial-shadow {
            box-shadow: 0 32px 64px -12px rgba(25, 28, 30, 0.06);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">
<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 z-50 flex flex-col py-6 bg-slate-50 dark:bg-slate-950 font-epilogue font-bold text-sm tracking-tight">
<div class="px-6 mb-10 flex items-center gap-3">
<div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-on-primary">
<span class="material-symbols-outlined text-lg" data-icon="token">token</span>
</div>
<span class="text-xl font-bold font-epilogue text-cyan-950 dark:text-cyan-50">Mpemba Admin</span>
</div>
<nav class="flex-1 px-4 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 text-cyan-900 dark:text-cyan-50 font-bold border-r-4 border-cyan-800 dark:border-cyan-400 bg-slate-200/50 dark:bg-slate-800/50 transition-transform duration-300 scale-102" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                Dashboard
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                Inventory
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
                Orders
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="storefront">storefront</span>
                Vendors
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="query_stats">query_stats</span>
                Analytics
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
                Settings
            </a>
</nav>
<div class="px-6 pt-6 mt-auto bg-slate-100/50 dark:bg-slate-900/50 py-4 flex items-center gap-3">
<img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" data-alt="Professional portrait of a corporate executive in a sharp navy suit against a clean studio background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDZMFkawvOdjm2eveazvakP_D3FvzKnv0zI-0D4gXnBlAqkIRjy3rYthInGdtsqUS0YHKklcnYIBxWlLcO09MSuzg2FAEAvrW0LIC15_J5ZcFp4eJ2dpVpiPDX54s8kkbubYJn4vWT8EH51pJ7ZLIsTDqJPS45jgztmmTL94t_dh7CQY9yxzYqvzIdxctQ41aRFBZFBlZwS6OyESC0JqLlINRvIaCVT0YEllp91sGwvLBxsNHIS5_IMgBRv8PoLyrbRtxRw_g-JneE"/>
<div class="overflow-hidden">
<p class="text-xs font-bold truncate">Admin Avatar</p>
<p class="text-[10px] text-slate-500 truncate">Marketplace Controller</p>
</div>
</div>
</aside>
<!-- Main Content Canvas -->
<main class="ml-64 min-h-screen relative">
<!-- TopNavBar Component -->
<header class="sticky top-0 w-full z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl flex items-center justify-between px-8 py-4 border-b border-slate-200/10 shadow-sm shadow-slate-200/50 dark:shadow-none">
<div class="flex items-center gap-6 w-1/2">
<div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-cyan-800 transition-all rounded-full overflow-hidden">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
<input class="w-full pl-12 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none text-sm focus:ring-0" placeholder="Search analytics or orders..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="p-2 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="p-2 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all">
<span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
</button>
<div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700 mx-2"></div>
<div class="flex items-center gap-3">
<span class="font-manrope text-sm font-semibold text-cyan-900 dark:text-cyan-100">Administrator</span>
<img alt="Administrator Profile" class="w-8 h-8 rounded-full" data-alt="Close up portrait of a senior system administrator with a confident expression in a bright modern office" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRQSQxSDmwNnBk2a8IqCD_apFRr3w-U9wbPszOBlPALNCvA1EnykTTm4OXKMWxAfPbKDCzZavyOUoNG8eVZpNIX9L-uT6cwC_TQNUxUOtAyv9P8iAWwvxHrkDZhZHO_UdRtBNa2DhrPU8TF-IuerV4aZXB_xy2yP3fjKDKs0L-Qze-aF5ihWqH3yhxYb50mX_UAmM_V2dO3bTdQnm7XMKUINPe_pm3XHGMvzIyDmGPNaxie0ou7JveKzajbWCK1kPmUhvtHsc39X0"/>
</div>
</div>
</header>
<section class="p-8 space-y-12 max-w-7xl mx-auto">
<!-- Dashboard Header -->
<div class="flex items-end justify-between">
<div>
<span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">System Overview</span>
<h1 class="text-4xl font-black font-display text-primary leading-tight">Dashboard Overview</h1>
</div>
<div class="flex gap-4">
<button class="px-6 py-3 bg-primary text-on-primary rounded-lg text-sm font-bold flex items-center gap-2 transition-transform hover:scale-102">
<span class="material-symbols-outlined text-sm">download</span>
                        Export Report
                    </button>
<button class="px-6 py-3 bg-gradient-to-r from-secondary to-secondary-container text-on-secondary rounded-lg text-sm font-bold shadow-lg shadow-secondary/20 transition-transform hover:scale-102">
<span class="material-symbols-outlined text-sm">add</span>
                        New Product
                    </button>
</div>
</div>
<!-- Summary Bento Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Total Sales -->
<div class="bg-surface-container-lowest p-8 rounded-xl editorial-shadow relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-6xl" data-icon="payments">payments</span>
</div>
<p class="text-sm font-medium text-outline mb-1">Total Sales</p>
<h3 class="text-3xl font-black font-display text-primary">$1,284,590</h3>
<div class="mt-4 flex items-center gap-2 text-xs font-bold text-green-600">
<span class="material-symbols-outlined text-sm">trending_up</span>
                        +12.5% vs last month
                    </div>
</div>
<!-- New Orders -->
<div class="bg-surface-container-lowest p-8 rounded-xl editorial-shadow relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-6xl" data-icon="local_shipping">local_shipping</span>
</div>
<p class="text-sm font-medium text-outline mb-1">New Orders</p>
<h3 class="text-3xl font-black font-display text-primary">1,482</h3>
<div class="mt-4 flex items-center gap-2 text-xs font-bold text-green-600">
<span class="material-symbols-outlined text-sm">trending_up</span>
                        +8.2% since yesterday
                    </div>
</div>
<!-- Active Vendors -->
<div class="bg-surface-container-lowest p-8 rounded-xl editorial-shadow relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-6xl" data-icon="handshake">handshake</span>
</div>
<p class="text-sm font-medium text-outline mb-1">Active Vendors</p>
<h3 class="text-3xl font-black font-display text-primary">456</h3>
<div class="mt-4 flex items-center gap-2 text-xs font-bold text-secondary">
<span class="material-symbols-outlined text-sm">person_add</span>
                        24 pending approval
                    </div>
</div>
</div>
<!-- Main Analytics & Activity Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
<!-- Growth Chart (Asymmetric Composition) -->
<div class="lg:col-span-2 bg-surface-container-low rounded-2xl p-10">
<div class="flex items-center justify-between mb-10">
<h2 class="text-2xl font-black font-display text-primary">Sales Growth Performance</h2>
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-secondary"></span>
<span class="text-xs font-bold text-on-surface-variant">Last 30 Days</span>
</div>
</div>
<div class="h-64 flex items-end justify-between gap-2 relative">
<!-- Simplified illustrative chart bars -->
<div class="w-full bg-surface-container-highest rounded-t-lg h-[40%] hover:bg-secondary transition-all"></div>
<div class="w-full bg-surface-container-highest rounded-t-lg h-[65%] hover:bg-secondary transition-all"></div>
<div class="w-full bg-surface-container-highest rounded-t-lg h-[55%] hover:bg-secondary transition-all"></div>
<div class="w-full bg-secondary rounded-t-lg h-[90%] transition-all"></div>
<div class="w-full bg-surface-container-highest rounded-t-lg h-[75%] hover:bg-secondary transition-all"></div>
<div class="w-full bg-surface-container-highest rounded-t-lg h-[60%] hover:bg-secondary transition-all"></div>
<div class="w-full bg-surface-container-highest rounded-t-lg h-[85%] hover:bg-secondary transition-all"></div>
<div class="w-full bg-surface-container-highest rounded-t-lg h-[50%] hover:bg-secondary transition-all"></div>
<div class="w-full bg-surface-container-highest rounded-t-lg h-[70%] hover:bg-secondary transition-all"></div>
<div class="w-full bg-primary rounded-t-lg h-[100%] transition-all"></div>
<!-- Overlay Trend Line (SVG) -->
<svg class="absolute inset-0 w-full h-full pointer-events-none" preserveaspectratio="none" viewbox="0 0 1000 100">
<path d="M0,80 Q250,20 500,50 T1000,10" fill="none" stroke="#904d00" stroke-dasharray="8 4" stroke-width="2"></path>
</svg>
</div>
<div class="grid grid-cols-5 mt-4 text-[10px] font-bold text-outline text-center uppercase tracking-widest">
<span>Week 1</span>
<span>Week 2</span>
<span>Week 3</span>
<span>Week 4</span>
<span>Current</span>
</div>
</div>
<!-- Recent Activity (Editorial Feed) -->
<div class="space-y-6">
<h2 class="text-2xl font-black font-display text-primary">Recent Activity</h2>
<div class="space-y-0 relative">
<!-- Timeline Line -->
<div class="absolute left-6 top-4 bottom-4 w-[1px] bg-surface-container-highest"></div>
<!-- Activity Items -->
<div class="relative pl-14 pb-8 group">
<div class="absolute left-4 top-1 w-4 h-4 rounded-full border-2 border-secondary bg-surface transition-colors group-hover:bg-secondary"></div>
<div class="p-5 bg-surface-container-lowest rounded-xl editorial-shadow">
<p class="text-xs text-outline font-bold mb-1">2 MINUTES AGO</p>
<p class="text-sm font-bold text-primary">New Vendor Application</p>
<p class="text-sm text-on-surface-variant">Artisan Ceramics Ltd. applied for storefront access.</p>
<div class="mt-3 flex gap-2">
<button class="text-[10px] font-bold uppercase tracking-tighter text-primary bg-primary-fixed px-3 py-1 rounded-full">Review</button>
</div>
</div>
</div>
<div class="relative pl-14 pb-8 group">
<div class="absolute left-4 top-1 w-4 h-4 rounded-full border-2 border-primary bg-surface transition-colors group-hover:bg-primary"></div>
<div class="p-5 bg-surface-container-lowest rounded-xl editorial-shadow">
<p class="text-xs text-outline font-bold mb-1">1 HOUR AGO</p>
<p class="text-sm font-bold text-primary">High Value Order #8921</p>
<p class="text-sm text-on-surface-variant">Bulk order processed: $12,400.00 by Corporate Gifting.</p>
</div>
</div>
<div class="relative pl-14 group">
<div class="absolute left-4 top-1 w-4 h-4 rounded-full border-2 border-outline bg-surface transition-colors group-hover:bg-outline"></div>
<div class="p-5 bg-surface-container-lowest rounded-xl editorial-shadow">
<p class="text-xs text-outline font-bold mb-1">4 HOURS AGO</p>
<p class="text-sm font-bold text-primary">Inventory Alert</p>
<p class="text-sm text-on-surface-variant">5 items are below safety stock levels in "Home &amp; Living".</p>
</div>
</div>
</div>
<button class="w-full py-4 text-sm font-bold text-primary border border-primary/10 rounded-xl hover:bg-primary/5 transition-colors">
                        View Audit Log
                    </button>
</div>
</div>
<!-- Secondary Focus Section -->
<div class="bg-primary-container p-12 rounded-3xl overflow-hidden relative">
<div class="absolute top-0 right-0 w-1/3 h-full overflow-hidden opacity-20">
<img class="w-full h-full object-cover grayscale" data-alt="Monochrome overhead view of a diverse group of professionals collaborating around a large wooden table in a high-end office" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPR1uuVR9MU0_2jUtc_Psr9RuQXyLAH3zU_Q0tQASuJ75I2X08tgkA5PGBG1sRa-D0QlaUSwEoX2bsnI0O3CU_1amtfNV9pyT9owF_33_EAO8XWlUCZTFDvXVstv14kenIyh6ID84cLeQhmo-S7UKUt-PB2Bw71T8yQesw0-gh1Y4Tajf07kMFIN9GtYUWyGhaXtfqLNU6uaN6CXeU-X9TiA8v2QCMUTTzcVT6sB5ORawfFeEg1dNkjAEOj4g3HCVIH_xOiXbrjlM"/>
</div>
<div class="relative z-10 max-w-xl">
<h3 class="text-3xl font-black font-display text-primary mb-4 leading-tight">Strategic Market Insights</h3>
<p class="text-on-primary-container mb-8 font-medium">Your marketplace reached a new milestone in customer retention this week. Review the quarterly expansion plan for upcoming regional vendor onboarding.</p>
<a class="inline-flex items-center gap-3 text-primary font-bold hover:gap-5 transition-all" href="#">
                        Deep Dive into Analytics
                        <span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
</div>
</section>
</main>
</body></html>
      <div class="panel">
        <h2>Top Selling</h2>
        <ul class="list">
          <?php foreach ($top as $t): ?>
          <li>
            <img src="<?php echo $t['img']; ?>" alt=""/>
            <div><?php echo htmlspecialchars($t['name']); ?></div>
            <div class="muted"><?php echo (int)$t['qty']; ?></div>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>

    <section class="panel">
      <h2>Recent Orders</h2>
      <table class="table">
        <thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
          <tr>
            <td><?php echo $o['id']; ?></td>
            <td><?php echo htmlspecialchars($o['customer']); ?></td>
            <td>$<?php echo number_format($o['total'],2); ?></td>
            <td><?php echo htmlspecialchars($o['status']); ?></td>
            <td><?php echo htmlspecialchars($o['date']); ?></td>
            <td><a href="orders.php?id=<?php echo $o['id']; ?>" class="link">View</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

  </div>
  <script>window.__ADMIN_API = '/Mpemba/api/admin_data.php';</script>
</body>
</html>
