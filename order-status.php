
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Status - Mpemba Marketplace</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <main>
        <h2>Order Status</h2>
        <table>
            <thead>
                <tr><th>Order #</th><th>Date</th><th>Status</th><th>Total</th></tr>
            </thead>
            <tbody>
                <!-- PHP: Loop orders -->
                <tr>
                    <td>12345</td>
                    <td>2026-04-22</td>
                    <td>Shipped</td>
                    <td>$50</td>
                </tr>
                <!-- End loop -->
            </tbody>
        </table>
    </main>
    <?php include 'partials/footer.php'; ?>
</body>
</html>