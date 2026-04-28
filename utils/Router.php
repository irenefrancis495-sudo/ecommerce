<?php
namespace Mpemba\Utils;
class Router{

public static function load(){
    $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

if ($path == "admin.php") {
    $path = "admin"; 
} else {
    $path = ($path == "") ? "home" : $path;
}


$controllerFile = "pages/" . $path . ".php";

if (file_exists($controllerFile)) {
    include $controllerFile; 
} else {
    echo "Page not found!";
}

}

public static function getPathName
(string $name = 'My Application'):string
{
    return $name;
}
}
?>