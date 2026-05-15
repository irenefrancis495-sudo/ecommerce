<?php
/**
 * Migration script to add user activities tracking tables to the database
 * Run this script once to initialize the tables
 */

require_once __DIR__ . '/config/bootstrap.php';

echo "🔄 Starting user activities migration...\n\n";

$conn = $GLOBALS['db'] ?? null;
if ($conn === null) {
    echo "❌ Database connection failed\n";
    exit(1);
}

try {
    // Create user_activities table
    echo "📝 Creating user_activities table...\n";
    $query1 = "
        CREATE TABLE IF NOT EXISTS user_activities (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            activity VARCHAR(100) NOT NULL,
            entity_type VARCHAR(50),
            entity_id INT,
            data JSON,
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_activity (activity),
            INDEX idx_created_at (created_at),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        )
    ";
    $conn->executeStatement($query1);
    echo "✅ user_activities table created\n\n";

    // Create user_sessions table
    echo "📝 Creating user_sessions table...\n";
    $query2 = "
        CREATE TABLE IF NOT EXISTS user_sessions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            session_id VARCHAR(255) NOT NULL UNIQUE,
            ip_address VARCHAR(45),
            user_agent TEXT,
            login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            logout_time TIMESTAMP NULL,
            is_active BOOLEAN DEFAULT 1,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            INDEX idx_user_id (user_id),
            INDEX idx_session_id (session_id),
            INDEX idx_is_active (is_active)
        )
    ";
    $conn->executeStatement($query2);
    echo "✅ user_sessions table created\n\n";

    // Create product_views table
    echo "📝 Creating product_views table...\n";
    $query3 = "
        CREATE TABLE IF NOT EXISTS product_views (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            user_id INT,
            view_count INT DEFAULT 1,
            last_viewed TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            ip_address VARCHAR(45),
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
            UNIQUE KEY unique_product_user (product_id, user_id),
            INDEX idx_product_id (product_id),
            INDEX idx_last_viewed (last_viewed)
        )
    ";
    $conn->executeStatement($query3);
    echo "✅ product_views table created\n\n";

    // Create search_queries table
    echo "📝 Creating search_queries table...\n";
    $query4 = "
        CREATE TABLE IF NOT EXISTS search_queries (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            query VARCHAR(255) NOT NULL,
            results_count INT,
            ip_address VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
            INDEX idx_user_id (user_id),
            INDEX idx_query (query),
            INDEX idx_created_at (created_at)
        )
    ";
    $conn->executeStatement($query4);
    echo "✅ search_queries table created\n\n";

    echo "✨ All tables created successfully!\n";
    echo "📊 User activities tracking is now enabled\n";
    exit(0);
} catch (\Exception $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
