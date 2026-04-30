<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Mpemba Admin - Orders List</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&amp;family=Manrope:wght@400;500;600;700&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
                },
            },
        }
    </script>
<style>
        body { font-family: 'Manrope', sans-serif; }
        h1, h2, h3 { font-family: 'Epilogue', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface">
<!-- Sidebar Navigation -->
<aside class="h-screen w-64 fixed left-0 top-0 z-50 bg-slate-50 dark:bg-slate-950 flex flex-col py-6">
<div class="px-6 mb-10 flex items-center gap-3">
<div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined text-white text-lg">shopping_bag</span>
</div>
<div>
<h1 class="text-xl font-bold font-epilogue text-cyan-950 dark:text-cyan-50">Mpemba Admin</h1>
<p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Marketplace Controller</p>
</div>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">inventory_2</span>
<span>Inventory</span>
</a>
<a class="flex items-center px-6 py-3 space-x-3 text-cyan-900 dark:text-cyan-50 font-bold border-r-4 border-cyan-800 dark:border-cyan-400 bg-slate-200/50 dark:bg-slate-800/50 font-epilogue text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">shopping_cart</span>
<span>Orders</span>
</a>
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">storefront</span>
<span>Vendors</span>
</a>
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">query_stats</span>
<span>Analytics</span>
</a>
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">settings</span>
<span>Settings</span>
</a>
</nav>
<div class="mt-auto px-6 pt-6">
<div class="p-4 rounded-xl bg-primary-container/10 border border-primary-container/5">
<div class="flex items-center gap-3">
<img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?w=80&h=80&fit=crop&crop=center" />
<div>
<p class="text-xs font-bold text-cyan-950">Sarah Jenkins</p>
<p class="text-[10px] text-cyan-800 opacity-70 uppercase tracking-tighter">Chief Controller</p>
</div>
</div>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="ml-64 min-h-screen">
<!-- Top Navigation Bar -->
<header class="sticky top-0 w-full z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl flex items-center justify-between px-8 py-4 shadow-sm shadow-slate-200/50 dark:shadow-none">
<div class="flex items-center flex-1">
<div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-cyan-800 transition-all rounded-full bg-slate-100 dark:bg-slate-800">
<span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<span class="material-symbols-outlined text-slate-400">search</span>
</span>
<input class="block w-full pl-10 pr-3 py-2 border-none bg-transparent rounded-full font-manrope text-sm focus:ring-0 text-cyan-900 placeholder-slate-400" placeholder="Search orders, transactions, or IDs..." type="text"/>
</div>
</div>
<div class="flex items-center space-x-6 text-slate-600 dark:text-slate-400">
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all">
<span class="material-symbols-outlined">help_outline</span>
</button>
<div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700"></div>
<div class="flex items-center gap-3">
<span class="text-sm font-semibold font-manrope text-cyan-900 dark:text-cyan-100">Mpemba Marketplace</span>
<span class="material-symbols-outlined text-2xl">account_circle</span>
</div>
</div>
</header>
<!-- Orders View Content -->
<div class="p-8">
<div class="flex justify-between items-end mb-8">
<div>
<nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 gap-2">
<span>Main Hub</span>
<span>/</span>
<span class="text-primary">Order Management</span>
</nav>
<h2 class="text-4xl font-black font-epilogue text-primary tracking-tight">Orders Registry</h2>
</div>
<div class="flex gap-4">
<button class="bg-surface-container-high hover:bg-surface-container-highest transition-all px-6 py-2.5 rounded-lg text-sm font-bold flex items-center gap-2">
<span class="material-symbols-outlined text-lg">download</span>
                        Export Data
                    </button>
<button class="bg-primary text-on-primary hover:scale-102 transition-all px-6 py-2.5 rounded-lg text-sm font-bold flex items-center gap-2 shadow-lg shadow-primary/20">
<span class="material-symbols-outlined text-lg">add</span>
                        Manual Order
                    </button>
</div>
</div>
<!-- Dashboard Mini-Stats (Bento Style) -->
<div class="grid grid-cols-4 gap-6 mb-12">
<div class="p-6 bg-surface-container-lowest rounded-xl shadow-sm">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary/5 rounded-lg text-primary">
<span class="material-symbols-outlined">monetization_on</span>
</div>
<span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">+12.5%</span>
</div>
<p class="text-sm font-bold text-slate-400 mb-1">Weekly Revenue</p>
<h3 class="text-2xl font-black text-primary">$124,592.00</h3>
</div>
<div class="p-6 bg-surface-container-lowest rounded-xl shadow-sm">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-secondary/5 rounded-lg text-secondary">
<span class="material-symbols-outlined">orders</span>
</div>
<span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded">Processing</span>
</div>
<p class="text-sm font-bold text-slate-400 mb-1">Active Orders</p>
<h3 class="text-2xl font-black text-primary">1,240</h3>
</div>
<div class="p-6 bg-surface-container-lowest rounded-xl shadow-sm">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary-container/10 rounded-lg text-primary-container">
<span class="material-symbols-outlined">local_shipping</span>
</div>
<span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">In Transit</span>
</div>
<p class="text-sm font-bold text-slate-400 mb-1">Shipping Log</p>
<h3 class="text-2xl font-black text-primary">84</h3>
</div>
<div class="p-6 bg-surface-container-lowest rounded-xl shadow-sm">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-error/5 rounded-lg text-error">
<span class="material-symbols-outlined">error</span>
</div>
<span class="text-[10px] font-bold text-error bg-error-container/20 px-2 py-1 rounded">Urgent</span>
</div>
<p class="text-sm font-bold text-slate-400 mb-1">Disputes</p>
<h3 class="text-2xl font-black text-primary">12</h3>
</div>
</div>
<!-- Filters Area -->
<div class="flex items-center justify-between mb-6">
<div class="flex items-center gap-3">
<button class="bg-primary text-on-primary-fixed rounded-full px-4 py-2 text-xs font-bold flex items-center gap-2">
                        All Orders
                        <span class="bg-white/20 px-1.5 rounded">342</span>
</button>
<button class="bg-surface-container-high rounded-full px-4 py-2 text-xs font-bold flex items-center gap-2">
                        Pending
                    </button>
<button class="bg-surface-container-high rounded-full px-4 py-2 text-xs font-bold flex items-center gap-2">
                        Shipped
                    </button>
<button class="bg-surface-container-high rounded-full px-4 py-2 text-xs font-bold flex items-center gap-2">
                        Delivered
                    </button>
</div>
<div class="flex items-center gap-4">
<button class="p-2 rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined">filter_list</span>
</button>
<button class="p-2 rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined">calendar_today</span>
</button>
</div>
</div>
<!-- Main Table Grid -->
<div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
<table class="w-full text-left">
<thead>
<tr class="bg-surface-container-low text-[10px] font-black uppercase tracking-[0.15em] text-slate-500">
<th class="px-8 py-5">Order ID</th>
<th class="px-8 py-5">Customer Name</th>
<th class="px-8 py-5">Date</th>
<th class="px-8 py-5 text-right">Amount</th>
<th class="px-8 py-5">Order Status</th>
<th class="px-8 py-5 text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container">
<!-- Row 1 -->
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-8 py-6 font-epilogue font-bold text-primary">#MP-98231</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xs text-slate-500">EH</div>
<span class="font-semibold text-sm text-cyan-950">Evelyn Harper</span>
</div>
</td>
<td class="px-8 py-6 text-sm text-slate-500">Oct 24, 2023, 14:20</td>
<td class="px-8 py-6 text-right font-bold text-primary">$1,240.00</td>
<td class="px-8 py-6">
<span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-emerald-100 text-emerald-800">Delivered</span>
</td>
<td class="px-8 py-6 text-right">
<button class="opacity-0 group-hover:opacity-100 p-2 hover:bg-slate-200 rounded-lg transition-all">
<span class="material-symbols-outlined text-slate-400">more_horiz</span>
</button>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-8 py-6 font-epilogue font-bold text-primary">#MP-98229</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xs text-slate-500">MR</div>
<span class="font-semibold text-sm text-cyan-950">Marcus Reed</span>
</div>
</td>
<td class="px-8 py-6 text-sm text-slate-500">Oct 24, 2023, 11:05</td>
<td class="px-8 py-6 text-right font-bold text-primary">$450.50</td>
<td class="px-8 py-6">
<span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-amber-100 text-amber-800">Shipped</span>
</td>
<td class="px-8 py-6 text-right">
<button class="opacity-0 group-hover:opacity-100 p-2 hover:bg-slate-200 rounded-lg transition-all">
<span class="material-symbols-outlined text-slate-400">more_horiz</span>
</button>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-8 py-6 font-epilogue font-bold text-primary">#MP-98225</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xs text-slate-500">SJ</div>
<span class="font-semibold text-sm text-cyan-950">Sarah Jenkins</span>
</div>
</td>
<td class="px-8 py-6 text-sm text-slate-500">Oct 23, 2023, 23:58</td>
<td class="px-8 py-6 text-right font-bold text-primary">$89.99</td>
<td class="px-8 py-6">
<span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-slate-200 text-slate-600">Pending</span>
</td>
<td class="px-8 py-6 text-right">
<button class="opacity-0 group-hover:opacity-100 p-2 hover:bg-slate-200 rounded-lg transition-all">
<span class="material-symbols-outlined text-slate-400">more_horiz</span>
</button>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-8 py-6 font-epilogue font-bold text-primary">#MP-98224</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xs text-slate-500">DT</div>
<span class="font-semibold text-sm text-cyan-950">David Thompson</span>
</div>
</td>
<td class="px-8 py-6 text-sm text-slate-500">Oct 23, 2023, 21:12</td>
<td class="px-8 py-6 text-right font-bold text-primary">$2,100.00</td>
<td class="px-8 py-6">
<span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-amber-100 text-amber-800">Shipped</span>
</td>
<td class="px-8 py-6 text-right">
<button class="opacity-0 group-hover:opacity-100 p-2 hover:bg-slate-200 rounded-lg transition-all">
<span class="material-symbols-outlined text-slate-400">more_horiz</span>
</button>
</td>
</tr>
<!-- Row 5 -->
<tr class="hover:bg-slate-50/50 transition-colors group">
<td class="px-8 py-6 font-epilogue font-bold text-primary">#MP-98221</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xs text-slate-500">LW</div>
<span class="font-semibold text-sm text-cyan-950">Lucas Wright</span>
</div>
</td>
<td class="px-8 py-6 text-sm text-slate-500">Oct 23, 2023, 19:45</td>
<td class="px-8 py-6 text-right font-bold text-primary">$315.20</td>
<td class="px-8 py-6">
<span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-emerald-100 text-emerald-800">Delivered</span>
</td>
<td class="px-8 py-6 text-right">
<button class="opacity-0 group-hover:opacity-100 p-2 hover:bg-slate-200 rounded-lg transition-all">
<span class="material-symbols-outlined text-slate-400">more_horiz</span>
</button>
</td>
</tr>
</tbody>
</table>
<!-- Pagination -->
<div class="px-8 py-6 bg-slate-50/50 flex items-center justify-between border-t border-slate-100">
<p class="text-xs font-bold text-slate-400">Showing 1 to 5 of 342 entries</p>
<div class="flex gap-2">
<button class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-container-lowest text-slate-400 hover:bg-slate-200 transition-colors">
<span class="material-symbols-outlined text-lg">chevron_left</span>
</button>
<button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white text-xs font-bold">1</button>
<button class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-container-lowest text-slate-600 hover:bg-slate-200 transition-colors text-xs font-bold">2</button>
<button class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-container-lowest text-slate-600 hover:bg-slate-200 transition-colors text-xs font-bold">3</button>
<button class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-container-lowest text-slate-400 hover:bg-slate-200 transition-colors">
<span class="material-symbols-outlined text-lg">chevron_right</span>
</button>
</div>
</div>
</div>
</div>
</main>
<!-- Floating Background Decor for Digital Atelier Feel -->
<div class="fixed bottom-0 right-0 -z-10 opacity-5 pointer-events-none">
<h1 class="text-[20vw] font-black font-epilogue leading-none tracking-tighter text-primary">ORDERS</h1>
</div>
</body></html>
