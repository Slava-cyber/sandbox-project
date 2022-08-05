<?php

namespace App\Controllers;

use App\Models\Users\User;
use App\Models\Events\Event;
use App\Models\Events\Requests;
use App\Models\Validation\Validation as Validation;
use App\System\Model;

class AdminApiRequestController
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
        echo json_encode($response);
        return true;
    }

    public function actionUserCreate(): bool
    {
        $data = json_decode(file_get_contents('php://input', true));
        $data = json_decode(json_encode($data), true)['data'];
        $valid = new Validation($data, 'adminUser');
        $response = $valid->validate();
        if ($response['status']) {
            $user = User::createUserByAdmin($data);
            if ($user == null) {
                $response['status'] = false;
            }
        }
        echo json_encode($response);
        return true;
    }


    public function actionAllDataRelease(): bool
    {
        $data = json_decode(file_get_contents('php://input', true));
        $entity = $data->entity;
        $function = self::entityFunctionArrayForGettingData()[$entity];
        self::$function();
        return true;
    }

    public function actionUserDelete(): bool
    {
        $data = json_decode(file_get_contents('php://input', true));
        $class = $data->entityType;
        $id = $data->id;
        $entityClassName = self::entityClassNameArray()[$class];
        $object = $entityClassName::findOneByColumn('id', $id);
        if ($object != null) {
            $object->delete();
            $status = 'success';
        } else {
            $status = 'false';
        }
        echo json_encode(['status' => $status]);
        return true;
    }

    public function actionEventCreate(): bool
    {
        $data = json_decode(file_get_contents('php://input', true));
        $data = json_decode(json_encode($data), true)['data'];
        $_POST = $data;
        $valid = new Validation($data, 'adminEvent');
        $response = $valid->validate();
        if ($response['status'] === true) {
            $user = User::findOneByColumn('login', $_POST['author']);
            $event = Event::create($_POST, $user, 'adminEvent');
            if ($event == null) {
                $response['status'] = false;
            }
        }
        echo json_encode($response);
        return true;
    }

    private static function actionUserTable(): bool
    {
        $data = User::getAllObjects();
        $result = self::formArrayOfArraysInsteadOfClassObjects($data);
        echo json_encode(self::transformArrayOfArraysToArrayOfJsonStrings($result));
        return true;
    }

    private static function actionEventTable(): bool
    {
        $data = Event::getAllObjects();
        $result = self::formArrayOfArraysInsteadOfClassObjects($data);
        $arraySize = count($result);
        for ($i = 0; $i < $arraySize; $i++) {
            $result[$i]['author'] = $result[$i]['author']->getLogin();
        }
        echo json_encode(self::transformArrayOfArraysToArrayOfJsonStrings($result));
        return true;
    }

    private static function actionRequestTable(): bool
    {
        $data = Requests::getAllObjects();
        $result = self::formArrayOfArraysInsteadOfClassObjects($data);
        $arraySize = count($result);
        for ($i = 0; $i < $arraySize; $i++) {
            $result[$i]['author'] = User::getUserById($result[$i]['author'])->getLogin();
            $result[$i]['user'] = User::getUserById($result[$i]['user'])->getLogin();
        }
        echo json_encode(self::transformArrayOfArraysToArrayOfJsonStrings($result));
        return true;
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
            'user' => 'actionUserTable',
            'event' => 'actionEventTable',
            'request' => 'actionRequestTable',
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

