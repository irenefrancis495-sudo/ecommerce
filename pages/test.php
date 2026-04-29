<?php
require __DIR__ . '/../config/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page | Mpemba Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main class="max-w-5xl mx-auto px-6 py-10">
        <section class="bg-white rounded-3xl p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900 mb-4">Test Page</h1>
            <p class="text-slate-600">This page is available for system checks and simple functional tests.</p>
        </section>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
