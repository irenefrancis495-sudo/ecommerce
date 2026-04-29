<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
        <form id="registerForm">
            <div class="mb-4">
                <label class="block text-gray-700">Username</label>
                <input type="text" id="username" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" id="email" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700">Password</label>
                <input type="password" id="password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">Register</button>
        </form>
        <p class="mt-4 text-center">Already have an account? <a href="/login" class="text-blue-500">Login</a></p>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('/api.php/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ username, email, password })
            });

            const result = await response.json();
            if (result.success) {
                window.location.href = '/home';
            } else {
                alert(result.error);
            }
        });
    </script>
</body>
</html>