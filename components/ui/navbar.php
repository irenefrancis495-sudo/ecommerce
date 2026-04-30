<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-950/95 backdrop-blur-xl border-b border-slate-200/70 dark:border-slate-800 shadow-sm">
    <div class="max-w-screen-2xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
        <a href="/home" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary text-white text-lg font-black">M</div>
            <div>
                <p class="text-base font-semibold text-slate-700 dark:text-slate-100">Mpemba</p>
                <p class="text-xs tracking-[0.35em] uppercase text-slate-500 dark:text-slate-400">Marketplace</p>
            </div>
        </a>

        <div class="hidden lg:flex items-center gap-6">
            <a class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-white transition font-medium" href="/home">Home</a>
            <a class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-white transition font-medium" href="/products">Products</a>
            <a class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-white transition font-medium" href="/category">Categories</a>
            <a class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-white transition font-medium" href="/register">Register</a>
        </div>

        <div class="hidden lg:flex items-center gap-4" id="auth-section">
            <!-- This will be populated by JavaScript -->
        </div>

        <button id="mobileMenuButton" class="lg:hidden inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 transition dark:border-slate-800 dark:bg-slate-950 dark:text-slate-200" aria-expanded="false" aria-label="Toggle navigation menu">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>

    <div id="mobileMenu" class="lg:hidden hidden border-t border-slate-200/70 dark:border-slate-800 bg-white/95 dark:bg-slate-950/95 backdrop-blur-xl">
        <div class="px-6 py-5 space-y-3">
            <a class="block rounded-3xl px-4 py-3 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition" href="/home">Home</a>
            <a class="block rounded-3xl px-4 py-3 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition" href="/products">Products</a>
            <a class="block rounded-3xl px-4 py-3 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition" href="/category">Categories</a>
            <a class="block rounded-3xl px-4 py-3 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition" href="/register">Register</a>
            <div class="flex flex-col gap-3 pt-2 border-t border-slate-200/70 dark:border-slate-800" id="mobile-auth-section">
                <!-- This will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuButton.addEventListener('click', () => {
            const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', String(!expanded));
            mobileMenu.classList.toggle('hidden');
        });

        // Check authentication status and update navbar
        async function updateAuthStatus() {
            try {
                const response = await fetch('/api/auth.php?action=check');
                const result = await response.json();

                const authSection = document.getElementById('auth-section');
                const mobileAuthSection = document.getElementById('mobile-auth-section');

                if (result.success && result.user) {
                    // User is logged in
                    const user = result.user;
                    authSection.innerHTML = `
                        <span class="text-slate-600 dark:text-slate-300 text-sm">Hello, ${user.first_name || user.username}!</span>
                        <button onclick="logout()" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:border-red-300 hover:text-red-600 transition dark:border-slate-800 dark:bg-slate-950 dark:text-slate-200">Logout</button>
                        <a href="/cart" class="relative inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-3 py-2 text-slate-700 shadow-sm hover:border-primary hover:text-primary transition dark:border-slate-800 dark:bg-slate-950 dark:text-slate-200 dark:hover:text-white">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            <span id="cart-count" class="absolute -top-1 -right-1 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-secondary text-[10px] font-bold text-on-secondary px-1.5"></span>
                        </a>
                    `;

                    mobileAuthSection.innerHTML = `
                        <div class="px-4 py-2 text-sm text-slate-600 dark:text-slate-400 border-b border-slate-200/70 dark:border-slate-800">
                            Hello, ${user.first_name || user.username}
                        </div>
                        <button onclick="logout()" class="block rounded-3xl bg-red-600 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-red-700 transition">Logout</button>
                        <a href="/cart" class="flex items-center justify-center gap-2 rounded-3xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 hover:border-primary hover:text-primary transition dark:border-slate-800 dark:text-slate-200">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Cart
                        </a>
                    `;
                } else {
                    // User is not logged in
                    authSection.innerHTML = `
                        <a href="/login" class="rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-primary/20 hover:bg-primary/90 transition">Login</a>
                        <a href="/cart" class="relative inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-3 py-2 text-slate-700 shadow-sm hover:border-primary hover:text-primary transition dark:border-slate-800 dark:bg-slate-950 dark:text-slate-200 dark:hover:text-white">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            <span id="cart-count" class="absolute -top-1 -right-1 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-secondary text-[10px] font-bold text-on-secondary px-1.5"></span>
                        </a>
                    `;

                    mobileAuthSection.innerHTML = `
                        <a href="/login" class="block rounded-3xl bg-primary px-4 py-3 text-center text-sm font-semibold text-white hover:bg-primary/90 transition">Login</a>
                        <a href="/cart" class="flex items-center justify-center gap-2 rounded-3xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 hover:border-primary hover:text-primary transition dark:border-slate-800 dark:text-slate-200">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Cart
                        </a>
                    `;
                }
            } catch (error) {
                console.error('Auth check failed:', error);
                // Default to logged out state
                updateAuthStatus();
            }
        }

        async function logout() {
            try {
                const response = await fetch('/api/auth.php?action=logout', {
                    method: 'POST'
                });
                const result = await response.json();

                if (result.success) {
                    localStorage.removeItem('user');
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Umefanikiwa',
                            text: 'Umetoka kwenye akaunti.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                    setTimeout(() => {
                        window.location.href = '/home';
                    }, 1000);
                }
            } catch (error) {
                console.error('Logout failed:', error);
                // Force logout on client side
                localStorage.removeItem('user');
                window.location.href = '/home';
            }
        }

        // Initialize auth status on page load
        document.addEventListener('DOMContentLoaded', updateAuthStatus);
    </script>
</nav>