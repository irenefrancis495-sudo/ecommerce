
### ⚙️ Environment Configuration
The application uses a `.env` file for database configuration. 

1. **Copy the template**:
   ```bash
   cp .env.example .env
   ```
2. **Edit `.env`** with your database credentials:
   ```env
   DB_DRIVER=pdo_mysql
   DB_HOST=127.0.0.1
   DB_NAME=your_database
   DB_USER=root
   DB_PASSWORD=
   ```

### Database Creation

```bash
php .\scratch\create_db.php
```

### Database Reset
```bash
php .\scratch\reset_db.php
```

### 🚀 Database Migrations
Database schema changes are managed via Doctrine Migrations.

```bash
# Run all pending migrations
./bin/console migrations:migrate

# Check migration status
./bin/console migrations:status

# Create a new blank migration
./bin/console migrations:generate
```

### 🛠 Utility Class
The `Utility` class provides a simple interface for common database operations using Doctrine DBAL.

#### **Raw Queries**
```php

$results = Utility::safeQuery("SELECT * FROM user");

// Select multiple rows
$results = Utility::safeQuery("SELECT * FROM table_name WHERE status = ?", ['active']);

// Select a single row
$row = Utility::safeQuery("SELECT * FROM table_name WHERE id = ?", [1], 'SELECT', true);

// Custom queries (UPDATE/DELETE)
Utility::safeQuery("UPDATE table_name SET col = ? WHERE id = ?", ['val', 1], 'UPDATE');
```

#### **CRUD Helpers**
```php
// INSERT (returns last insert ID)
$id = Utility::insert('table_name', ['col1' => 'val1', 'col2' => 'val2']);

// UPDATE
Utility::update('table_name', $id, ['col1' => 'new_val']);

// DELETE
Utility::delete('table_name', $id);
```
#

### Notification

### Error
```php
Utility::notify("Adding Product failed","error","Failed");
```

### Success
```php
Utility::notify("Product Added Successfully","success","Success");
```