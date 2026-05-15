# 📊 User Activities Database Integration - Complete Guide

## Overview
All user activities in the Mpemba Marketplace are now fully connected to the database and tracked in real-time. This provides comprehensive insights into user behavior, engagement patterns, and system usage.

## 🗄️ Database Tables Created

### 1. **user_activities** (Main Activity Log)
Tracks all user interactions across the platform.

```sql
- id: Primary key
- user_id: Reference to users table (nullable for anonymous)
- activity: Activity type (login, logout, view_product, add_to_cart, etc.)
- entity_type: Type of entity (product, order, page, etc.)
- entity_id: ID of the affected entity
- data: JSON object with additional context
- ip_address: User's IP address
- user_agent: Browser/device information
- created_at: Timestamp
```

### 2. **user_sessions**
Tracks active user sessions and login/logout history.

```sql
- id: Primary key
- user_id: Reference to users table
- session_id: Unique session identifier
- ip_address: Login IP
- user_agent: Device information
- login_time: When session started
- last_activity: Last recorded activity
- logout_time: When user logged out
- is_active: Boolean flag for active sessions
```

### 3. **product_views**
Detailed product view tracking with view counts.

```sql
- id: Primary key
- product_id: Reference to products table
- user_id: Reference to users table (nullable)
- view_count: Total views by this user
- last_viewed: Timestamp of last view
- ip_address: Viewer's IP
```

### 4. **search_queries**
Tracks search behavior and queries.

```sql
- id: Primary key
- user_id: Reference to users table
- query: Search query text
- results_count: Number of results returned
- ip_address: Searcher's IP
- created_at: Timestamp
```

## 🔧 Tracked Activities

### Authentication
- `login` - User logs in
- `logout` - User logs out

### Shopping
- `view_product` - User views product details
- `add_to_cart` - User adds item to cart
- `remove_from_cart` - User removes item from cart
- `update_cart` - User updates cart quantity
- `checkout` - User completes purchase

### Navigation
- `page_view` - User visits a page
- `search` - User performs a search

### Engagement
- `submit_feedback` - User leaves feedback/comment
- `subscribe` - User subscribes to newsletter

## 📁 New Files Created

### Core Logger
- **`utils/ActivityLogger.php`** - Main activity logging class with static methods

### API Endpoints
- **`api/track_page_view.php`** - Track page visits
- **`api/track_product_view.php`** - Track product views
- **`api/user_activities.php`** - Get user's activity history
- **`api/auth.php`** - Updated with activity logging

### Admin Dashboard
- **`pages/admin/user-activities.php`** - Admin interface to view user activities

### Database
- **`database_schema_activities.sql`** - SQL migration for activity tables
- **`migrate_activities.php`** - PHP migration script (already executed)

## 🔧 Updated Files

All the following files now include activity logging:

1. **`pages/cart_add.php`** - Logs add to cart
2. **`pages/cart_remove.php`** - Logs remove from cart
3. **`pages/cart_update.php`** - Logs cart updates
4. **`api/checkout.php`** - Logs checkout completion
5. **`api/auth.php`** - Logs logout activity

## 💻 Usage Examples

### Logging an Activity
```php
use Mpemba\Utils\ActivityLogger;

// Simple activity
ActivityLogger::log($userId, 'custom_action', 'entity_type', $entityId);

// With additional data
ActivityLogger::log($userId, 'purchase', 'order', $orderId, [
    'amount' => 99.99,
    'items' => 5
]);
```

### Convenience Methods
```php
ActivityLogger::logLogin($userId);
ActivityLogger::logLogout($userId);
ActivityLogger::logProductView($productId, $userId);
ActivityLogger::logAddToCart($userId, $productId, $quantity);
ActivityLogger::logCheckout($userId, $orderId, $total);
ActivityLogger::logPageView($userId, '/home', $referrer);
ActivityLogger::logSearch($userId, 'nike shoes', $resultsCount);
```

### Retrieving Activities
```php
// Get user's activity history (last 50 activities)
$activities = ActivityLogger::getUserActivities($userId, 50);

// Get activity statistics (last 7 days)
$stats = ActivityLogger::getUserActivityStats($userId, '7');
```

## 🎯 Admin Dashboard

Access the admin dashboard at: `/admin/user-activities`

### Features:
- ✅ Search users by user ID
- ✅ View activity timeline for selected user
- ✅ See activity statistics (last 30 days)
- ✅ View IP addresses and user agents
- ✅ Filter by activity type with color-coded badges
- ✅ Timestamps for all activities

### Activity Badges:
- 🟦 **Blue**: Login, Add to Cart, Search
- 🟥 **Red**: Logout
- 🟨 **Yellow**: Remove from Cart, Update Cart
- 🟩 **Green**: Checkout, Purchase
- 🟪 **Purple**: View Product
- 🟦 **Indigo**: Page View

## 📊 Queries You Can Run

### Get top products viewed by users
```sql
SELECT p.id, p.name, COUNT(pv.id) as view_count 
FROM product_views pv
JOIN products p ON pv.product_id = p.id
GROUP BY p.id
ORDER BY view_count DESC
LIMIT 10;
```

### Get most active users (by activity count)
```sql
SELECT user_id, COUNT(*) as activity_count 
FROM user_activities 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY user_id
ORDER BY activity_count DESC
LIMIT 10;
```

### Get popular search queries
```sql
SELECT query, COUNT(*) as search_count, AVG(results_count) as avg_results
FROM search_queries
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY query
ORDER BY search_count DESC
LIMIT 20;
```

### Get user's daily activity count
```sql
SELECT DATE(created_at) as date, COUNT(*) as activity_count
FROM user_activities
WHERE user_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY DATE(created_at)
ORDER BY date DESC;
```

## 🔐 Privacy & Security

- Activity logs store IP addresses for fraud detection
- User agent information helps identify suspicious behavior
- Anonymous tracking for non-logged-in users
- All data stored in database with proper foreign keys
- Activity data can be purged by admin if needed

## 🚀 Future Enhancements

Possible additions:
- Real-time activity dashboard with charts
- Activity export to CSV/PDF
- User behavior analytics and heatmaps
- Anomaly detection for suspicious activities
- Performance analytics and bottleneck identification
- User journey funnel analysis
- A/B testing event tracking

## ✅ Verification Steps

To verify the activity tracking is working:

1. **Check Tables Created**
   ```bash
   php migrate_activities.php
   ```

2. **Login/Logout** and verify activities are logged
   - Go to `/login` and login
   - Check admin dashboard at `/admin/user-activities`

3. **Add Products to Cart**
   - Browse products and add to cart
   - View activities in admin dashboard

4. **Complete Checkout**
   - Place an order
   - Verify checkout activity is logged

5. **Check Database Directly**
   ```sql
   SELECT * FROM user_activities ORDER BY created_at DESC LIMIT 10;
   SELECT * FROM user_sessions WHERE is_active = 1;
   SELECT * FROM product_views ORDER BY last_viewed DESC LIMIT 10;
   ```

## 📞 Support

For issues or questions:
1. Check ActivityLogger.php for available methods
2. Review the admin dashboard for activity visualization
3. Check database logs for errors

---

**Status**: ✅ **COMPLETE** - All user activities connected to database!
**Date Implemented**: May 14, 2026
**Version**: 1.0
