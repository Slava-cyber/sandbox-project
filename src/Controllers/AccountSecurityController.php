<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Users\User;
use App\Controllers\SendEmail;

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
            if ($response != '') {
                echo json_encode($response);
            } else {
                $newPassword = self::newPasswordGeneration();
                $message = [
                    'title' => 'Восстановление пароля на Sandbox',
                    'body' => "
                        <h2>Новое письмо</h2>
                        <p>
                            <b>Новый пароль:</b>$newPassword
                        </p>
                        <b>Рекомендуем после восстановление изменить пароль на свое усмотрение</b>
                    ",
                    'email' => [
                        'email' => 'muravlevsvyatoslav@gmail.com',
                        'name' => 'Техническая поддержка Sandbox'
                    ]
                ];
                $status = SendEmail::passwordRecovery($data['data']['email'], $newPassword, $message);
                echo json_encode($status);
                if ($status == 'success') {
                    $user = User::getUserByLogin($data['data']['login']);
                    User::changePassword($user, $newPassword);
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public static function newPasswordGeneration(): string
    {
        $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = array();
        $combLen = strlen($comb) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $combLen);
            $password[] = $comb[$n];
        }
        return implode($password);
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