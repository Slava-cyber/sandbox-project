<?php

namespace App\Controllers\Admin;

use App\Models\Events\Event;
use App\Models\Events\Requests;
use App\Models\Users\User;
use App\Models\Validation\Validation as Validation;

class RequestEntityController extends BaseEntityController
{
    public function actionIdentifyTheEventAuthor(): bool
    {
        $data = json_decode(file_get_contents('php://input', true));
        $eventId = $data->eventId;
        $event = Event::findOneByColumn('id', $eventId);
        $author = '';
        if ($event != null) {
            $author = $event->getAuthor()->getLogin();
        }
        echo json_encode(['author' => $author]);
        return true;
    }

    public function actionCreateRequest(): bool
    {
        $response['status'] = true;
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $data = json_decode(json_encode($data), true)['data'];
            $_POST = $data;
            $valid = new Validation($data, 'adminRequest');
            $response = $valid->validate();
            $event = Event::findOneByColumn('id', $_POST['event']);
            if (
                $event != null &&
                $event->getAuthor()->getLogin() != $_POST['request_author'] &&
                empty($response['error']['request_author'])
            ) {
                $response['status'] = false;
                $response['error']['request_author'] = "не является автором указанного ивента";
            }

            if ($response['status']) {
                $request = Requests::createRequest($_POST);
                if ($request == null) {
                    $response['status'] = false;
                }
            }
        }
        echo json_encode($response);
        return true;
    }

    public static function getRequestDataTable(): ?array
    {
        $data = Requests::getAllObjects();
        $data = self::formArrayOfArraysInsteadOfClassObjects($data);
        $arraySize = count($data);
        for ($i = 0; $i < $arraySize; $i++) {
            $data[$i]['author'] = User::getUserById($data[$i]['author'])->getLogin();
            $data[$i]['user'] = User::getUserById($data[$i]['user'])->getLogin();
        }
        return $data;
    }
}