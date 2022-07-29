<?php

namespace App\Controllers;

use App\Models\Users\User;
use App\Models\Events\Event;
use App\Models\Events\Requests;
use App\System\Model;

class AdminApiRequestController
{

    public function actionAllDataRelease(): bool
    {
        $data = json_decode(file_get_contents('php://input', true));
        $entity = $data->entity;
        if ($entity == 'user') {
            self::actionUserTable();
        } elseif ($entity == 'event') {
            self::actionEventTable();
        } elseif ($entity == 'request') {
            self::actionRequestTable();
        }
        return true;
    }

    public static function actionUserTable(): bool
    {
        $data = User::getAllObjects();
        $result = self::formArrayOfArraysInsteadOfClassObjects($data);
        echo json_encode(self::transformArrayOfArraysToArrayOfJsonStrings($result));
        return true;
    }

    public static function actionEventTable(): bool
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

    public static function actionRequestTable(): bool
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

    public function actionUserDelete(): bool
    {
        $data = json_decode(file_get_contents('php://input', true));
        $class = ucfirst($data->entityType);
        $id = $data->id;
        if ($class == 'User') {
            $object = User::findOneByColumn('id', $id);
        } elseif ($class == 'Event') {
            $object = Event::findOneByColumn('id', $id);
        } elseif ($class == 'Request') {
            $object = Requests::findOneByColumn('id', $id);
        } else {
            $object = null;
        }
        if ($object != null) {
            $object->delete();
            $status = 'success';
        } else {
            $status = 'false';
        }
        echo json_encode(['status' => $status]);
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
}

