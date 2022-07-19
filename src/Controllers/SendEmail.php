<?php

namespace App\Controllers;

use App\Lib\PHPMailer\PHPMailer;
use App\Lib\PHPMailer\Exception;
use App\Models\Users\User;

require ROOT . 'Lib/PHPMailer/PHPMailer.php';
require ROOT . 'Lib/PHPMailer/SMTP.php';
require ROOT . 'Lib/PHPMailer/Exception.php';

class SendEmail
{
    public static function simpleMessageWithoutFiles(string $email, array $message): string
    {
        // Настройки PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;

        // Настройки вашей почты
        $parameters = require ROOT . '../settings/email.php';
        $mail->Host = $parameters['host'] ; // SMTP сервера вашей почты
        $mail->Username = $parameters['userName']; // Логин на почте
        $mail->Password = $parameters['password']; // Пароль на почте
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom($parameters['email']); // Адрес самой почты и имя отправителя

        // Получатель письма
        $mail->addAddress($email);

        // Отправка сообщения
        $mail->isHTML(true);
        $mail->Subject = $message['title'];
        $mail->Body = $message['body'];

        if ($mail->send()) {
            $result = "success";
        } else {
            $result = "error";
        }

        return $result;
    }
}
