<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Status - Mpemba Marketplace</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <?php include __DIR__ . '/../components/ui/navbar.php'; ?>
    <main class="max-w-5xl mx-auto px-6 py-10">
        <section class="rounded-3xl bg-white shadow-sm p-8">
            <h1 class="text-3xl font-bold mb-6">Order Status</h1>
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-slate-100">
                        <th class="px-4 py-3">Order #</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="px-4 py-3">12345</td>
                        <td class="px-4 py-3">2026-04-22</td>
                        <td class="px-4 py-3 text-emerald-600">Shipped</td>
                        <td class="px-4 py-3">Tsh 50,000</td>
                    </tr>
                    <tr class="border-t">
                        <td class="px-4 py-3">12346</td>
                        <td class="px-4 py-3">2026-04-24</td>
                        <td class="px-4 py-3 text-amber-600">Processing</td>
                        <td class="px-4 py-3">Tsh 28,000</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
    <?php include __DIR__ . '/../components/ui/footer.php'; ?>
</body>
</html>
