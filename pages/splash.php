<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { margin: 0; font-family: Inter, sans-serif; }
        .splash-screen { min-height: 100vh; display: grid; place-items: center; background: radial-gradient(circle at top, #1e40af 0%, #0f172a 60%); color: white; }
        .loader { width: 80px; height: 4px; background: rgba(255,255,255,0.2); position: relative; overflow: hidden; border-radius: 999px; }
        .loader::before { content: ''; position: absolute; width: 40px; height: 100%; background: #60a5fa; animation: slide 1.4s infinite ease-in-out; }
        @keyframes slide { 0% { transform: translateX(-100%);} 100% { transform: translateX(200%);} }
    </style>
</head>
<body>
    <div class="splash-screen">
        <div class="text-center px-6">
            <h1 class="text-5xl font-black mb-4">Mpemba Marketplace</h1>
            <p class="text-slate-200 text-lg mb-10">Loading your shopping experience... please wait.</p>
            <div class="loader mx-auto"></div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = '/home';
        }, 2500);
    </script>
</body>
</html>
