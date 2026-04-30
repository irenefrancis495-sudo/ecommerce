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
            $path = 'home';
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
            '' => 'Mpemba Store - Home',
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
        ];

        return $pageNames[$path] ?? $default;
    }
}
?>