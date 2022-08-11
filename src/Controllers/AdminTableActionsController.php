<?php

namespace App\Controllers;

use App\Models\Users\User;

class AdminTableActionsController extends AdminController
{
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
                    AdminSendNotificationToEmailController::$functionName($this->user, $object);
                }
                $object->delete();
                $status = true;
            }
        }
        echo json_encode(['status' => $status]);

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

    private static function entityClassNameArray(): ?array
    {
        return [
            'user' => 'App\Models\Users\User',
            'event' => 'App\Models\Events\Event',
            'request' => 'App\Models\Events\Requests',
        ];
    }

    private static function arrayOfRemovalNotificationFormEmailFunctions(): ?array
    {
        return [
            'user' => 'sendUserRemovalNotification',
            'event' => 'sendEventRemovalNotification',
        ];
    }
}