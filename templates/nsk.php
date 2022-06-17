<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// time
date_default_timezone_set('Asia/Novosibirsk');
$date = date('m/d/Y h:i:s a', time());
?>

<html>
<head>
    <?= !empty($user) ? 'Привет, ' . $user->getLogin() : 'Войдите на сайт' ?>
    Время в Новосибирске: <?= $date ?><br/>
</head>
</html>