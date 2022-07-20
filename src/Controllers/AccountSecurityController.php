<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Users\User;
use App\Controllers\SendEmail;
use App\System\View;

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
            $pageData = self::addBasicPageDataArray($this->data, $pageData);
            $this->view->print($pageData);
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
                $body = View::render(
                    'SendEmail/passwordRecovery',
                    $this->user,
                    [
                        'newPassword' => $newPassword,
                    ]
                );
                $message = [
                    'title' => 'Восстановление пароля на Sandbox',
                    'body' => $body,
                ];
                $status = SendEmail::simpleMessageWithoutFiles($data['data']['email'], $message);
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
                    '/js/emailValidation.js',
                    '/js/validation.js'
                ],
            ],
            'page' => [
                'title' => 'Безопасность аккаунта',
            ]
        ];
    }
}