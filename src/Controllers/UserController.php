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
            $userData = self::trimmer($_POST);
            $user = User::signUp($userData);

            if ($user instanceof User) {
                Authorization::signIn($user);
                header('location: /main');
                return true;
            }
            return false;
        }
        $pageData = [
            'form' => [
                'class' => 'form',
                'type' => 'oneColumnTemplate',
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
                    '/js/validation.js',
                    '/js/registrationValidation.js'
                ],
            ],
            'page' => [
                'title' => 'Регистрация',
                'widthColumn' => 'col-md-6',
                'align' => 'center',
                'color' => true,
            ]
        ];
        $pageData = self::addBasicPageDataArray($this->data, $pageData);
        $this->view->print($pageData);
        return true;
    }

    public function actionSignIn(): bool
    {
        $user = Authorization::getUserByToken();

        if ($user instanceof User) {
            header('Location: /main');
            return true;
        }

        $pageData = [
            'navbar' => [
                'active' => 'Войти',
            ],
            'form' => [
                'class' => 'form',
                'type' => 'oneColumnTemplate',
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
                    '/js/validation.js',
                    '/js/loginValidation.js'
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
                    '/js/passwordRecovery.js'
                ],
                'modalWindow' => [
                    'type' => 'onlyForm',
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
                'title' => 'Авторизация',
                'widthColumn' => 'col-md-4',
                'align' => 'center',
                'color' => true,
            ]
        ];


        if (!empty($_POST)) {
            $userData = self::trimmer($_POST);
            $user = User::signInPreparation($userData);
            if ($user instanceof User) {
                Authorization::signIn($user);
                header('Location: /main');
                exit();
            } else {
                $pageData['form']['error'] = 'Такого пользователя не существует';
            }
        }
        $pageData = self::addBasicPageDataArray($this->data, $pageData);
        $this->view->print($pageData);
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
