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
        if(!empty($_SERVER['REQUEST_URI']))
        {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();
        //var_dump($uri);
        $result = false;
        foreach($this->routes as $uriPattern => $path)
        {
            $result = false;
            if(preg_match("~$uriPattern~", $uri))
            {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                //var_dump($internalRoute);
                $segments = explode('/', $internalRoute);
                $controllerName = 'App\Controllers\\' . ucfirst(array_shift($segments)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));
                //var_dump($controllerName);
                $parameters = $segments;
                //var_dump([$parameters]);
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                //$result = $controllerObject -> $actionName();
                if($result != null)
                {
                    break;
                }
            }
        }
        if ($result == null) {
            require ROOT . '../templates/404.html';
        }
    }
}
