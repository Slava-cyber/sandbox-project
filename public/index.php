<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('ROOT', dirname(__FILE__) . '/../src/');

require 'autoload.php';

$router = new App\System\Router;
$router->run();

