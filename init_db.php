<?php
// Load .env
$dotenv = parse_ini_file('.env');
$dbPath = $dotenv['DB_PATH'] ?? 'db.sqlite';

$db = new PDO("sqlite:$dbPath");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec('CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price REAL NOT NULL,
    stock INTEGER NOT NULL,
    category TEXT NOT NULL
)');

$db->exec('CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    email TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT "customer"
)');

$db->exec('CREATE TABLE IF NOT EXISTS orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    total REAL NOT NULL,
    status TEXT NOT NULL DEFAULT "pending",
    created_at TEXT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id)
)');

$db->exec('CREATE TABLE IF NOT EXISTS order_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    price REAL NOT NULL,
    FOREIGN KEY(order_id) REFERENCES orders(id),
    FOREIGN KEY(product_id) REFERENCES products(id)
)');

$db->exec('CREATE TABLE IF NOT EXISTS cart_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    created_at TEXT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(product_id) REFERENCES products(id)
)');

$products = [
    ['name' => 'King Burger', 'price' => 6.99, 'stock' => 120, 'category' => 'Burgers'],
    ['name' => 'Chicken Noodles', 'price' => 5.49, 'stock' => 80, 'category' => 'Noodles'],
    ['name' => 'Hot & Sour Soup', 'price' => 3.99, 'stock' => 50, 'category' => 'Soups'],
    ['name' => 'Chocolate Milkshake', 'price' => 3.49, 'stock' => 60, 'category' => 'Beverages'],
    ['name' => 'Spicy Grilled Chicken', 'price' => 8.99, 'stock' => 70, 'category' => 'Grill'],
];

$insertProduct = $db->prepare('INSERT OR IGNORE INTO products (name, price, stock, category) VALUES (?, ?, ?, ?)');
foreach ($products as $product) {
    $insertProduct->execute([$product['name'], $product['price'], $product['stock'], $product['category']]);
}

$adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
$db->exec("INSERT OR IGNORE INTO users (username, password, email, role) VALUES ('admin', '" . $adminPassword . "', 'admin@mpemba.local', 'admin')");
$db->exec("INSERT OR IGNORE INTO users (username, password, email, role) VALUES ('customer', '" . password_hash('customer123', PASSWORD_DEFAULT) . "', 'customer@mpemba.local', 'customer')");

echo "Database initialized successfully.\n";
