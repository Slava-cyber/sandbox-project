<?php

namespace App\Controllers;

use App\Models\Users\User;
use App\Models\Events\Event;
use App\Models\Events\Requests;

class AdminGetDataTableController extends AdminController
{
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

    private static function entityFunctionArrayForGettingData(): ?array
    {
        return [
            'user' => 'userTable',
            'event' => 'eventTable',
            'request' => 'requestTable',
        ];
    }

}

