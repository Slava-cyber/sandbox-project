<?php

namespace App\Controllers\Admin;

use App\Controllers\SendEmail;
use App\Models\Events\Event;
use App\Models\Users\User;
use App\Models\Validation\Validation as Validation;
use App\System\View;

class EventEntityController extends BaseEntityController
{
    public function actionCreateEvent(): bool
    {
        $response['status'] = true;
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $id = $data->id;
            $data = $data->data;
            $data = json_decode(json_encode($data), true);
            $_POST = $data;
            $valid = new Validation($data, 'adminEvent');
            $response = $valid->validate();
            if ($response['status'] === true) {
                $user = User::findOneByColumn('login', $_POST['author']);
                $event = Event::create($_POST, $user, 'adminEvent', $id);
                if ($event == null) {
                    $response['status'] = false;
                }
            }
        }
        echo json_encode($response);
        return true;
    }

    public function actionGetEventDataById(): bool
    {
        $eventData = [];
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $event = Event::findOneByColumn('id', $data->id);
            if ($event != null) {
                $status = true;
                $eventData[0] = $event;
                $result = self::formNestedArrayInsteadOfObjects($eventData);
                $result[0]['author'] = $result[0]['author']->getLogin();
                $eventData = $result[0];
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }
        echo json_encode(['status' => $status, 'event' => $eventData]);
        return true;
    }

    public static function getEventDataTable(): ?array
    {
        $data = Event::getAllObjects();
        $data = self::formNestedArrayInsteadOfObjects($data);
        $arraySize = count($data);
        for ($i = 0; $i < $arraySize; $i++) {
            $data[$i]['author'] = $data[$i]['author']->getLogin();
        }
        return $data;
    }

    public static function sendEventRemovalNotificationByEmail(?User $admin, ?Event $event): void
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