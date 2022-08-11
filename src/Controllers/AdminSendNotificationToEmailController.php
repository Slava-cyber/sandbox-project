<?php

namespace App\Controllers;

use App\Models\Events\Event;
use App\Models\Users\User;
use App\System\View;

class AdminSendNotificationToEmailController extends AdminController
{
    public static function sendUserRemovalNotification(?User $admin, ?User $user): void
    {
        $email = $user->getEmail();
        if ($email != null) {
            $body = View::render(
                'SendEmail/userRemovalNotification',
                $admin,
                [
                    'login' => $user->getLogin(),
                ]
            );
            $message = [
                'title' => 'Ваш аккаунт на sandbox был удален',
                'body' => $body,
            ];
            SendEmail::simpleMessageWithoutFiles($email, $message);
        }
    }

    public static function sendEventRemovalNotification(?User $admin, ?Event $event): void
    {
        $email = $event->getAuthor()->getEmail();
        if ($email != null) {
            $body = View::render(
                'SendEmail/eventRemovalNotification',
                $admin,
                [
                    'title' => $event->getTitle(),
                ]
            );
            $message = [
                'title' => 'Ваш ивент на sandbox был удален',
                'body' => $body,
            ];
            SendEmail::simpleMessageWithoutFiles($email, $message);
        }
    }
}
