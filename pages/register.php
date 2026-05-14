<?php require_once __DIR__ . '/../config/bootstrap.php';
include __DIR__ . '/../components/ui/navbar.php'; ?>

<main class="pt-28 pb-20 max-w-6xl mx-auto px-6">
    <section class="grid gap-8 lg:grid-cols-12 items-start mb-12">
        <div class="lg:col-span-7 relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-slate-950 via-slate-900 to-primary/20 p-10 shadow-2xl border border-slate-800/70">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.25),_transparent_35%)]"></div>
            <div class="absolute bottom-0 right-0 h-56 w-56 rounded-full bg-primary/10 blur-3xl"></div>
            <div class="relative z-10">
                <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-slate-100 shadow-lg shadow-slate-950/10 backdrop-blur">
                    <span class="material-symbols-outlined">sparkles</span>
                    Join the marketplace today
                </div>
                <h1 class="mt-6 text-5xl md:text-6xl font-black tracking-tight text-white leading-tight">Start your Mpemba shopping experience with ease.</h1>
                <p class="mt-6 max-w-2xl text-lg text-slate-300">Create your profile to unlock the best beauty, home, and electronics collections. Place orders faster and discover curated favorites.</p>

                <div class="mt-10 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-slate-900/80 border border-slate-700/70 p-6 shadow-lg shadow-slate-950/20">
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400 mb-3">Fast setup</p>
                        <p class="text-slate-100 text-base">Create your account in seconds and begin shopping.</p>
                    </div>
                    <div class="rounded-3xl bg-slate-900/80 border border-slate-700/70 p-6 shadow-lg shadow-slate-950/20">
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400 mb-3">Exclusive deals</p>
                        <p class="text-slate-100 text-base">Receive curated product recommendations and offers.</p>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-2 gap-4 text-slate-100">
                    <div class="rounded-3xl bg-white/10 p-5">
                        <p class="text-3xl font-black">4.9</p>
                        <p class="mt-2 text-sm text-slate-300">Customer rating</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-5">
                        <p class="text-3xl font-black">200+</p>
                        <p class="mt-2 text-sm text-slate-300">Curated products</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5">
            <section class="bg-white rounded-[2rem] border border-slate-200/70 shadow-2xl p-10">
                <div class="mb-8">
                    <p class="text-sm uppercase tracking-[0.35em] text-primary font-semibold">Register</p>
                    <h2 class="mt-3 text-4xl font-black text-slate-950">Create your profile</h2>
                    <p class="mt-4 text-slate-600">Enter your details below to join our marketplace and start shopping instantly.</p>
                </div>

                <form id="registerForm" class="space-y-5" method="post" action="/pages/register_process.php">
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                        <input type="text" id="username" name="username" class="w-full rounded-3xl border border-slate-300 px-5 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="Enter a username" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email address</label>
                        <input type="email" id="email" name="email" class="w-full rounded-3xl border border-slate-300 px-5 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="you@example.com" required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <input type="password" id="password" name="password" class="w-full rounded-3xl border border-slate-300 px-5 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="Minimum 6 characters" required>
                    </div>
                    <button type="submit" class="w-full rounded-3xl bg-primary px-6 py-3 text-white text-lg font-semibold hover:bg-primary/90 transition">Create account</button>
                </form>

                <?php
                if (session_status() === PHP_SESSION_NONE) session_start();
                if (!empty($_SESSION['register_error'])) {
                    echo '<div class="mt-4 p-3 rounded-md bg-red-50 text-red-800">' . htmlspecialchars($_SESSION['register_error']) . '</div>';
                    unset($_SESSION['register_error']);
                }
                ?>

                <p class="mt-6 text-center text-slate-600">Already have an account? <a href="/login" class="text-primary font-semibold hover:underline">Login now</a></p>
            </section>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>

                <!-- Server-side registration: no client-side AJAX required -->