<!DOCTYPE html>

<html class="light" lang="sw"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;700;800;900&amp;family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary-fixed-dim": "#ffb77d",
                        "on-secondary-fixed-variant": "#6e3900",
                        "surface-container-high": "#e7e8ea",
                        "primary-container": "#004b63",
                        "primary": "#003345",
                        "outline-variant": "#c0c7cd",
                        "on-primary": "#ffffff",
                        "primary-fixed-dim": "#96ceeb",
                        "on-primary-container": "#83bad6",
                        "surface-container-low": "#f2f4f6",
                        "background": "#f8f9fb",
                        "on-tertiary-fixed": "#221b00",
                        "tertiary-fixed": "#ffe16d",
                        "primary-fixed": "#bfe8ff",
                        "on-error-container": "#93000a",
                        "on-error": "#ffffff",
                        "inverse-primary": "#96ceeb",
                        "on-tertiary-fixed-variant": "#544600",
                        "surface-container-highest": "#e1e2e5",
                        "surface-container": "#edeef0",
                        "tertiary-container": "#c9a900",
                        "surface-dim": "#d9dadc",
                        "secondary-fixed": "#ffdcc3",
                        "secondary-container": "#ffa454",
                        "inverse-surface": "#2e3133",
                        "inverse-on-surface": "#f0f1f3",
                        "surface-tint": "#2a657e",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed-variant": "#044d65",
                        "surface-variant": "#e1e2e5",
                        "on-tertiary-container": "#4c3f00",
                        "error-container": "#ffdad6",
                        "secondary": "#904d00",
                        "outline": "#71787d",
                        "on-primary-fixed": "#001f2b",
                        "error": "#ba1a1a",
                        "on-secondary-container": "#713b00",
                        "tertiary-fixed-dim": "#e9c400",
                        "surface-bright": "#f8f9fb",
                        "surface": "#f8f9fb",
                        "on-surface": "#191c1e",
                        "on-tertiary": "#ffffff",
                        "on-background": "#191c1e",
                        "on-secondary-fixed": "#2f1500",
                        "on-surface-variant": "#40484c",
                        "tertiary": "#705d00",
                        "on-secondary": "#ffffff"
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
            vertical-align: middle;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-background font-body text-on-surface min-h-screen pb-32">
<!-- TopAppBar -->
<header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg docked full-width top-0 sticky z-50 shadow-sm dark:shadow-none bg-surface-container-low">
<div class="flex justify-between items-center px-6 py-4 w-full max-w-7xl mx-auto">
<div class="flex items-center gap-4">
<button class="material-symbols-outlined text-primary active:scale-95 duration-200">arrow_back</button>
<h1 class="text-xl font-black text-cyan-950 dark:text-white font-headline tracking-tight">Mpemba Marketplace</h1>
</div>
<div class="flex gap-4">
<button class="material-symbols-outlined text-primary hover:bg-slate-100 p-2 rounded-full transition-colors active:scale-95">notifications</button>
<button class="material-symbols-outlined text-primary hover:bg-slate-100 p-2 rounded-full transition-colors active:scale-95">shopping_cart</button>
</div>
</div>
</header>
<main class="max-w-7xl mx-auto px-6 py-12">
<!-- Title Section -->
<div class="mb-12">
<h2 class="text-4xl md:text-5xl font-extrabold font-headline text-primary tracking-tight mb-4">Mbinu za Malipo</h2>
<div class="flex items-center gap-2 text-primary font-semibold">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
<span class="text-sm font-label uppercase tracking-widest">100% Secured Payment</span>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
<!-- Saved Methods (Asymmetric Layout) -->
<section class="lg:col-span-7 space-y-8">
<div class="flex items-center justify-between">
<h3 class="text-xl font-bold font-headline text-primary">Saved Methods</h3>
<button class="text-sm font-bold text-secondary-container bg-primary px-4 py-2 rounded-lg active:scale-95 transition-all">
                        + Add New
                    </button>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<!-- Visa Card -->
<div class="relative group overflow-hidden bg-primary p-8 rounded-2xl shadow-lg transform transition-transform hover:scale-[1.02] cursor-pointer h-52 flex flex-col justify-between">
<div class="absolute top-0 right-0 p-4 opacity-10">
<span class="material-symbols-outlined text-8xl">credit_card</span>
</div>
<div class="flex justify-between items-start relative z-10">
<div class="w-12 h-8 bg-white/20 rounded flex items-center justify-center font-bold text-white text-xs">VISA</div>
<span class="material-symbols-outlined text-white/50">contactless</span>
</div>
<div class="relative z-10">
<p class="text-white/60 text-xs font-label uppercase tracking-widest mb-1">Card Number</p>
<p class="text-white text-xl font-headline tracking-[0.2em]">**** **** **** 4291</p>
</div>
<div class="flex justify-between items-center relative z-10 mt-4">
<span class="text-white/80 text-xs font-bold uppercase">Default Method</span>
<button class="text-white/40 hover:text-white transition-colors">
<span class="material-symbols-outlined">delete</span>
</button>
</div>
</div>
<!-- Mastercard -->
<div class="bg-surface-container-low p-8 rounded-2xl transition-all border-2 border-transparent hover:border-primary-container/20 flex flex-col justify-between h-52">
<div class="flex justify-between items-start">
<div class="flex items-center gap-1">
<div class="w-6 h-6 bg-error rounded-full opacity-80"></div>
<div class="w-6 h-6 bg-secondary-container rounded-full -ml-3 opacity-80"></div>
</div>
<button class="text-primary/40 hover:text-primary transition-colors">
<span class="material-symbols-outlined">more_vert</span>
</button>
</div>
<div>
<p class="text-on-surface-variant text-xs font-label uppercase tracking-widest mb-1">Mastercard</p>
<p class="text-primary text-xl font-headline tracking-[0.2em]">**** **** **** 8832</p>
</div>
<div class="flex justify-between items-center pt-4">
<button class="text-primary text-xs font-bold underline decoration-secondary-container underline-offset-4">Set as Default</button>
<span class="text-on-surface-variant text-xs">Exp 05/27</span>
</div>
</div>
</div>
</section>
<!-- Mobile Money Section (The Digital Atelier Sidebar) -->
<aside class="lg:col-span-5">
<div class="bg-surface-container-highest/30 rounded-3xl p-8 border border-white shadow-xl glass-panel">
<h3 class="text-xl font-bold font-headline text-primary mb-8">Mobile Money</h3>
<div class="space-y-6">
<!-- M-Pesa -->
<div class="space-y-3">
<label class="flex items-center gap-3 cursor-pointer group">
<input checked="" class="w-5 h-5 text-primary border-outline focus:ring-primary" name="mobile_money" type="radio"/>
<div class="w-12 h-8 rounded bg-error/10 flex items-center justify-center p-1">
<img alt="M-Pesa" class="h-full object-contain" data-alt="Official M-Pesa logo with green and red branding for mobile money services in East Africa" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAI7A-rN5eMyCT0UrP2vqjMkys-Qoo6EgB1P5VhPjIAgs0WXYtkru_JtT5BmjCTxNJB0UWIX38poHDzC6KV2wTGuIvB3ynvlRjI6F07nfw_EL5zAtjbS2S4-6cgvC2IcxbOqw-54fMDR2_07grrSVIR2iMwXsUQXTqh2ekOmtg6XDapBCTgjHspyhcKl-eD73C3eVFbBX6sG0b9NLx33tQt9p1eb0shBrmD8lXDIwhJ5EtcwMoDC9GQv93MNZj13bgInQUE7V-7w8E"/>
</div>
<span class="font-bold text-primary">Vodacom M-Pesa</span>
</label>
<div class="relative">
<input class="w-full bg-white border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="255 XXX XXX XXX" type="text"/>
<div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-2">
<span class="text-[10px] font-bold text-primary-container bg-primary-fixed px-2 py-0.5 rounded-full uppercase tracking-tighter">Verified</span>
</div>
</div>
</div>
<!-- Airtel Money -->
<div class="space-y-3 opacity-60 hover:opacity-100 transition-opacity">
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 text-primary border-outline focus:ring-primary" name="mobile_money" type="radio"/>
<div class="w-12 h-8 rounded bg-error flex items-center justify-center p-1">
<span class="text-[8px] text-white font-black leading-none">Airtel Money</span>
</div>
<span class="font-bold text-primary">Airtel Money</span>
</label>
<input class="w-full bg-white/50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="255 XXX XXX XXX" type="text"/>
</div>
<!-- Tigo Pesa -->
<div class="space-y-3 opacity-60 hover:opacity-100 transition-opacity">
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 text-primary border-outline focus:ring-primary" name="mobile_money" type="radio"/>
<div class="w-12 h-8 rounded bg-primary-container flex items-center justify-center p-1">
<span class="text-[8px] text-white font-black leading-none italic uppercase">Tigo Pesa</span>
</div>
<span class="font-bold text-primary">Tigo Pesa</span>
</label>
<input class="w-full bg-white/50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="255 XXX XXX XXX" type="text"/>
</div>
<div id="payment-order-summary" class="rounded-3xl bg-white p-5 border border-surface-container-high shadow-sm mt-4">
<h4 class="text-base font-semibold text-primary mb-3">Order Summary</h4>
<div class="space-y-3 text-sm text-on-surface-variant">
<div class="flex justify-between"><span>Items</span><span id="summary-count">0</span></div>
<div class="flex justify-between"><span>Subtotal</span><span id="summary-subtotal">$0.00</span></div>
<div class="flex justify-between"><span>Shipping</span><span id="summary-shipping">$0.00</span></div>
<div class="flex justify-between"><span>Taxes</span><span id="summary-taxes">$0.00</span></div>
</div>
<div class="pt-4 border-t border-surface-container-high mt-4 flex justify-between items-center font-bold text-primary">
<span>Total</span>
<span id="summary-total">$0.00</span>
</div>
</div>
<button id="payment-confirm-button" class="w-full bg-gradient-to-r from-secondary to-secondary-container text-white py-4 rounded-xl font-bold font-headline mt-4 shadow-lg shadow-secondary/20 active:scale-95 transition-transform" disabled>
                    Confirm Payment
                </button>
</div>
</div>
<!-- Trust Badges -->
<div class="mt-8 flex flex-wrap justify-center gap-6 opacity-40">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-xl">security</span>
<span class="text-xs font-bold uppercase tracking-wider">PCI Compliant</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-xl">encrypted</span>
<span class="text-xs font-bold uppercase tracking-wider">SSL Encrypted</span>
</div>
</div>
</aside>
</div>
</main>
<!-- BottomNavBar -->
<nav class="fixed bottom-0 left-0 w-full flex justify-around items-center px-4 py-3 bg-white dark:bg-slate-900 pb-safe z-50 md:hidden shadow-[0_-4px_20px_0_rgba(0,0,0,0.05)] rounded-t-xl">
<a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 px-4 py-1.5 transition-all duration-300 ease-out active:scale-90" href="#">
<span class="material-symbols-outlined">home</span>
<span class="font-['Manrope'] text-[10px] font-semibold uppercase tracking-widest mt-1">Home</span>
</a>
<a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 px-4 py-1.5 transition-all duration-300 ease-out active:scale-90" href="#">
<span class="material-symbols-outlined">storefront</span>
<span class="font-['Manrope'] text-[10px] font-semibold uppercase tracking-widest mt-1">Shop</span>
</a>
<a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 px-4 py-1.5 transition-all duration-300 ease-out active:scale-90" href="#">
<span class="material-symbols-outlined">receipt_long</span>
<span class="font-['Manrope'] text-[10px] font-semibold uppercase tracking-widest mt-1">Orders</span>
</a>
<a class="flex flex-col items-center justify-center bg-cyan-100 dark:bg-cyan-900 text-cyan-950 dark:text-cyan-50 rounded-2xl px-4 py-1.5 transition-all duration-300 ease-out active:scale-90" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
<span class="font-['Manrope'] text-[10px] font-semibold uppercase tracking-widest mt-1">Account</span>
</a>
</nav>
<!-- Visual Texture Element (Asymmetric) -->
<div class="fixed top-0 right-0 w-1/3 h-screen -z-10 bg-gradient-to-b from-primary-container/5 to-transparent pointer-events-none"></div>
<script>
    function getCart() {
        return JSON.parse(localStorage.getItem('cart') || '[]');
    }

    function formatCurrency(amount) {
        return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    }

    function renderPaymentSummary() {
        const cart = getCart();
        const subtotal = cart.reduce((sum, item) => sum + item.price * item.qty, 0);
        const shipping = cart.length ? 24 : 0;
        const taxes = subtotal * 0.07;
        const total = subtotal + shipping + taxes;

        document.getElementById('summary-count').textContent = cart.reduce((sum, item) => sum + item.qty, 0);
        document.getElementById('summary-subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('summary-shipping').textContent = formatCurrency(shipping);
        document.getElementById('summary-taxes').textContent = formatCurrency(taxes);
        document.getElementById('summary-total').textContent = formatCurrency(total);

        const confirmButton = document.getElementById('payment-confirm-button');
        if (confirmButton) {
            confirmButton.disabled = cart.length === 0;
        }
    }

    function getSelectedPaymentMethod() {
        const radios = document.querySelectorAll('input[name="mobile_money"]');
        const selected = Array.from(radios).find(r => r.checked);
        if (!selected) return 'Mobile Money';
        const label = selected.closest('label');
        return label ? label.textContent.trim() : 'Mobile Money';
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderPaymentSummary();

        const confirmButton = document.getElementById('payment-confirm-button');
        if (confirmButton) {
            confirmButton.addEventListener('click', function() {
                const cart = getCart();
                if (cart.length === 0) {
                    alert('Your cart is empty. Add items before confirming payment.');
                    return;
                }
                const method = getSelectedPaymentMethod();
                localStorage.removeItem('cart');
                alert('Payment confirmed using ' + method + '. Thank you for your order!');
                window.location.href = '/order-status';
            });
        }
    });
</script>
</body></html>