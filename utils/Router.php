<?php
namespace Mpemba\Utils;

use Mpemba\Utils\Utility;

class Router {
    public static function load() {
        if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg)$/', $_SERVER["REQUEST_URI"])) {
            echo "<!-- ROUTER: serving static file -->\n";
            return false; // serve the requested resource as-is
        }

        $rawPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $normalizedPath = self::normalizePath(self::removeBasePath($rawPath));

        // Check if it's a direct page request first
        $pageFile = __DIR__ . '/../pages/' . $normalizedPath . '.php';
        if (file_exists($pageFile)) {
            include $pageFile;
            return;
        }

        // Try to resolve nested routes using the menu route tree
        $route = self::getRouteByPath($normalizedPath);
        if ($route !== null) {
            $routePage = $route['page'] ?? null;
            if ($routePage && file_exists(__DIR__ . '/../pages/' . $routePage)) {
                self::injectRouteParameters($route, $normalizedPath);
                include __DIR__ . '/../pages/' . $routePage;
                return;
            }
        }

        // Fallback to admin nested page path
        $adminPageFile = __DIR__ . '/../pages/' . $normalizedPath . '.php';
        if (file_exists($adminPageFile)) {
            include $adminPageFile;
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
        $rawPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $normalizedPath = self::normalizePath(self::removeBasePath($rawPath));

        $route = self::getRouteByPath($normalizedPath);
        if ($route !== null && !empty($route['title'])) {
            return $route['title'];
        }

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
            'admin/index' => 'Admin Dashboard - Mpemba',
            'admin/inventory' => 'Inventory Console - Mpemba Heritage',
            'admin/orders' => 'Orders Registry - Mpemba Admin',
            'admin/customers' => 'Customers - Mpemba Admin',
            'admin/reports' => 'Reports - Mpemba Admin',
            'admin/settings' => 'Settings Hub - Mpemba Admin',
            'admin/add-product' => 'Add Product - Mpemba Admin',
            'about-us' => 'About Us - Mpemba Store',
            'privacy-policy' => 'Privacy Policy - Mpemba Store',
            'blog' => 'Blog - Mpemba Store',
            'contact' => 'Contact Us - Mpemba Store',
            'admin/messages' => 'Messages - Mpemba Admin',
            'admin/subscribers' => 'Subscribers - Mpemba Admin',
            'admin/categories' => 'Categories - Mpemba Admin',
            'admin/permissions' => 'Permissions - Mpemba Admin',
            'admin/shipping' => 'Shipping - Mpemba Admin',
        ];

        return $pageNames[$normalizedPath] ?? $default;
    }

    public static function getCurrentRoute(): string {
        $rawPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $normalizedPath = self::normalizePath(self::removeBasePath($rawPath));

        if ($normalizedPath === 'admin') {
            return 'admin/index';
        }

        return $normalizedPath;
    }

    public static function getMenuRoutes(string $context = 'main'): array {
    
    // $menuItems = Utility::safeQuery("
    // SELECT p.name AS title, p.link AS href,
    // FROM menu p WHERE p.parent_id IS NULL
    // ");


    // if(empty($menuItems)){
    //   return [];
    // }

    //   $menus = self::packChildrens($menuItems);
    
    $mainRoutes = [
            [
                'key' => 'home',
                'href' => '/home',
                'label' => 'Home',
                'page' => 'home.php',
                'title' => 'Home - Mpemba Store',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'products',
                'href' => '/products',
                'label' => 'Products',
                'page' => 'products.php',
                'title' => 'All Products - Mpemba Store',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'category',
                'href' => '/category',
                'label' => 'Categories',
                'page' => 'category.php',
                'title' => 'Categories - Mpemba Store',
                'disabled' => false,
                'children' => [
                    [
                        'key' => 'category/natural-beauty',
                        'parent' => 'category',
                        'href' => '/category/natural-beauty',
                        'label' => 'Natural Beauty',
                        'page' => 'category.php',
                        'title' => 'Natural Beauty - Mpemba Store',
                        'disabled' => false,
                        'meta' => [
                            'category_slug' => 'natural-beauty',
                            'category_label' => 'Natural Beauty',
                        ],
                        'children' => [],
                    ],
                    [
                        'key' => 'category/atelier-electronics',
                        'parent' => 'category',
                        'href' => '/category/atelier-electronics',
                        'label' => 'Atelier Electronics',
                        'page' => 'category.php',
                        'title' => 'Atelier Electronics - Mpemba Store',
                        'disabled' => false,
                        'meta' => [
                            'category_slug' => 'atelier-electronics',
                            'category_label' => 'Atelier Electronics',
                        ],
                        'children' => [],
                    ],
                    [
                        'key' => 'category/heritage-fashion',
                        'parent' => 'category',
                        'href' => '/category/heritage-fashion',
                        'label' => 'Heritage Fashion',
                        'page' => 'category.php',
                        'title' => 'Heritage Fashion - Mpemba Store',
                        'disabled' => false,
                        'meta' => [
                            'category_slug' => 'heritage-fashion',
                            'category_label' => 'Heritage Fashion',
                        ],
                        'children' => [],
                    ],
                    [
                        'key' => 'category/sanctuary-home',
                        'parent' => 'category',
                        'href' => '/category/sanctuary-home',
                        'label' => 'Sanctuary Home',
                        'page' => 'category.php',
                        'title' => 'Sanctuary Home - Mpemba Store',
                        'disabled' => false,
                        'meta' => [
                            'category_slug' => 'sanctuary-home',
                            'category_label' => 'Sanctuary Home',
                        ],
                        'children' => [],
                    ],
                    [
                        'key' => 'category/lifestyle-essentials',
                        'parent' => 'category',
                        'href' => '/category/lifestyle-essentials',
                        'label' => 'Lifestyle Essentials',
                        'page' => 'category.php',
                        'title' => 'Lifestyle Essentials - Mpemba Store',
                        'disabled' => false,
                        'meta' => [
                            'category_slug' => 'lifestyle-essentials',
                            'category_label' => 'Lifestyle Essentials',
                        ],
                        'children' => [],
                    ],
                ],
            ],
        ];

        $adminRoutes = [
            [
                'key' => 'admin/index',
                'href' => '/admin/index',
                'label' => 'Dashboard',
                'icon' => 'dashboard',
                'page' => 'admin/index.php',
                'title' => 'Admin Dashboard - Mpemba',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'admin/inventory',
                'href' => '/admin/inventory',
                'label' => 'Inventory',
                'icon' => 'inventory_2',
                'page' => 'admin/inventory.php',
                'title' => 'Inventory Console - Mpemba Heritage',
                'disabled' => false,
                'children' => [
                    [
                        'key' => 'admin/add-product',
                        'parent' => 'admin/inventory',
                        'href' => '/admin/add-product',
                        'label' => 'Add Product',
                        'page' => 'admin/add-product.php',
                        'title' => 'Add Product - Mpemba Admin',
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
                'page' => 'admin/orders.php',
                'title' => 'Orders Registry - Mpemba Admin',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'admin/customers',
                'href' => '/admin/customers',
                'label' => 'Users',
                'icon' => 'group',
                'page' => 'admin/customers.php',
                'title' => 'Customers - Mpemba Admin',
                'disabled' => false,
                'children' => [],
            ],
            [
                'key' => 'admin/messages',
                'href' => '/admin/messages',
                'label' => 'Messages',
                'icon' => 'mail',
                'page' => 'admin/messages.php',
                'title' => 'Messages - Mpemba Admin',
                'disabled' => false,
                'children' => [
                    [
                        'key' => 'admin/feedback',
                        'parent' => 'admin/messages',
                        'href' => '/admin/feedback',
                        'label' => 'Feedback',
                        'page' => 'admin/feedback.php',
                        'title' => 'Feedback - Mpemba Admin',
                        'disabled' => false,
                        'children' => [],
                    ],
                    [
                        'key' => 'admin/subscribers',
                        'parent' => 'admin/messages',
                        'href' => '/admin/subscribers',
                        'label' => 'Subscribers',
                        'page' => 'admin/subscribers.php',
                        'title' => 'Subscribers - Mpemba Admin',
                        'disabled' => false,
                        'children' => [],
                    ],
                    [
                        'key' => 'admin/newsletters',
                        'parent' => 'admin/messages',
                        'href' => '/admin/newsletters',
                        'label' => 'Newsletters',
                        'page' => 'admin/newsletters.php',
                        'title' => 'Newsletters - Mpemba Admin',
                        'disabled' => false,
                        'children' => [],
                    ],
                ],
            ],
            [
                'key' => 'admin/reports',
                'href' => '/admin/reports',
                'label' => 'Analytics',
                'icon' => 'analytics',
                'page' => 'admin/reports.php',
                'title' => 'Reports - Mpemba Admin',
                'disabled' => false,
                'children' => [
                    [
                        'key' => 'admin/permissions',
                        'parent' => 'admin/reports',
                        'href' => '/admin/permissions',
                        'label' => 'Permissions',
                        'page' => 'admin/permissions.php',
                        'title' => 'Permissions - Mpemba Admin',
                        'disabled' => false,
                        'children' => [],
                    ],
                    [
                        'key' => 'admin/shipping',
                        'parent' => 'admin/reports',
                        'href' => '/admin/shipping',
                        'label' => 'Shipping',
                        'page' => 'admin/shipping.php',
                        'title' => 'Shipping - Mpemba Admin',
                        'disabled' => false,
                        'children' => [],
                    ],
                ],
            ],
            [
                'key' => 'admin/settings',
                'href' => '/admin/settings',
                'label' => 'Settings',
                'icon' => 'settings',
                'page' => 'admin/settings.php',
                'title' => 'Settings Hub - Mpemba Admin',
                'disabled' => false,
                'children' => [],
            ],
        ];

        return $context === 'admin' ? $adminRoutes : $mainRoutes;
    }

    public static function flattenRoutes(array $routes): array {
        $flattened = [];
        foreach ($routes as $route) {
            $flattened[$route['key']] = $route;
            if (!empty($route['children'])) {
                $flattened = array_merge($flattened, self::flattenRoutes($route['children']));
            }
        }

        return $flattened;
    }

    public static function getRouteByPath(string $path, string $context = 'main'): ?array {
        $normalizedPath = self::normalizePath($path);
        if ($normalizedPath === 'admin') {
            $normalizedPath = 'admin/index';
        }

        $routes = self::flattenRoutes(self::getMenuRoutes($context));

        if (isset($routes[$normalizedPath])) {
            return $routes[$normalizedPath];
        }

        foreach ($routes as $route) {
            $routeHref = trim($route['href'] ?? '', '/');
            if ($routeHref === $normalizedPath) {
                return $route;
            }
        }

        if ($context === 'main' && strpos($normalizedPath, 'admin/') === 0) {
            return self::getRouteByPath($normalizedPath, 'admin');
        }

        return null;
    }

    public static function injectRouteParameters(array $route, string $path): void {
        $_GET['route'] = $route['key'];
        $_GET['route_path'] = $path;
        if (!empty($route['meta']) && is_array($route['meta'])) {
            foreach ($route['meta'] as $metaKey => $metaValue) {
                $_GET['route_meta_' . $metaKey] = $metaValue;
            }
        }

        $_GET['route_segments'] = explode('/', trim($path, '/'));
    }

    public static function removeBasePath(string $path): string {
        $basePath = 'dee';
        if (strpos($path, $basePath) === 0) {
            return ltrim(substr($path, strlen($basePath)), '/');
        }

        return $path;
    }

    public static function normalizePath(string $path): string {
        $path = trim($path, '/');
        return $path === '' ? 'splash' : $path;
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


    public static function getChildrens($parentKey):array{
        $menuItems = Utility::safeQuery("
        SELECT p.name AS title, p.link AS href,
        FROM menu p WHERE p.parent_id = '$parentKey'
        ");

        return $menuItems;
    }
    public static function packChildrens($parentKey = null):array {
        $items = self::getChildrens($parentKey);

        if(empty($items)){
            return [];
        }

        $grouped = [];
        foreach ($items as $item) {
            $key = $item['key'] ?? null;
            if ($key === null) continue;

            if (isset($item['parent']) && $item['parent'] === $parentKey) {
                $grouped[$item['parent']]['children'][] = $item;
            } else {
                $grouped[$key] = $item + ['children' => []];
            }
        }

        return array_values($grouped);
    }
}
?>