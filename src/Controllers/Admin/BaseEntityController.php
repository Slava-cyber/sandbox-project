<?php

namespace App\Controllers\Admin;

use App\Models\Users\User;
use App\System\Controller;

class BaseEntityController extends Controller
{
    public function actionDeleteRecordFromTheTable(): bool
    {
        $status = false;
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $entity = $data->entityType;
            $id = $data->id;
            $entityClassName = 'App\Models\\' . self::entityModelClassName()[$entity];
            $object = $entityClassName::findOneByColumn('id', $id);
            if ($object != null) {
                if (isset(self::removalNotificationByEmailFunctionName()[$entity])) {
                    $functionName = self::removalNotificationByEmailFunctionName()[$entity];
                    $entityControllerName = 'App\Controllers\Admin\\' . self::entityControllerName()[$entity];
                    $entityControllerName::$functionName($this->user, $object);
                }
                $object->delete();
                $status = true;
            }
        }
        echo json_encode(['status' => $status]);

        return true;
    }

    public function actionCheckAdminStatus(): bool
    {
        $status = 'failure';
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $status = 'success';
        }
        echo json_encode(['status' => $status]);

        return true;
    }

    public function actionGetDataTable(): bool
    {
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
            $data = json_decode(file_get_contents('php://input', true));
            $entity = $data->entity;
            $function = self::entityFunctionForGettingData()[$entity];
            $entityControllerName = 'App\Controllers\Admin\\' . self::entityControllerName()[$entity];
            $result = $entityControllerName::$function();
            echo json_encode(self::transformNestedArrayToArrayOfJsonStrings($result));
        } else {
            echo json_encode(['status' => false]);
        }
        return true;
    }

    protected static function formNestedArrayInsteadOfObjects(?array $data): ?array
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

    protected static function transformNestedArrayToArrayOfJsonStrings(?array $data): ?array
    {
        $result = [];
        foreach ($data as $item) {
            json_encode($item);
            array_push($result, $item);
        }
        return $result;
    }

    private static function entityModelClassName(): ?array
    {
        return [
            'user' => 'Users\User',
            'event' => 'Events\Event',
            'request' => 'Events\Requests',
        ];
    }

    private static function removalNotificationByEmailFunctionName(): ?array
    {
        return [
            'user' => 'sendUserRemovalNotificationByEmail',
            'event' => 'sendEventRemovalNotificationByEmail',
        ];
    }

    private static function entityFunctionForGettingData(): ?array
    {
        return [
            'user' => 'getUserDataTable',
            'event' => 'getEventDataTable',
            'request' => 'getRequestDataTable',
        ];
    }

    private static function entityControllerName(): ?array
    {
        return [
            'user' => 'UserEntityController',
            'event' => 'EventEntityController',
            'request' => 'RequestEntityController',
        ];
    }



}