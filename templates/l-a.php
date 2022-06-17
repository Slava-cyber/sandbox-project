<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// time
date_default_timezone_set('America/Los_Angeles');
$date = date('m/d/Y h:i:s a', time());
?>

<html>
<head>
    <?= !empty($user) ? 'Привет, ' . $user->getLogin() : 'Войдите на сайт' ?>
    Время в Лос-Анджелесе: <?= $date ?><br/>
</head>
</html>
