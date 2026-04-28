<?php
namespace Mpemba\Entity;

class Router {
    public static function load() {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        if ($path === '') {
            $path = 'splash';
        } elseif ($path === 'home') {
            $path = 'home';
        }

        $controllerFile = __DIR__ . '/../pages/' . $path . '.php';
        if (!file_exists($controllerFile)) {
            $directoryIndex = __DIR__ . '/../pages/' . $path . '/index.php';
            if (is_dir(__DIR__ . '/../pages/' . $path) && file_exists($directoryIndex)) {
                $controllerFile = $directoryIndex;
            }
        }

        if (!file_exists($controllerFile)) {
            $fallback = __DIR__ . '/../' . $path . '.php';
            if (file_exists($fallback)) {
                include $fallback;
                return;
            }
        }

        if (file_exists($controllerFile)) {
            include $controllerFile;
        } else {
            http_response_code(404);
            echo '<h1>Page not found</h1><p>The requested page could not be found.</p>';
        }
    }

    public static function getPathName(string $name = 'Mpemba Marketplace'): string {
        return $name;
    }
}
?>