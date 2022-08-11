<?php

namespace App\Controllers;

use App\Models\Events\Event;
use App\Models\Events\Requests;
use App\Models\Users\User;
use App\Models\Validation\Validation as Validation;

class AdminRecordsCreationController extends AdminController
{
    public function actionEventCreate(): bool
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
    public function actionEventAuthorIdentification(): bool
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

    public function actionRequestCreate(): bool
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

    public function actionUserCreate(): bool
    {
        $response['status'] = true;
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $data = json_decode(json_encode($data), true)['data'];
            $valid = new Validation($data, 'adminUser');
            $response = $valid->validate();
            if ($response['status']) {
                $user = User::createUserByAdmin($data);
                if (!($user instanceof User)) {
                    $response['status'] = false;
                }
            }
        }
        echo json_encode($response);
        return true;
    }

    public function actionEventGetDataById(): bool
    {
        $eventData = [];
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $event = Event::findOneByColumn('id', $data->id);
            if ($event != null) {
                $status = true;
                $eventData[0] = $event;
                $result = self::formArrayOfArraysInsteadOfClassObjects($eventData);
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
}