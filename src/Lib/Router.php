<?php
namespace Lib;
use Controllers\ErrorController;
// para almacenar las rutas que configuremos desde el archivo index.php
class Router
{

    private static $routes = [];
    //para ir añadiendo los métodos y las rutas en el tercer parámetro.
    public static function add(string $method, string $action, callable $controller): void
    {
        //die($action);
        $action = trim($action, '/');

        self::$routes[$method][$action] = $controller;

    }

    // Este método se encarga de obtener el sufijo de la URL que permitirá seleccionar
    // la ruta y mostrar el resultado de ejecutar la función pasada al metodo add para esa ruta
    // usando call_user_func()
    public static function dispatch():void {
        $method = $_SERVER['REQUEST_METHOD'];
        $action = preg_replace('/Tienda/', '', $_SERVER['REQUEST_URI']);
        $action = trim($action, '/');
    
        $param = null;
        $parts = explode('/', $action);
        if (count($parts) > 1) {
            $param = end($parts);
            $action = str_replace($param, ':token', $action);
        }
    
        $fn = self::$routes[$method][$action] ?? null;
    
        if ($fn) {
            $callback = self::$routes[$method][$action];
            echo call_user_func($callback, $param);
        } else {
            ErrorController::error404();
        }
    }
}