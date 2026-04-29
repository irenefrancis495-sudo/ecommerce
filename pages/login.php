
<section class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form id="loginForm">
            <div class="mb-4">
                <label class="block text-gray-700">Username</label>
                <input type="text" id="username" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700">Password</label>
                <input type="password" id="password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Login</button>
        </form>
        <p class="mt-4 text-center">Don't have an account? <a href="/register" class="text-blue-500">Register</a></p>
    </div>
</section>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            const response = await fetch('/api.php/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ username, password })
            });

            const result = await response.json();
            if (result.success) {
                window.location.href = '/home';
            } else {
                alert(result.error);
            }
        });
    </script>
