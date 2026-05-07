<?php
namespace Mpemba\Utils;

class Router {
    public static function load() {

    if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg)$/', $_SERVER["REQUEST_URI"])) {
    echo "<!-- ROUTER: serving static file -->\n";
    return false; // serve the requested resource as-is
}
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Remove base path if needed
        $basePath = 'dee';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath) + 1); // +1 for the slash
        }

        if ($path === '') {
            $path = 'splash';
        }

        // Check if it's a direct page request
        $pageFile = __DIR__ . '/../pages/' . $path . '.php';
        if (file_exists($pageFile)) {
            include $pageFile;
            return;
        }

        // Default to home page
        $homeFile = __DIR__ . '/../pages/home.php';
        if (file_exists($homeFile)) {
            include $homeFile;
        } else {
            http_response_code(404);
            echo '<h1>Page not found</h1><p>The requested page could not be found.</p>';
        }
        
    }

    public static function getPathName(string $default = 'Mpemba Marketplace'): string {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // For requests like /login, /cart, etc.
        $pageNames = [
            '' => 'Welcome - Mpemba Store',
            'splash' => 'Welcome - Mpemba Store',
            'home' => 'Home - Mpemba Store',
            'products' => 'All Products - Mpemba Store',
            'login' => 'Login - Mpemba Store',
            'register' => 'Register - Mpemba Store',
            'cart' => 'Shopping Cart - Mpemba Store',
            'category' => 'Categories - Mpemba Store',
            'product-details' => 'Product Details - Mpemba Store',
            'order-status' => 'Order Status - Mpemba Store',
            'user' => 'My Account - Mpemba Store',
            'natural-beauty' => 'Natural Beauty - Mpemba Store',
            'atelier-electronics' => 'Atelier Electronics - Mpemba Store',
            'heritage-fashion' => 'Heritage Fashion - Mpemba Store',
            'sanctuary-home' => 'Sanctuary Home - Mpemba Store',
            'lifestyle-essentials' => 'Lifestyle Essentials - Mpemba Store',
            'splash' => 'Welcome - Mpemba Store',
            'admin/index' => 'Admin Dashboard - Mpemba',
            'admin/inventory' => 'Inventory Console - Mpemba Heritage',
            'admin/orders' => 'Orders Registry - Mpemba Admin',
            'admin/customers' => 'Customers - Mpemba Admin',
            'admin/reports' => 'Reports - Mpemba Admin',
            'admin/settings' => 'Settings Hub - Mpemba Admin',
            'admin/add-product' => 'Add Product - Mpemba Admin',
            'admin/login' => 'Admin Login - Mpemba',
            'about-us' => 'About Us - Mpemba Store',
            'privacy-policy' => 'Privacy Policy - Mpemba Store',
            'blog' => 'Blog - Mpemba Store',
            'contact' => 'Contact Us - Mpemba Store',
                    'admin/messages' => 'Messages - Mpemba Admin',
                    'admin/subscribers' => 'Subscribers - Mpemba Admin',
                    'admin/categories' => 'Categories - Mpemba Admin',
                    'admin/permissions' => 'Permissions - Mpemba Admin',
        ];

        return $pageNames[$path] ?? $default;
    }

    public static function getCurrentRoute(): string {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        $basePath = 'dee';
        if (strpos($path, $basePath) === 0) {
            $path = ltrim(substr($path, strlen($basePath)), '/');
        }

        if ($path === '') {
            return 'splash';
        }

        if ($path === 'admin') {
            return 'admin/index';
        }

        return $path;
    }

    public static function getMenuRoutes(string $context = 'main'): array {
        $mainRoutes = [
            [
                'key' => 'home',
                'href' => '/home',
                'label' => 'Home',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'products',
                'href' => '/products',
                'label' => 'Products',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'category',
                'href' => '/category',
                'label' => 'Categories',
                'disabled' => false,
                'children' => [],
            ],
        ];

        $adminRoutes = [
            [
                'key' => 'admin/index',
                'href' => '/admin/index',
                'label' => 'Dashboard',
                'icon' => 'dashboard',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'admin/inventory',
                'href' => '/admin/inventory',
                'label' => 'Inventory',
                'icon' => 'inventory_2',
                'disabled' => false,
                'children' => [
                    [
                        'key' => 'admin/add-product',
                        'href' => '/admin/add-product',
                        'label' => 'Add Product',
                        'disabled' => false,
                        'children' => [],
                    ],
                ],
            ],
            [
                'key' => 'admin/orders',
                'href' => '/admin/orders',
                'label' => 'Orders',
                'icon' => 'shopping_cart',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'admin/customers',
                'href' => '/admin/customers',
                'label' => 'Users',
                'icon' => 'group',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'admin/messages',
                'href' => '/admin/messages',
                'label' => 'Messages',
                'icon' => 'mail',
                'disabled' => false,
                'children' => [
                    [
                        'key' => 'admin/feedback',
                        'href' => '/admin/feedback',
                        'label' => 'Feedback',
                        'disabled' => false,
                        'children' => [],
                    ],
                    [
                        'key' => 'admin/subscribers',
                        'href' => '/admin/subscribers',
                        'label' => 'Subscribers',
                        'disabled' => false,
                        'children' => [],
                    ],
                    [
                        'key' => 'admin/newsletters',
                        'href' => '/admin/newsletters',
                        'label' => 'Newsletters',
                        'disabled' => true,
                        'children' => [],
                    ],
                ],
            ],
            [
                'key' => 'admin/reports',
                'href' => '/admin/reports',
                'label' => 'Analytics',
                'icon' => 'analytics',
                'disabled' => false,
                'children' => [
                    [
                        'key' => 'admin/permissions',
                        'href' => '/admin/permissions',
                        'label' => 'Permissions',
                        'disabled' => false,
                        'children' => [],
                    ],
                    [
                        'key' => 'admin/shipping',
                        'href' => '/admin/shipping',
                        'label' => 'Shipping',
                        'disabled' => true,
                        'children' => [],
                    ],
                ],
            ],
            [
                'key' => 'admin/settings',
                'href' => '/admin/settings',
                'label' => 'Settings',
                'icon' => 'settings',
                'disabled' => false,
                'children' => [],
            ],
        ];

        return $context === 'admin' ? $adminRoutes : $mainRoutes;
    }

    public static function isRouteActive(array $route, string $currentRoute): bool {
        if ($route['key'] === $currentRoute) {
            return true;
        }

        if (!empty($route['children'])) {
            foreach ($route['children'] as $child) {
                if (self::isRouteActive($child, $currentRoute)) {
                    return true;
                }
            }
        }

        return false;
    }
}
?>