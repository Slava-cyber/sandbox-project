<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Users\User;

class AccountSecurityController extends Controller
{
    public function actionView()
    {
        if ($this->user == null) {
            header('Location: /login');
            return true;
        }

        if (empty($_POST)) {
            $pageData = self::pageListData();

            $this->view->generateHtml($pageData);
        } else {
            return false;
        }
        return true;
    }

    public function actionPasswordRecovery(): bool
    {
        if (!empty($_POST) && $this->user == null) {
            $data = json_decode($_POST['all'], true);
            $response = User::checkLoginEmail($data['data']);
            echo json_encode($response);
        } else {
            return false;
        }
        return true;
    }

    private static function pageListData(): array
    {
        return [
            'navbar' => [
                'class' => 'navbar',
                'type' => 'default',
            ],
            'form' => [
                'class' => 'form',
                'type' => 'email',
                'name' => 'emailForm',
                'action' => '/save/email',
                'button' => [
                    'name' => 'Сохранить',
                    'position' => 'center',
                    'size' => 40,
                ],
                'page' => 'account/security',
                'js' => [
                    '../js/emailValidation',
                    '../js/validation'
                ],
            ],
            'page' => [
                'title' => 'Безопасность аккаунта',
                'type' => 'oneColumnDefault',
            ]
        ];
    }
}