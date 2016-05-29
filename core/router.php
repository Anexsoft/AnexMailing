<?php
namespace Core;

class Router {
    public static $currentRoute;
    public static $area;
    public static $controller;
    public static $action;
    public static $isAdminArea = false;
    
    public static function initialize() {
        $defaultRoute = 'home/index';
        
        $currentRoute      = empty($_GET['route']) ? $defaultRoute : $_GET['route'];
        $currentRouteParts = explode('/', $currentRoute);
        
        $area = ucwords($currentRouteParts[0] === 'admin' ? $currentRouteParts[0] : '');
        
        if($area === 'Admin') {
            $controller = empty($currentRouteParts[1]) ? 'auth' : ucwords($currentRouteParts[1]);
            $action     = empty($currentRouteParts[2]) ? 'index' : $currentRouteParts[2];
        } else {
            $controller = ucwords($currentRouteParts[0]);
            $action     = empty($currentRouteParts[1]) ? 'index' : $currentRouteParts[1];
        }
        
        $controllerName = '\\App\\Controllers\\' . $area . $controller . 'Controller';
        
        self::setter($currentRoute, $area, $controller, $action);
        
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
    
    private static function setter($currentRoute, $area, $controller, $action) {
        self::$currentRoute = $currentRoute;
        self::$area = $area === 'Admin' ? $area : 'Front';
        self::$controller = $controller;
        self::$action = $action;
        self::$isAdminArea = $area === 'Admin';
    }    
}