<?php

declare(strict_types=1);

namespace Mpemba\Crud\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Mpemba\Utils\Utility;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260511100024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
         //   $this->addSql('ALTER TABLE group_menu ADD CONSTRAINT FK_GROUP_MENU_GROUP_ID FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE');

         try {
    // Migrate users
    $usersFile = __DIR__ . '../../data/users.json';
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true) ?: [];
        Utility::bulkInsert('users', ['id', 'username', 'email', 'password', 'created_at'], $users);
       
    }

    // Migrate products
    $productsFile = __DIR__ . '../../data/products.json';
    if (file_exists($productsFile)) {
        $products = json_decode(file_get_contents($productsFile), true) ?: [];
        Utility::bulkInsert('products', ['id', 'name', 'description', 'price', 'category', 'stock', 'created_at','updated_at'], $products);
       
    }

    // Migrate categories
    $categoriesFile = __DIR__ . '/data/categories.json';
    if (file_exists($categoriesFile)) {
        $categories = json_decode(file_get_contents($categoriesFile), true) ?: [];
        Utility::bulkInsert('categories', ['id', 'name', 'description', 'created_at'], $categories);
    }

    // Migrate orders and order_items
    $ordersFile = __DIR__ . '../../data/orders.json';
    $orderItemsFile = __DIR__ . '../../data/order_items.json';
    if (file_exists($ordersFile) && file_exists($orderItemsFile)) {
        $orders = json_decode(file_get_contents($ordersFile), true) ?: [];
        $orderItems = json_decode(file_get_contents($orderItemsFile), true) ?: [];

        global $db;
        $db->beginTransaction();

        // Insert orders
        $ordersItemToBeInserted = [];
       
        foreach ($orders as $order) {
            $orders[] = [
                $order['id'] ?? null,
                $order['order_number'] ?? '',
                $order['user_id'] ?? null,
                $order['total'] ?? 0,
                $order['tax'] ?? 0,
                $order['shipping_cost'] ?? $order['shipping'] ?? 0,
                $order['status'] ?? 'pending',
                $order['created_at'] ?? date('Y-m-d H:i:s'),
                $order['updated_at'] ?? $order['created_at'] ?? date('Y-m-d H:i:s')
            ];
        }

        Utility::bulkInsert('orders',
         ['id', 
         'order_number',
         'user_id',
          'total', 
          'tax',
           'shipping',
           'shipping_cost',
            'status',
             'created_at',
              'updated_at'], $ordersItemToBeInserted);

        // Insert order items
        $orderItemsToBeInserted = [];
        $itemStmt = $db->prepare("INSERT INTO order_items (id, order_id, product_id, quantity, price, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($orderItems as $item) {
            $orderItemsToBeInserted[] = [
                $item['id'] ?? null,
                $item['order_id'] ?? 0,
                $item['product_id'] ?? 0,
                $item['quantity'] ?? 1,
                $item['unit_price'] ?? $item['price'] ?? 0,
                $item['created_at'] ?? date('Y-m-d H:i:s')
            ];
        }

        Utility::bulkInsert('order_items',
         ['id', 
         'order_id',
         'product_id',
          'quantity', 
          'price',
           'created_at'], $orderItemsToBeInserted);

      
    }

    // Migrate cart items
    $cartFile = __DIR__ . '../../data/cart_items.json';
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
    }

    // Migrate subscribers
    $subscribersFile = __DIR__ . '../../data/subscribers.json';
    if (file_exists($subscribersFile)) {
        $subscribers = json_decode(file_get_contents($subscribersFile), true) ?: [];
        utility::bulkInsert('subscribers', ['id', 'email', 'subscribed_at'], $subscribers);
    }

    // Migrate contact messages
    $messagesFile = __DIR__ . '../../data/contact_messages.json';
    if (file_exists($messagesFile)) {
        $messages = json_decode(file_get_contents($messagesFile), true) ?: [];
        utility::bulkInsert('contact_messages', ['id', 'name', 'email', 'message', 'created_at'], $messages);
        }
    // Migrate customer comments
    $commentsFile = __DIR__ . '../../data/customer_comments.json';
    if (file_exists($commentsFile)) {
        $customer_comments = json_decode(file_get_contents($commentsFile), true) ?: [];
        utility::bulkInsert('customer_comments', ['id', 'user_id', 'product_id', 'comment', 'rating', 'created_at'], $customer_comments);
    }

    // Migrate role permissions
    $rolesFile = __DIR__ . '../../data/role_permissions.json';
    if (file_exists($rolesFile)) {
        $roles = json_decode(file_get_contents($rolesFile), true) ?: [];
        utility::bulkInsert('role_permissions', ['role', 'permission'], $roles);
    }

    // Migrate admin settings
    $settingsFile = __DIR__ . '../../data/admin_settings.json';
    if (file_exists($settingsFile)) {
        $settings = json_decode(file_get_contents($settingsFile), true) ?: [];
        utility::bulkInsert('admin_settings', ['id', 'setting_key', 'setting_value', 'updated_at'], $settings);
    }
    // Migrate menu
    $menuFile = __DIR__ . '../../data/menu.json';
    if (file_exists($menuFile)) {
        $menuItems = json_decode(file_get_contents($menuFile), true) ?: [];
        utility::bulkInsert('menu', ['id', 'name', 'keyword', 'url', 'icon', 'order_index', 'parent_id', 'status', 'created_at', 'updated_at'], $menuItems);
    }
    // Migrate groups
    $groupsFile = __DIR__ . '../../data/groups.json';
    if (file_exists($groupsFile)) {
        $groups = json_decode(file_get_contents($groupsFile), true) ?: [];
        utility::bulkInsert('groups', ['id', 'name', 'keyword', 'status', 'created_at', 'updated_at'], $groups);
    }
    // Migrate group_menu
    $groupMenuFile = __DIR__ . '../../data/group_menu.json';
    if (file_exists($groupMenuFile)) {
        $groupMenus = json_decode(file_get_contents($groupMenuFile), true) ?: [];
        utility::bulkInsert('group_menu', ['id', 'group_id', 'menu_id', 'created_at'], $groupMenus);
    }
    //group_permissions
    $groupPermissionsFile = __DIR__ . '../../data/group_permissions.json';          
    if (file_exists($groupPermissionsFile)) {
        $groupPermissions = json_decode(file_get_contents($groupPermissionsFile), true) ?: [];
        utility::bulkInsert('group_permissions', ['id', 'group_id', 'permission_id', 'created_at'], $groupPermissions);
    }
    // Migrate permissions
    $permissionsFile = __DIR__ . '../../data/permissions.json'; 
    if (file_exists($permissionsFile)) {
        $permissions = json_decode(file_get_contents($permissionsFile), true) ?: [];
        utility::bulkInsert('permissions', ['id', 'name', 'description', 'keyword', 'created_at', 'updated_at'], $permissions);
    }
    //Migrate audit_logs
    $auditLogsFile = __DIR__ . '../../data/audit_logs.json';
    if (file_exists($auditLogsFile)) {
        $auditLogs = json_decode(file_get_contents($auditLogsFile), true) ?: [];
        utility::bulkInsert('audit_logs', ['id', 'user_id', 'action', 'entity_type', 'entity_id', 'changes', 'ip_address', 'user_agent', 'created_at'], $auditLogs);
    }
         }
    public function down(Schema $schema): void

    {
       //this command clears the table if you need to rollback the migration 
       $this->addSql('DELETE FROM users');
       $this->addSql('DELETE FROM products');
         $this->addSql('DELETE FROM categories');
            $this->addSql('DELETE FROM orders');
                $this->addSql('DELETE FROM order_items');
                $this->addSql('DELETE FROM cart_items');
                $this->addSql('DELETE FROM subscribers');
                    $this->addSql('DELETE FROM contact_messages');
                    $this->addSql('DELETE FROM customer_comments');
                    $this->addSql('DELETE FROM role_permissions');
                    $this->addSql('DELETE FROM admin_settings');
                        $this->addSql('DELETE FROM menu');
                        $this->addSql('DELETE FROM groups');
                        $this->addSql('DELETE FROM group_menu');
                        $this->addSql('DELETE FROM group_permissions');
                            $this->addSql('DELETE FROM permissions');
                            $this->addSql('DELETE FROM audit_logs');

    }
}