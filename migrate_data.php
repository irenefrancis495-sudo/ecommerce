<?php
// Migration script to import JSON data into database

require_once __DIR__ . '/config/bootstrap.php';

use Mpemba\Utils\Database;

echo "Starting data migration...\n";

try {
    // Migrate users
    $usersFile = __DIR__ . '/data/users.json';
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true) ?: [];
        if (Utility::bulkInsert('users', ['id', 'username', 'email', 'password', 'created_at'], $users)) {
            echo "Users migrated successfully: " . count($users) . " records\n";
        } else {
            echo "Failed to migrate users\n";
        }
    }

    // Migrate products
    $productsFile = __DIR__ . '/data/products.json';
    if (file_exists($productsFile)) {
        $products = json_decode(file_get_contents($productsFile), true) ?: [];
        if (Database::saveProducts($products)) {
            echo "Products migrated successfully: " . count($products) . " records\n";
        } else {
            echo "Failed to migrate products\n";
        }
    }

    // Migrate categories
    $categoriesFile = __DIR__ . '/data/categories.json';
    if (file_exists($categoriesFile)) {
        $categories = json_decode(file_get_contents($categoriesFile), true) ?: [];
        if (Database::saveCategories($categories)) {
            echo "Categories migrated successfully: " . count($categories) . " records\n";
        } else {
            echo "Failed to migrate categories\n";
        }
    }

    // Migrate orders and order_items
    $ordersFile = __DIR__ . '/data/orders.json';
    $orderItemsFile = __DIR__ . '/data/order_items.json';
    if (file_exists($ordersFile) && file_exists($orderItemsFile)) {
        $orders = json_decode(file_get_contents($ordersFile), true) ?: [];
        $orderItems = json_decode(file_get_contents($orderItemsFile), true) ?: [];

        global $db;
        $db->beginTransaction();

        // Insert orders
        $orderStmt = $db->prepare("INSERT INTO orders (id, order_number, user_id, total, tax, shipping, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($orders as $order) {
            $orderStmt->execute([
                $order['id'] ?? null,
                $order['order_number'] ?? '',
                $order['user_id'] ?? null,
                $order['total'] ?? 0,
                $order['tax'] ?? 0,
                $order['shipping_cost'] ?? $order['shipping'] ?? 0,
                $order['status'] ?? 'pending',
                $order['created_at'] ?? date('Y-m-d H:i:s'),
                $order['updated_at'] ?? $order['created_at'] ?? date('Y-m-d H:i:s')
            ]);
        }

        // Insert order items
        $itemStmt = $db->prepare("INSERT INTO order_items (id, order_id, product_id, quantity, price, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($orderItems as $item) {
            $itemStmt->execute([
                $item['id'] ?? null,
                $item['order_id'] ?? 0,
                $item['product_id'] ?? 0,
                $item['quantity'] ?? 1,
                $item['unit_price'] ?? $item['price'] ?? 0,
                $item['created_at'] ?? date('Y-m-d H:i:s')
            ]);
        }

        $db->commit();
        echo "Orders migrated successfully: " . count($orders) . " orders, " . count($orderItems) . " items\n";
    }

    // Migrate cart items
    $cartFile = __DIR__ . '/data/cart_items.json';
    if (file_exists($cartFile)) {
        $cartItems = json_decode(file_get_contents($cartFile), true) ?: [];
        // Since no saveCartItems, insert directly
        global $db;
        $stmt = $db->prepare("INSERT INTO cart_items (id, user_id, product_id, quantity, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($cartItems as $item) {
            $stmt->execute([
                $item['id'] ?? null,
                $item['user_id'] ?? 0,
                $item['product_id'] ?? 0,
                $item['quantity'] ?? 1,
                $item['created_at'] ?? date('Y-m-d H:i:s'),
                $item['updated_at'] ?? date('Y-m-d H:i:s')
            ]);
        }
        echo "Cart items migrated successfully: " . count($cartItems) . " records\n";
    }

    // Migrate subscribers
    $subscribersFile = __DIR__ . '/data/subscribers.json';
    if (file_exists($subscribersFile)) {
        $subscribers = json_decode(file_get_contents($subscribersFile), true) ?: [];
        if (Database::saveSubscribers($subscribers)) {
            echo "Subscribers migrated successfully: " . count($subscribers) . " records\n";
        } else {
            echo "Failed to migrate subscribers\n";
        }
    }

    // Migrate contact messages
    $messagesFile = __DIR__ . '/data/contact_messages.json';
    if (file_exists($messagesFile)) {
        $messages = json_decode(file_get_contents($messagesFile), true) ?: [];
        if (Database::saveContactMessages($messages)) {
            echo "Contact messages migrated successfully: " . count($messages) . " records\n";
        } else {
            echo "Failed to migrate contact messages\n";
        }
    }

    // Migrate customer comments
    $commentsFile = __DIR__ . '/data/customer_comments.json';
    if (file_exists($commentsFile)) {
        $comments = json_decode(file_get_contents($commentsFile), true) ?: [];
        if (Database::saveCustomerComments($comments)) {
            echo "Customer comments migrated successfully: " . count($comments) . " records\n";
        } else {
            echo "Failed to migrate customer comments\n";
        }
    }

    // Migrate role permissions
    $rolesFile = __DIR__ . '/data/role_permissions.json';
    if (file_exists($rolesFile)) {
        $roles = json_decode(file_get_contents($rolesFile), true) ?: [];
        if (Database::saveRolePermissions($roles)) {
            echo "Role permissions migrated successfully: " . count($roles) . " records\n";
        } else {
            echo "Failed to migrate role permissions\n";
        }
    }

    // Migrate admin settings
    $settingsFile = __DIR__ . '/data/admin_settings.json';
    if (file_exists($settingsFile)) {
        $settings = json_decode(file_get_contents($settingsFile), true) ?: [];
        if (Database::saveAdminSettings($settings)) {
            echo "Admin settings migrated successfully: " . count($settings) . " records\n";
        } else {
            echo "Failed to migrate admin settings\n";
        }
    }

    echo "Data migration completed successfully!\n";

} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
?>