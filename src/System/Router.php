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
            //var_dump($uriPattern);
            $result = false;
            if(preg_match("~$uriPattern~", $uri))
            {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                //var_dump($internalRoute);
                $segments = explode('/', $internalRoute);
                $validation = ucfirst($segments[0]);
               // var_dump($validation);
                $input = json_decode(file_get_contents("php://input"), true);
                if (($validation == 'Validation' && !empty($input)) || ($validation != 'Validation'))
                {
                    $controllerName = 'App\Controllers\\' . ucfirst(array_shift($segments)) . 'Controller';
                    if (class_exists($controllerName)) {
                        $controllerObject = new $controllerName;
                        //var_dump($controllerName);
                        $actionName = 'action' . ucfirst(array_shift($segments));
                        //var_dump($actionName);
                        if (method_exists($controllerObject, $actionName)) {
                            $parameters = $segments;
                            //var_dump($parameters);
                            $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                        }
                    }

                }
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
