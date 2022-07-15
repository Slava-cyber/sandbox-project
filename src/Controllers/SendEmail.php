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
    public static function passwordRecovery(string $email, string $newPassword, array $message): string
    {
        // Настройки PHPMailer
        $mail = new PHPMailer(true);
        //try {
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;

        // Настройки вашей почты
        $mail->Host = 'ssl://smtp.gmail.com'; // SMTP сервера вашей почты
        $mail->Username = 'sandbox.technical.spt@gmail.com'; // Логин на почте
        $mail->Password = 'nstuuynubbwhqkho'; // Пароль на почте
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('sandbox.technical.spt@gmail.com'); // Адрес самой почты и имя отправителя

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

        // Отображение результата
        //echo json_encode(["result" => $result]);
        return $result;
    }
}
