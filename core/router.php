<?php
namespace Core;

class Router {
    public static $currentRoute;
    public static $controller;
    public static $action;
    
    public static function initialize() {
        $defaultRoute = 'home/index';
        
        $currentRoute      = empty($_GET['route']) ? $defaultRoute : $_GET['route'];
        $currentRouteParts = explode('/', $currentRoute);
        
        $controller = ucwords($currentRouteParts[0]);
        $action     = empty($currentRouteParts[1]) ? 'index' : $currentRouteParts[1];
        
        $controllerName = '\\App\\Controllers\\' . $controller . 'Controller';
        
        self::setter($currentRoute, $controller, $action);

        if(!class_exists($controllerName)) {
            $c = new Controller();
            $c->error404();
        }
        
        $controller = new $controllerName();
        
        if(!method_exists($controller, $action)) {
            $c = new Controller();
            $c->error404();
        }
        
        $controller->{$action}();
    }
    
    private static function setter($currentRoute, $controller, $action) {
        self::$currentRoute = $currentRoute;
        self::$controller = $controller;
        self::$action = $action;
    }    
}