<?php

namespace App\Controllers;

use App\Models\Users\User;
use App\Models\Events\Event;
use App\Models\Events\Requests;
use App\Models\Validation\Validation as Validation;
use App\System\Controller;
use App\System\Model;
use App\System\View;

class AdminApiRequestController extends Controller
{

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

    public function actionUserChangeRole(): bool
    {
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $user = User::findOneByColumn('id', $data->id);
            if ($user != null) {
                $user->setRole($data->role);
                $user->save();
            }
            $status = true;
        } else {
            $status = false;
        }
        echo json_encode(['status' => $status]);
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

    public function actionAllDataRelease(): bool
    {
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $entity = $data->entity;
            $function = self::entityFunctionArrayForGettingData()[$entity];
            $result = self::$function();
            echo json_encode(self::transformArrayOfArraysToArrayOfJsonStrings($result));
        } else {
            echo json_encode(['status' => false]);
        }
        return true;
    }

    public function actionUserDelete(): bool
    {
        $status = false;
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $entity = $data->entityType;
            $id = $data->id;
            $entityClassName = self::entityClassNameArray()[$entity];
            $object = $entityClassName::findOneByColumn('id', $id);
            if ($object != null) {
                if (isset(self::arrayOfRemovalNotificationFormEmailFunctions()[$entity])) {
                    $functionName = self::arrayOfRemovalNotificationFormEmailFunctions()[$entity];
                    self::$functionName($this->user, $object);
                }
                $object->delete();
                $status = true;
            }
        }
        echo json_encode(['status' => $status]);

        return true;
    }

    private static function sendUserRemovalNotification(?User $admin, ?User $user): void
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

    private static function sendEventRemovalNotification(?User $admin, ?Event $event): void
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

    private static function arrayOfRemovalNotificationFormEmailFunctions(): ?array
    {
        return [
            'user' => 'sendUserRemovalNotification',
            'event' => 'sendEventRemovalNotification',
        ];
    }

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

    private static function userTable(): ?array
    {
        $data = User::getAllObjects();
        return self::formArrayOfArraysInsteadOfClassObjects($data);
    }

    private static function eventTable(): ?array
    {
        $data = Event::getAllObjects();
        $data = self::formArrayOfArraysInsteadOfClassObjects($data);
        $arraySize = count($data);
        for ($i = 0; $i < $arraySize; $i++) {
            $data[$i]['author'] = $data[$i]['author']->getLogin();
        }
        return $data;
    }

    private static function requestTable(): ?array
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

    private static function formArrayOfArraysInsteadOfClassObjects(?array $data): ?array
    {
        $result = [];
        $i = 0;
        foreach ($data as $object) {
            $reflector = new \ReflectionObject($object);
            $properties = $reflector->getProperties();
            $mappedProperties = [];
            foreach ($properties as $property) {
                $propertyName = $property->getName();
                $getter = 'get' . ucfirst($propertyName);
                $mappedProperties[$propertyName] = $object->$getter();
            }
            $result[$i] = $mappedProperties;
            $i++;
        }
        return $result;
    }

    private static function transformArrayOfArraysToArrayOfJsonStrings(?array $data): ?array
    {
        $result = [];
        foreach ($data as $item) {
            json_encode($item);
            array_push($result, $item);
        }
        return $result;
    }

    private static function entityFunctionArrayForGettingData(): ?array
    {
        return [
            'user' => 'userTable',
            'event' => 'eventTable',
            'request' => 'requestTable',
        ];
    }

    private static function entityClassNameArray(): ?array
    {
        return [
            'user' => 'App\Models\Users\User',
            'event' => 'App\Models\Events\Event',
            'request' => 'App\Models\Events\Requests',
        ];
    }


}

