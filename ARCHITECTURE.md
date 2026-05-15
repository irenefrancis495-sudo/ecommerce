# 🏗️ User Activities System Architecture

## System Diagram

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                          USER INTERACTION LAYER                             │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  🔐 Auth          🛒 Shopping        👀 Discovery      🔍 Search          │
│  (Login/Logout)   (Cart/Checkout)    (Products/Pages)  (Search Queries)    │
│         │               │                  │                 │             │
└─────────┼───────────────┼──────────────────┼─────────────────┼─────────────┘
          │               │                  │                 │
          ▼               ▼                  ▼                 ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                      LOGGING INTEGRATION LAYER                              │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  ✏️ api/auth.php              ✏️ pages/cart_*.php                          │
│     ├─ logLogin()                ├─ logAddToCart()                         │
│     └─ logLogout()               ├─ logRemoveFromCart()                    │
│                                  └─ logUpdateCartItem()                    │
│                                                                             │
│  ✏️ api/checkout.php          ✨ api/track_*.php                           │
│     └─ logCheckout()             ├─ track_page_view.php                    │
│                                  └─ track_product_view.php                 │
│                                                                             │
│                      🔥 ActivityLogger Class                               │
│                   (utils/ActivityLogger.php)                               │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
          │
          │ All activities flow through ActivityLogger
          │
          ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                       DATABASE PERSISTENCE LAYER                            │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  ┌─────────────────────┐  ┌──────────────────────┐                        │
│  │ user_activities     │  │ user_sessions        │                        │
│  ├─────────────────────┤  ├──────────────────────┤                        │
│  │ • id                │  │ • id                 │                        │
│  │ • user_id (FK)      │  │ • user_id (FK)       │                        │
│  │ • activity          │  │ • session_id         │                        │
│  │ • entity_type       │  │ • ip_address         │                        │
│  │ • entity_id         │  │ • login_time         │                        │
│  │ • data (JSON)       │  │ • logout_time        │                        │
│  │ • ip_address        │  │ • is_active          │                        │
│  │ • user_agent        │  └──────────────────────┘                        │
│  │ • created_at        │                                                  │
│  └─────────────────────┘                                                  │
│                                                                             │
│  ┌─────────────────────┐  ┌──────────────────────┐                        │
│  │ product_views       │  │ search_queries       │                        │
│  ├─────────────────────┤  ├──────────────────────┤                        │
│  │ • id                │  │ • id                 │                        │
│  │ • product_id (FK)   │  │ • user_id (FK)       │                        │
│  │ • user_id (FK)      │  │ • query              │                        │
│  │ • view_count        │  │ • results_count      │                        │
│  │ • last_viewed       │  │ • ip_address         │                        │
│  │ • ip_address        │  │ • created_at         │                        │
│  └─────────────────────┘  └──────────────────────┘                        │
│                                                                             │
│                   📊 MySQL Database (mpemba_db)                            │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
          │
          │ Activity data retrieved
          │
          ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                        RETRIEVAL & DISPLAY LAYER                            │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  ✨ pages/admin/user-activities.php                                        │
│     ├─ ActivityLogger::getUserActivities()                                 │
│     ├─ ActivityLogger::getUserActivityStats()                              │
│     └─ Display beautiful dashboard with:                                   │
│         • Activity timeline                                                │
│         • Activity statistics                                              │
│         • Color-coded badges                                               │
│         • User information                                                 │
│         • IP addresses                                                     │
│         • Device info                                                      │
│                                                                             │
│  ✨ api/user_activities.php                                                │
│     └─ JSON API for programmatic access                                    │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## Data Flow Examples

### Example 1: User Adds Product to Cart

```
Step 1: User clicks "Add to Cart"
        │
        ├─→ pages/cart_add.php processes request
        │
Step 2: Utility::addToCart() saves to database
        │
Step 3: ActivityLogger::logAddToCart() called with:
        ├─ user_id: 42
        ├─ product_id: 123
        └─ quantity: 2
        │
Step 4: INSERT into user_activities:
        {
          user_id: 42,
          activity: "add_to_cart",
          entity_type: "product",
          entity_id: 123,
          data: {"quantity": 2},
          ip_address: "192.168.1.100",
          user_agent: "Mozilla/5.0...",
          created_at: NOW()
        }
        │
Step 5: Admin can view via dashboard
        │
        └─→ /admin/user-activities?user_id=42
            Shows: "add_to_cart - product #123 - 2 items - 192.168.1.100"
```

### Example 2: User Logs In

```
Step 1: User submits login form
        │
        ├─→ api/auth.php authenticates
        │
Step 2: Session created successfully
        │
Step 3: ActivityLogger::logLogin() called
        │
Step 4: INSERT into user_activities + user_sessions
        │
Step 5: User can be tracked for entire session
        │
Step 6: On logout: ActivityLogger::logLogout()
        │
        └─→ Complete session lifecycle tracked
```

---

## Method Invocation Chain

```
User Action
    │
    ├─→ Controller/Page receives request
    │       │
    │       ├─→ Processes business logic
    │       │
    │       └─→ Calls ActivityLogger static method
    │               │
    │               ├─→ ActivityLogger::log()
    │               │       │
    │               │       ├─→ Collects metadata (IP, User Agent)
    │               │       │
    │               │       ├─→ Calls safeQuery()
    │               │       │
    │               │       └─→ INSERT into user_activities
    │               │               │
    │               │               └─→ Returns true/false
    │               │
    │               └─→ Returns to calling code
    │
    └─→ User experience continues
            (Activity silently logged in background)
```

---

## Class Hierarchy

```
┌─────────────────────────────────────────────┐
│     Mpemba\Utils\ActivityLogger             │
├─────────────────────────────────────────────┤
│                                             │
│ Public Static Methods:                      │
│  • log()                                    │
│  • logLogin()                               │
│  • logLogout()                              │
│  • logProductView()                         │
│  • logAddToCart()                           │
│  • logRemoveFromCart()                      │
│  • logUpdateCartItem()                      │
│  • logCheckout()                            │
│  • logPageView()                            │
│  • logFeedback()                            │
│  • logSearch()                              │
│  • getUserActivities()                      │
│  • getUserActivityStats()                   │
│                                             │
│ Private Static Methods:                     │
│  • getClientIp()                            │
│                                             │
└─────────────────────────────────────────────┘
```

---

## Request-Response Cycle for Dashboard

```
Admin Browser
    │
    └─→ GET /admin/user-activities?user_id=42
        │
        ├─→ PHP processes request
        │   ├─→ Check admin permission
        │   ├─→ Get user info
        │   ├─→ Call ActivityLogger::getUserActivities(42, 100)
        │   ├─→ Call ActivityLogger::getUserActivityStats(42, '30')
        │   └─→ Render HTML dashboard
        │
        └─→ Response: Beautiful dashboard with:
            ├─ User profile info
            ├─ 30-day activity statistics
            ├─ Activity timeline (100 latest)
            ├─ Color-coded activity badges
            ├─ IP addresses
            ├─ Timestamps
            └─ Device info
```

---

## Integration Points Map

```
Authentication Module
    ├─ api/auth.php
    │   ├─ Login flow
    │   │   └─→ ActivityLogger::logLogin()
    │   └─ Logout flow
    │       └─→ ActivityLogger::logLogout()

Shopping Module
    ├─ pages/cart_add.php
    │   └─→ ActivityLogger::logAddToCart()
    ├─ pages/cart_remove.php
    │   └─→ ActivityLogger::logRemoveFromCart()
    ├─ pages/cart_update.php
    │   └─→ ActivityLogger::logUpdateCartItem()
    └─ api/checkout.php
        └─→ ActivityLogger::logCheckout()

Discovery Module
    ├─ api/track_product_view.php
    │   └─→ ActivityLogger::logProductView()
    └─ api/track_page_view.php
        └─→ ActivityLogger::logPageView()

Search Module
    └─ (Prepared for integration)
        └─→ ActivityLogger::logSearch()

Admin Module
    └─ pages/admin/user-activities.php
        ├─ ActivityLogger::getUserActivities()
        └─ ActivityLogger::getUserActivityStats()
```

---

## Database Relationships

```
users (1) ─────── (Many) user_activities
  │                        │
  │                        ├─→ activity VARCHAR
  │                        ├─→ entity_type VARCHAR
  │                        ├─→ entity_id INT
  │                        ├─→ data JSON
  │                        └─→ created_at TIMESTAMP
  │
  ├─────────── (1) user_sessions (1) ─────────── (Many) user_activities
  │
  └─────────── (Many) product_views (1) ─────────── (Many) products
               │
               └─→ view_count INT
                   last_viewed TIMESTAMP
```

---

## Technology Stack Visualization

```
┌──────────────────────────────────────────┐
│ Frontend Layer (Tailwind CSS)            │
│ • Beautiful admin dashboard              │
│ • Color-coded badges                     │
│ • Responsive tables                      │
│ • User-friendly interface                │
└──────────────────────────────────────────┘
             ↓
┌──────────────────────────────────────────┐
│ PHP Application Layer (PHP 8.5.5)        │
│ • ActivityLogger utility class           │
│ • Integration points in controllers      │
│ • API endpoints                          │
│ • Admin pages                            │
└──────────────────────────────────────────┘
             ↓
┌──────────────────────────────────────────┐
│ Data Access Layer (Doctrine DBAL)        │
│ • Query abstraction                      │
│ • Parameter binding                      │
│ • Error handling                         │
└──────────────────────────────────────────┘
             ↓
┌──────────────────────────────────────────┐
│ Database Layer (MySQL)                   │
│ • 4 activity tracking tables             │
│ • Proper indexing                        │
│ • Foreign key relationships              │
│ • Query optimization                     │
└──────────────────────────────────────────┘
```

---

## Status Dashboard

```
✅ Database Layer          Ready
✅ Logger Class            Ready
✅ Integration Points      Ready
✅ Admin Dashboard         Ready
✅ API Endpoints           Ready
✅ Documentation           Complete
✅ Migration Script        Executed
✅ Testing                 Ready

🎉 SYSTEM OPERATIONAL 🎉
```

---

**Architecture Version**: 1.0  
**Status**: ✨ Production Ready
