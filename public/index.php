<?php
//phpinfo();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('ROOT', dirname(__FILE__).'/../src/');

require 'autoload.php';

$router = new App\System\Router;
$router->run();












/*$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments= explode('/', trim($uri, '/'));
if ($segments[0] === 'time' && ($segments[1] === 'nsk' || $segments[1] === 'la')) {
    $controller = 'Controllers\\'.$segments[0].'Controller';
    $controller = new $controller;
    //var_dump($segments[1]());
    $action = $segments[1];
    var_dump($action);
    $controller->$action();
}*/

/*require 'get_weather.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments= explode('/', trim($uri, '/'));
if ($segments[0] === 'nsk' || $segments[0] == '') {
	$file = 'nsk.time.test/index.php';
} else if ($segments[0] === 'l-a') {
	$file = 'l-a.time.test/index.php';
} else {
	$file = '404.html';
}

require $file;*/
