<?php

namespace App\Controllers\Admin;

use App\Controllers\SendEmail;
use App\Models\Users\User as User;
use App\Models\Validation\Validation as Validation;
use App\System\View;

class UserEntityController extends BaseEntityController
{
    public function actionCreateUser(): bool
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

    public function actionChangeUserRole(): bool
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

    public static function getUserDataTable(): ?array
    {
        $data = User::getAllObjects();
        return self::formNestedArrayInsteadOfObjects($data);
    }

    public static function sendUserRemovalNotificationByEmail(?User $admin, ?User $user): void
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

}
