<?php

namespace App\System;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '../routes/routes.php';
        $this->routes = include($routesPath);
    }

    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();
        $result = false;
        foreach ($this->routes as $uriPattern => $path) {
            $result = false;
            $result = $this->callMethod($uriPattern, $uri, $path);
            if ($result != null) {
                break;
            }
        }
        if ($result == null) {
            require ROOT . '../templates/404.html';
        }
    }

    private function callMethod($uriPattern, $uri, $path): bool
    {
        $result = false;
        if (preg_match("~$uriPattern~", $uri)) {
            $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
            $segments = explode('/', $internalRoute);
            $controllerName = 'App\Controllers\\' . ucfirst(array_shift($segments)) . 'Controller';
            if (class_exists($controllerName)) {
                $controllerObject = new $controllerName;
                $actionName = 'action' . ucfirst(array_shift($segments));
                if (method_exists($controllerObject, $actionName)) {
                    $parameters = $segments;
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                }
            }
        }
        return $result;
    }
}