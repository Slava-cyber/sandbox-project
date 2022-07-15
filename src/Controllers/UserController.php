<?php

namespace App\Controllers;

use App\Controllers\Authorization;
use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;
use  App\Exceptions\InvalidArgumentException;

class UserController extends Controller
{
    public function actionSignUp(): bool
    {
        $user = Authorization::getUserByToken();

        if ($user instanceof User) {
            header('Location: /main');
            return true;
        }

        if (!empty($_POST)) {
            $user = User::signUp($_POST);

            if ($user instanceof User) {
                Authorization::signIn($user);
                header('location: /main');
                return true;
            }
            return false;
        }
        $data = [
            'navbar' => [
                'class' => 'navbar',
                'type' => 'default',
                'active' => '',
            ],
            'form' => [
                'class' => 'form',
                'type' => 'registration',
                'name' => 'registration',
                'title' => 'Регистрация',
                'button' => [
                    'name' => 'Зарегистрироваться',
                    'size' => 100,
                ],
                'link' => [
                    'label' => 'У вас уже есть аккаунт? - ',
                    'name' => 'Авторизируйтесь',
                    'link' => '/login',
                ],
                'page' => 'registration',
                'js' => [
                    '/js/validation',
                    '/js/registrationValidation'
                ],
            ],
            'page' => [
                'type' => 'oneColumnDefault',
                'title' => 'Регистрация',
                'widthColumn' => 'col-md-6',
                'align' => 'center',
                'color' => true,
            ]
        ];
        $this->view->generateHtml($data);
        return true;
    }

    public function actionSignIn(): bool
    {
        $user = Authorization::getUserByToken();

        if ($user instanceof User) {
            header('Location: /main');
            return true;
        }

        $data = [
            'navbar' => [
                'class' => 'navbar',
                'type' => 'default',
                'active' => 'Войти',
            ],
            'form' => [
                'class' => 'form',
                'type' => 'registration',
                'name' => 'login',
                'title' => 'Авторизация',
                'button' => [
                    'name' => 'Войти',
                    'size' => '100',
                ],
                'link' => [
                    'label' => 'У вас еще нет аккаунта? - ',
                    'name' => 'Зарегистрируйтесь',
                    'link' => '/registration',
                ],
                'page' => 'login',
                'js' => [
                    '/js/validation',
                    '/js/loginValidation'
                ],
            ],
            'form2' => [
                'class' => 'form',
                'type' => 'passwordRecovery',
                'name' => 'passwordRecoveryForm',
                'label' => 'Укажите логин и email указанный в аккаунте',
                'title' => '',
                'button' => [
                    'hidden' => true,
                    'name' => 'Войти',
                    'size' => '100',
                ],
                'js' => [
                    '/js/passwordRecovery'
                ],
                'modalWindow' => [
                    'type' => 'simplyCase',
                    'source' => 'Забыли пароль?',
                    'title' => 'Восстановление пароля',
                    'label' => 'Укажите логин и почту указанную в аккаунте для отправки нового пароля',
                    'button' => [
                        'close' => 'Закрыть',
                        'action' => 'Восстановить'
                    ],
                ]
            ],
            'page' => [
                'type' => 'oneColumnDefault',
                'title' => 'Авторизация',
                'widthColumn' => 'col-md-4',
                'align' => 'center',
                'color' => true,
            ]
        ];


        if (!empty($_POST)) {
            $user = User::prepareSignIn($_POST);
            if ($user instanceof User) {
                Authorization::signIn($user);
                header('Location: /main');
                exit();
            } else {
                $data['form']['error'] = 'Такого пользователя не существует';
                $this->view->generateHtml($data);
                return true;
            }
        }
        $this->view->generateHtml($data);
        return true;
    }

    public function actionLogout(): bool
    {
        $user = Authorization::getUserByToken();
        if ($user instanceof User) {
            User::logout($user);
        }
        header('Location: /login');
        return true;
    }

    public function actionSaveEmail(): bool
    {
        if (!empty($_POST) && $this->user != null) {
            $status = User::saveEmail($_POST, $this->user);
            header('Location: /account/security');
        } else {
            return false;
        }
        return $status;
    }
}
