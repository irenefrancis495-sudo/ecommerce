<?php include __DIR__ . '/../components/ui/navbar.php'; ?>

<main class="pt-32 pb-20 max-w-3xl mx-auto px-6">
    <section class="bg-slate-50 rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-6">
            <div class="bg-[url('https://images.unsplash.com/photo-1517502166878-35c93a0072bb?w=1200&h=1200&fit=crop&crop=center')] bg-cover bg-center p-10 hidden lg:block">
                <div class="h-full w-full rounded-[2rem] bg-gradient-to-br from-black/40 via-black/20 to-transparent p-8 flex flex-col justify-end">
                    <p class="text-sm uppercase tracking-[0.35em] text-white mb-4">Welcome back</p>
                    <h2 class="text-4xl font-extrabold text-white mb-4">Login to Mpemba</h2>
                    <p class="text-slate-200 leading-relaxed">Access your curated favorites, continue shopping, and manage your cart with a faster checkout experience.</p>
                </div>
            </div>

            <div class="p-10 bg-white">
                <div class="max-w-md mx-auto">
                    <p class="text-sm uppercase tracking-[0.35em] text-primary font-semibold">Login</p>
                    <h1 class="text-4xl font-black text-[#003345] mt-4">Welcome back</h1>
                    <p class="mt-4 text-slate-600">Sign in to continue exploring natural beauty, lifestyle, and electronics from Mpemba Marketplace.</p>

                    <form id="loginForm" class="mt-10 space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                            <input type="text" id="username" class="w-full rounded-3xl border border-slate-300 px-5 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="Enter your username" required>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                            <input type="password" id="password" class="w-full rounded-3xl border border-slate-300 px-5 py-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="Minimum 6 characters" required>
                        </div>
                        <button type="submit" id="submitBtn" class="w-full rounded-3xl bg-primary px-6 py-3 text-white text-lg font-semibold hover:bg-primary/90 transition">Login</button>
                    </form>

                    <p class="mt-6 text-center text-slate-600">Don't have an account? <a href="/register" class="text-primary font-semibold hover:underline">Create one</a></p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>

<script>
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const submitBtn = document.getElementById('submitBtn');

        if (!username || password.length < 6) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Error',
                    text: 'Please enter a valid username and password with at least 6 characters.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('Please enter a valid username and password with at least 6 characters.');
            }
            return;
        }

        // Disable button and show loading
        submitBtn.disabled = true;
        submitBtn.textContent = 'Inapakia...';

        try {
            const response = await fetch('/api/auth.php?action=login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            });

            const result = await response.json();

            if (result.success) {
                // Store user data in localStorage for client-side use
                localStorage.setItem('user', JSON.stringify(result.user));

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Success!',
                        text: 'You have successfully logged into your account.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('Login successful!');
                }

                setTimeout(() => {
                    window.location.href = '/home';
                }, 1000);
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Login Failed',
                        text: result.message,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                } else {
                    alert(result.message);
                }
            }
        } catch (error) {
            console.error('Login error:', error);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Error',
                    text: 'There was a technical problem. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('There was a technical problem. Please try again.');
            }
        } finally {
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.textContent = 'Login';
        }
    });
</script>
