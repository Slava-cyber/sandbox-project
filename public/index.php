<?php
define('ROOT', dirname(__FILE__) . '/../src/');

$errorStatus = (require ROOT . '../settings/db.php')['error'];
if ($errorStatus) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

require 'autoload.php';

$router = new App\System\Router;
$router->run();
