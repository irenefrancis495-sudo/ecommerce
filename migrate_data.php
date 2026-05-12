<?php
// Migration script to import JSON data into database using Utility class

require_once __DIR__ . '/config/bootstrap.php';

use Mpemba\Utils\Utility;

echo "Starting data migration using Utility...\n";

try {
    $dataDir = __DIR__ . '/data/';

    // Helper function to load JSON
    $loadJson = function($file) use ($dataDir) {
        $filePath = $dataDir . $file;
        if (!file_exists($filePath)) return [];
        return json_decode(file_get_contents($filePath), true) ?: [];
    };

    // Load categories first for mapping
    $categoriesData = $loadJson('categories.json');
    $categoryMap = [];
    foreach ($categoriesData as $cat) {
        if (isset($cat['slug']) && isset($cat['id'])) {
            $categoryMap[$cat['slug']] = $cat['id'];
        }
    }

    // Helper function to import data with mappings
    $import = function($table, $data, $mappings = [], $omitColumns = []) {
        if (empty($data)) return;

        // Define schema columns for each table
        $schemaColumns = [
            'users' => ['id', 'username', 'email', 'password', 'created_at'],
            'products' => ['id', 'name', 'description', 'price', 'image', 'category', 'stock', 'status'],
            'categories' => ['id', 'name', 'description', 'created_at'],
            'orders' => ['id', 'order_number', 'user_id', 'total', 'tax', 'shipping', 'status', 'created_at'],
            'order_items' => ['id', 'order_id', 'product_id', 'quantity', 'price', 'created_at'],
            'cart_items' => ['id', 'user_id', 'product_id', 'quantity', 'created_at'],
            'subscribers' => ['id', 'email', 'subscribed_at'],
            'contact_messages' => ['id', 'name', 'email', 'message', 'created_at'],
            'customer_comments' => ['id', 'user_id', 'product_id', 'comment', 'rating', 'created_at'],
            'role_permissions' => ['role', 'permissions'],
            'admin_settings' => ['id', 'setting_key', 'setting_value', 'updated_at'],
        ];

        if (!isset($schemaColumns[$table])) return;

        $columns = $schemaColumns[$table];
        $processedData = [];

        foreach ($data as $item) {
            // Apply mappings
            foreach ($mappings as $jsonKey => $dbKey) {
                if (isset($item[$jsonKey])) {
                    $item[$dbKey] = $item[$jsonKey];
                }
            }

            // Omit columns
            foreach ($omitColumns as $col) {
                unset($item[$col]);
            }

            $row = [];
            foreach ($columns as $col) {
                $row[$col] = $item[$col] ?? null;
            }
            $processedData[] = $row;
        }

        if (Utility::bulkInsert($table, $columns, $processedData)) {
            echo "Successfully migrated $table (" . count($processedData) . " records)\n";
        } else {
            echo "Failed to migrate $table\n";
        }
    };

    // Import data
    $import('users', $loadJson('users.json'), [], ['role']);
    $import('categories', $categoriesData);

    $productsData = $loadJson('products.json');
    foreach ($productsData as &$p) {
        if (isset($p['category']) && isset($categoryMap[$p['category']])) {
            $p['category'] = $categoryMap[$p['category']];
        }
    }
    $import('products', $productsData, [
        'stock_quantity' => 'stock',
        'image_url' => 'image'
    ]);

    $import('orders', $loadJson('orders.json'), [
        'shipping_cost' => 'shipping'
    ]);

    $import('order_items', $loadJson('order_items.json'), [
        'unit_price' => 'price'
    ]);

    $import('cart_items', $loadJson('cart_items.json'));
    $import('subscribers', $loadJson('subscribers.json'));
    $import('contact_messages', $loadJson('contact_messages.json'));
    $import('customer_comments', $loadJson('customer_comments.json'), [
        'message' => 'comment'
    ]);
    $import('role_permissions', $loadJson('role_permissions.json'), ['permission' => 'permissions']);
    $import('admin_settings', $loadJson('admin_settings.json'));

    echo "Data migration completed successfully!\n";

} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}