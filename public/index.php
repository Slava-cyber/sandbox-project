<?php
define('ROOT', dirname(__FILE__) . '/../src/');

$config = require ROOT . '../settings/db.php';
if (!empty($config['errorDisplay'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

require ROOT . 'System/autoload.php';

$router = new App\System\Router;
$router->run();
