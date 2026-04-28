<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Mpemba Marketplace | Inventory Management</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700;800;900&amp;family=Manrope:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Manrope', sans-serif;
            background-color: #f8f9fb;
        }
        h1, h2, h3 {
            font-family: 'Epilogue', sans-serif;
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
<!-- SideNavBar Shell -->
<aside class="h-screen w-64 fixed left-0 top-0 z-50 bg-slate-50 dark:bg-slate-950 flex flex-col py-6">
<div class="px-6 mb-10">
<h2 class="text-xl font-bold font-epilogue text-cyan-950 dark:text-cyan-50">Mpemba Admin</h2>
<p class="text-xs text-slate-500 font-manrope">Marketplace Controller</p>
</div>
<nav class="flex-1 space-y-1">
<!-- Dashboard (Inactive) -->
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<!-- Inventory (Active) -->
<a class="flex items-center px-6 py-3 space-x-3 text-cyan-900 dark:text-cyan-50 font-bold border-r-4 border-cyan-800 dark:border-cyan-400 bg-slate-200/50 dark:bg-slate-800/50 font-epilogue text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">inventory_2</span>
<span>Inventory</span>
</a>
<!-- Orders (Inactive) -->
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">shopping_cart</span>
<span>Orders</span>
</a>
<!-- Vendors (Inactive) -->
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">storefront</span>
<span>Vendors</span>
</a>
<!-- Analytics (Inactive) -->
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">query_stats</span>
<span>Analytics</span>
</a>
<!-- Settings (Inactive) -->
<a class="flex items-center px-6 py-3 space-x-3 text-slate-500 dark:text-slate-400 hover:text-cyan-900 dark:hover:text-cyan-100 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200 font-epilogue font-bold text-sm tracking-tight" href="#">
<span class="material-symbols-outlined">settings</span>
<span>Settings</span>
</a>
</nav>
<div class="px-6 mt-auto">
<div class="flex items-center space-x-3 p-3 bg-slate-100/50 dark:bg-slate-900/50 rounded-xl">
<img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" data-alt="professional portrait of a confident businessman in a tailored suit against a minimalist studio background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB9a-AnBbm3YyWflSrQjWFSNBzuUq596D134EE1LIqkvTGzMp00I-l0jH3rh9LBbNcqmbKyUky0WAnG0xnUNCRjIcAkmLwGxhQAD8iQKGm9tdZHeqlSaNWZ8jbMDPIUmLCyPz6SzCBT_8lXtf2vmDLDGXSBeYTkZ_OQVJGK5Vz4MCtoz460yuw6ECXGzO-oalPP683ybJQwDa0moizo6A_bYgURZtNrfZvFtwIup3CCfd80xFwBytVOy5GWv1hAM3MwS6m9anDn5O4"/>
<div>
<p class="text-xs font-bold text-cyan-950 dark:text-white font-epilogue">Alex Mpemba</p>
<p class="text-[10px] text-slate-500 font-manrope">System Admin</p>
</div>
</div>
</div>
</aside>
<!-- TopNavBar Shell -->
<header class="sticky top-0 w-full z-40 ml-64 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/10">
<div class="flex items-center justify-between px-8 py-4 max-w-[calc(100%-16rem)]">
<div class="flex items-center flex-1 max-w-xl">
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
<input class="w-full pl-10 pr-4 py-2 bg-surface-container-high border-none rounded-full text-sm font-manrope focus:ring-2 focus:ring-primary transition-all" placeholder="Search marketplace..." type="text"/>
</div>
</div>
<div class="flex items-center space-x-6 ml-8">
<button class="relative p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-secondary rounded-full"></span>
</button>
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined">help_outline</span>
</button>
<div class="w-8 h-8 rounded-full overflow-hidden">
<img alt="Administrator Profile" class="w-full h-full object-cover" data-alt="close up headshot of a professional administrator with a warm and approachable expression" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAv1yCZrUyThevx4WHxsrufAW4VpU871NcoCvB6R5mcBKSGJI6w2IhxLDtDWBbXGyLJzzJf9Ag60ElPOrCHiDNM6WQiIdWtwiH_3hfRS2ELdPXZmh83QZlOUhNFLBwo8lAwiaTLN2e2hjv9VWEm_yRFshcI8hFdnZsOe8vDrR2H3fB-0IfWfgfPEfbnod6ZrMLwNCDKz7gfcglNBcZnyLRhixVBy41jDOY5DdF_w5upglPvV1MDCFdE7zyOWMlFh7PvUyT7170yayo"/>
</div>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="ml-64 p-8 min-h-screen">
<!-- Inventory Header Composition -->
<section class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
<div class="max-w-2xl">
<span class="text-secondary font-bold tracking-widest text-[10px] uppercase font-label">Stock Control</span>
<h1 class="text-4xl font-extrabold font-headline tracking-tighter text-primary mt-2">Inventory Assets</h1>
<p class="text-on-surface-variant font-body mt-2 leading-relaxed">Oversee and curate your marketplace offerings. Monitor stock levels, pricing strategies, and product visibility across global regions.</p>
</div>
<div class="flex items-center gap-3">
<button class="flex items-center space-x-2 px-6 py-3 bg-surface-container-high hover:bg-surface-container-highest text-primary font-bold rounded-xl transition-all font-label scale-100 hover:scale-[1.02]">
<span class="material-symbols-outlined text-sm">filter_list</span>
<span>Filters</span>
</button>
<button class="flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-secondary to-secondary-container text-on-secondary font-bold rounded-xl shadow-lg shadow-secondary/20 hover:scale-[1.03] active:scale-[0.98] transition-all font-label">
<span class="material-symbols-outlined">add</span>
<span>Add Product</span>
</button>
</div>
</section>
<!-- Stats Bento Grid (Visual Interest) -->
<section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm flex flex-col justify-between">
<span class="material-symbols-outlined text-primary-container p-2 bg-primary-fixed rounded-lg self-start">inventory</span>
<div>
<h3 class="text-3xl font-bold font-headline text-primary mt-4">1,402</h3>
<p class="text-xs text-on-surface-variant font-body">Total SKUs Active</p>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm flex flex-col justify-between">
<span class="material-symbols-outlined text-error p-2 bg-error-container rounded-lg self-start">warning</span>
<div>
<h3 class="text-3xl font-bold font-headline text-primary mt-4">24</h3>
<p class="text-xs text-on-surface-variant font-body">Low Stock Alerts</p>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm flex flex-col justify-between">
<span class="material-symbols-outlined text-secondary p-2 bg-secondary-fixed rounded-lg self-start">trending_up</span>
<div>
<h3 class="text-3xl font-bold font-headline text-primary mt-4">$124.5k</h3>
<p class="text-xs text-on-surface-variant font-body">Inventory Value</p>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm flex flex-col justify-between border-2 border-primary-fixed">
<span class="material-symbols-outlined text-primary p-2 bg-primary-fixed rounded-lg self-start">category</span>
<div>
<h3 class="text-3xl font-bold font-headline text-primary mt-4">18</h3>
<p class="text-xs text-on-surface-variant font-body">Product Categories</p>
</div>
</div>
</section>
<!-- Main Data Canvas -->
<section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="px-8 py-5 text-xs font-bold text-primary font-label uppercase tracking-wider">Product</th>
<th class="px-6 py-5 text-xs font-bold text-primary font-label uppercase tracking-wider">Category</th>
<th class="px-6 py-5 text-xs font-bold text-primary font-label uppercase tracking-wider">Stock Level</th>
<th class="px-6 py-5 text-xs font-bold text-primary font-label uppercase tracking-wider">Price</th>
<th class="px-6 py-5 text-xs font-bold text-primary font-label uppercase tracking-wider">Status</th>
<th class="px-8 py-5 text-xs font-bold text-primary font-label uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container-low">
<!-- Row 1 -->
<tr class="hover:bg-surface-container-low/30 transition-colors group">
<td class="px-8 py-4">
<div class="flex items-center space-x-4">
<div class="w-14 h-14 rounded-lg bg-surface-container-high overflow-hidden flex-shrink-0">
<img alt="Minimalist Watch" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" data-alt="clean product photography of a modern minimalist white wristwatch on a matching neutral background with soft shadows" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCS9brpsLsxcznOYYaqaCYmlHgxBK-sYWkJAW6dsBlkZS28DWV6qQMFd-E1vhHKAgfQKLfIruOBFN7CG_w8ChM0VpcTe-BL11O4KBEXH7kTn7NrMFiE1gzjZNZz7_Kg38CRugQityYBqMFhuwFEefBQg1I87n4sLk4lWvixMwR7Vog26BGwr-NcQojisdG0oZ9KdiaxEvMnh9tCU7GwPlg_HbNx0d3YjQfDMnmTVWd_vvE750FPyfDtOzK_Z5SoUaaXAQGqhpzOh3w"/>
</div>
<div>
<p class="text-sm font-bold text-primary font-headline">Zenith Minimalist Watch</p>
<p class="text-[10px] text-on-surface-variant font-body">SKU: ZMW-00912</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant text-[10px] font-bold rounded-full uppercase tracking-tighter">Electronics</span>
</td>
<td class="px-6 py-4">
<div class="flex flex-col gap-1.5">
<span class="text-sm font-bold text-primary">128 units</span>
<div class="w-32 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-primary-fixed-dim w-[80%] rounded-full"></div>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="text-sm font-bold text-primary">$189.00</span>
</td>
<td class="px-6 py-4">
<div class="flex items-center space-x-2">
<span class="w-2 h-2 rounded-full bg-tertiary-fixed-dim"></span>
<span class="text-[10px] font-bold text-on-surface-variant font-label uppercase">Published</span>
</div>
</td>
<td class="px-8 py-4 text-right">
<button class="material-symbols-outlined text-outline hover:text-primary transition-colors">more_vert</button>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-surface-container-low/30 transition-colors group">
<td class="px-8 py-4">
<div class="flex items-center space-x-4">
<div class="w-14 h-14 rounded-lg bg-surface-container-high overflow-hidden flex-shrink-0">
<img alt="Sport Shoes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" data-alt="vibrant red athletic running shoe displayed against a dark high-contrast studio background with dynamic lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuChsjZLHKCOQviOHqGsHjoMiwp2r2616CyfRnXYL7m8tQkMZ2F8VAqHrJzskBgH0pdP5BHWxBjmGITqZwOkKAatJBo91riOSlCwZFaFM1KLhmfNfmIWDu0FfxJpwXkaMJjH4SHLMfiTBZR53iNmx5oCBlf220Ur4kQDBh0jX-sbfalWJ4_6XT2_QN8g8hUWHdolr9Qdh5J8B9ZO_DtfamIsgNIfysTc_bAObNwmog7qYQN_UiLJpnPjsPd10T2H6lZAtY-ioQfO7G4"/>
</div>
<div>
<p class="text-sm font-bold text-primary font-headline">Velocity Sprint Runner</p>
<p class="text-[10px] text-on-surface-variant font-body">SKU: VSR-88210</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant text-[10px] font-bold rounded-full uppercase tracking-tighter">Footwear</span>
</td>
<td class="px-6 py-4">
<div class="flex flex-col gap-1.5">
<span class="text-sm font-bold text-error">12 units</span>
<div class="w-32 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-error w-[15%] rounded-full"></div>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="text-sm font-bold text-primary">$110.50</span>
</td>
<td class="px-6 py-4">
<div class="flex items-center space-x-2">
<span class="w-2 h-2 rounded-full bg-error"></span>
<span class="text-[10px] font-bold text-error font-label uppercase">Low Stock</span>
</div>
</td>
<td class="px-8 py-4 text-right">
<button class="material-symbols-outlined text-outline hover:text-primary transition-colors">more_vert</button>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-surface-container-low/30 transition-colors group">
<td class="px-8 py-4">
<div class="flex items-center space-x-4">
<div class="w-14 h-14 rounded-lg bg-surface-container-high overflow-hidden flex-shrink-0">
<img alt="Headphones" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" data-alt="professional over-ear wireless headphones in matte black finish resting on a wooden surface with cinematic bokeh background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuARIT0W89QE7NDyndRn0zPTiRl_Uy1285muz3P-nk8u3difP7F3j8EY7UH2JrQaGJ0QtdBq8tk323yda7ZuL6dhvyq4U945xdkUIPTjhZJKdDMeeqYOcE5Dtb0WIlrkYnrOqp413bhEfq58K5GhvA6W332-zEiWKjG6C119zvEeV6FZhGlihtjfTUqorNp1-uwO9aq2mRzSEFbDIp1uZBGvOG1MWmPhfI59EPlmKjPJfQdefdtb5eV6HtCVl_VW3rKnOK_oBJkMlo0"/>
</div>
<div>
<p class="text-sm font-bold text-primary font-headline">Aura Pro Noise Cancelling</p>
<p class="text-[10px] text-on-surface-variant font-body">SKU: ANC-55011</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant text-[10px] font-bold rounded-full uppercase tracking-tighter">Audio</span>
</td>
<td class="px-6 py-4">
<div class="flex flex-col gap-1.5">
<span class="text-sm font-bold text-primary">456 units</span>
<div class="w-32 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-primary-fixed-dim w-[95%] rounded-full"></div>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="text-sm font-bold text-primary">$349.99</span>
</td>
<td class="px-6 py-4">
<div class="flex items-center space-x-2">
<span class="w-2 h-2 rounded-full bg-tertiary-fixed-dim"></span>
<span class="text-[10px] font-bold text-on-surface-variant font-label uppercase">Published</span>
</div>
</td>
<td class="px-8 py-4 text-right">
<button class="material-symbols-outlined text-outline hover:text-primary transition-colors">more_vert</button>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-surface-container-low/30 transition-colors group">
<td class="px-8 py-4">
<div class="flex items-center space-x-4">
<div class="w-14 h-14 rounded-lg bg-surface-container-high overflow-hidden flex-shrink-0">
<img alt="Polaroid Camera" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" data-alt="vintage style instant film camera in pastel blue color isolated on a soft peach background with studio lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBzoZWma4CJGKFND9wOO16RUfmjQEf1CCu5n2WIvd4DMwyTzFcLHOq0ldy0FOekWoP6c3GN_f0xNT0ayYOECR9xMvqc8hS2lVGSRH6Xhs7lo-fURMwZaGln9SIXes-7kn4u8HecVG2WcSWjMN-9kXC_7dKmcsFUfFTtwoVRar1BQJLMQpD1l4GMHW7EAYGiIsXtcsCbipcga_sudMvUXkdFYgjOugjY9YWdnHaF23aYu5gr_1R8mQV2KrDhKHgkHGDQjHYcsDGPJpE"/>
</div>
<div>
<p class="text-sm font-bold text-primary font-headline">Retro-Flash Instant Camera</p>
<p class="text-[10px] text-on-surface-variant font-body">SKU: RFC-10294</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant text-[10px] font-bold rounded-full uppercase tracking-tighter">Photography</span>
</td>
<td class="px-6 py-4">
<div class="flex flex-col gap-1.5">
<span class="text-sm font-bold text-primary">0 units</span>
<div class="w-32 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-on-surface-variant w-[0%] rounded-full"></div>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="text-sm font-bold text-primary">$89.00</span>
</td>
<td class="px-6 py-4">
<div class="flex items-center space-x-2">
<span class="w-2 h-2 rounded-full bg-on-surface-variant"></span>
<span class="text-[10px] font-bold text-on-surface-variant font-label uppercase">Out of Stock</span>
</div>
</td>
<td class="px-8 py-4 text-right">
<button class="material-symbols-outlined text-outline hover:text-primary transition-colors">more_vert</button>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Pagination Footer -->
<div class="px-8 py-6 bg-surface-container-low flex items-center justify-between">
<p class="text-xs text-on-surface-variant font-body">Showing <span class="font-bold text-primary">1 - 4</span> of 1,402 items</p>
<div class="flex items-center space-x-2">
<button class="p-2 bg-surface-container-lowest rounded-lg text-outline hover:text-primary transition-all shadow-sm">
<span class="material-symbols-outlined text-sm">chevron_left</span>
</button>
<button class="px-3 py-1 bg-primary text-on-primary text-xs font-bold rounded-lg shadow-md">1</button>
<button class="px-3 py-1 bg-surface-container-lowest text-on-surface-variant text-xs font-bold rounded-lg hover:bg-white transition-all shadow-sm">2</button>
<button class="px-3 py-1 bg-surface-container-lowest text-on-surface-variant text-xs font-bold rounded-lg hover:bg-white transition-all shadow-sm">3</button>
<button class="p-2 bg-surface-container-lowest rounded-lg text-outline hover:text-primary transition-all shadow-sm">
<span class="material-symbols-outlined text-sm">chevron_right</span>
</button>
</div>
</div>
</section>
</main>
</body></html>
