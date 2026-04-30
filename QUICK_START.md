# Quick Start Guide

## 5-Minute Setup

### Step 1: Configure Database (1 min)
```bash
cd dee
cp .env.example .env
# Edit .env with your database credentials
```

### Step 2: Install Dependencies (1 min)
```bash
composer install
```

### Step 3: Initialize Database (1 min)
```bash
php database/setup.php
```

### Step 4: Seed Sample Data (1 min)
```bash
php database/seed.php
```

### Step 5: Start Using API (1 min)
```bash
# Test the API
curl http://localhost/dee/api/products

# Login (from seed data)
curl -X POST http://localhost/dee/api/login \
  -H "Content-Type: application/json" \
  -d '{"username": "admin", "password": "admin123"}'
```

## Common Tasks

### Add New Product
```php
use Mpemba\Entity\Product;

$product = new Product(null, "Product Name", 99.99);
$product->description = "Description";
$product->stock_quantity = 50;
$product->save();
```

### Get Cart Total
```php
use Mpemba\Entity\CartItem;

$items = CartItem::findByUserId($userId);
$total = 0;
foreach ($items as $item) {
    $total += $item->getSubtotal();
}
```

### Create Order
```php
use Mpemba\Entity\Order;

$order = new Order(null, $userId, $totalAmount, 'pending');
$order->save();
```

## API Response Format

All responses are JSON:

### Success
```json
{
  "status": "success",
  "data": { ... },
  "message": "Operation completed"
}
```

### Error
```json
{
  "status": "error",
  "message": "Error description"
}
```

## Testing Credentials
After running `seed.php`:
- **Admin**: username: `admin` | password: `admin123`
- **Customer**: username: `john_doe` | password: `password123`

## Next: Frontend Integration
See [BACKEND_SETUP.md](BACKEND_SETUP.md) for complete documentation.
