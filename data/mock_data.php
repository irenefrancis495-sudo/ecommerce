<?php
// Extended mock data for admin dashboard and API
$stats = [
    ['label' => 'Total Orders', 'val' => 450, 'icon' => 'fa-shopping-cart'],
    ['label' => 'Total Customers', 'val' => 955, 'icon' => 'fa-users'],
    ['label' => 'Total Revenue', 'val' => 50000, 'icon' => 'fa-wallet'],
    ['label' => 'Total Products', 'val' => 250, 'icon' => 'fa-boxes'],
    ['label' => 'Active Admins', 'val' => 3, 'icon' => 'fa-user-shield'],
];

$top_selling = [
    ['id'=>501, 'name' => 'Smartphone X', 'qty' => 320, 'price' => 750000, 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&auto=format&fit=crop&q=60'],
    ['id'=>502, 'name' => 'Laptop Pro 15"', 'qty' => 210, 'price' => 2200000, 'img' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&auto=format&fit=crop&q=60'],
    ['id'=>503, 'name' => '4K LED TV 55"', 'qty' => 180, 'price' => 1800000, 'img' => 'https://images.unsplash.com/photo-1585386959984-a415522b4e9b?w=800&auto=format&fit=crop&q=60'],
];

$products = [
    ['id'=>501,'name'=>'Smartphone X','price'=>750000,'stock'=>120,'category'=>'Electronics','img'=>'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&auto=format&fit=crop&q=60'],
    ['id'=>502,'name'=>'Laptop Pro 15"','price'=>2200000,'stock'=>60,'category'=>'Electronics','img'=>'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&auto=format&fit=crop&q=60'],
    ['id'=>503,'name'=>'4K LED TV 55"','price'=>1800000,'stock'=>30,'category'=>'Electronics','img'=>'https://images.unsplash.com/photo-1585386959984-a415522b4e9b?w=800&auto=format&fit=crop&q=60'],
    ['id'=>504,'name'=>'Wireless Earbuds','price'=>120000,'stock'=>200,'category'=>'Electronics','img'=>'https://images.unsplash.com/photo-1511367461989-f85a21fda167?w=800&auto=format&fit=crop&q=60'],
    ['id'=>505,'name'=>'Smartwatch Series 5','price'=>350000,'stock'=>95,'category'=>'Electronics','img'=>'https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?w=800&auto=format&fit=crop&q=60'],
];

$customers = [
    ['id'=>201,'name'=>'Alice Smith','email'=>'alice@example.com','joined'=>'2024-02-10'],
    ['id'=>202,'name'=>'Bob Johnson','email'=>'bob@example.com','joined'=>'2024-03-21'],
    ['id'=>203,'name'=>'Carla White','email'=>'carla@example.com','joined'=>'2024-04-01'],
    
];

$orders = [
    ['id'=>301,'customer'=>'Alice Smith','total'=>24.99,'status'=>'delivered','date'=>'2024-04-20'],
    ['id'=>302,'customer'=>'Bob Johnson','total'=>12.49,'status'=>'on_delivery','date'=>'2024-04-21'],
    ['id'=>303,'customer'=>'Carla White','total'=>36.00,'status'=>'cancelled','date'=>'2024-04-22'],
    ['id'=>304,'customer'=>'Alice Smith','total'=>18.50,'status'=>'delivered','date'=>'2024-04-23'],
];

function get_stats() { global $stats; return $stats; }
function get_top_selling() { global $top_selling; return $top_selling; }
function get_products() { global $products; return $products; }
function get_customers() { global $customers; return $customers; }
function get_orders() { global $orders; return $orders; }

// helper: returns revenue timeseries for charts
function get_revenue_series() {
    // simple mock monthly revenue
    return [1200, 2400, 3800, 4500, 5200, 4800, 6100, 7000, 6900, 7200, 8000, 9000];
}

?>
