<?php

namespace App\Controllers;

use App\Controllers\Authorization;
use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;

class ProfileController extends Controller
{
    public function actionView($nickname): bool
    {
        if ($this->user == null) {
            header('Location: /login');
            return true;
        }

        $user = User::getUserByLogin($nickname);
        if ($user instanceof User) {
            if ($user->getLogin() == $this->user->getLogin()) {
                $button = true;
            } else {
                $button = false;
            }
            $pageData = [
                'display' => [
                    'class' => 'profile',
                    'type' => 'wholeProfile',
                    'button' => $button,
                    'user' => $user,
                ],
                'page' => [
                    'title' => 'Профиль',
                    'widthColumn' => 'col-md-12',
                ]
            ];
            $pageData = self::addBasicPageDataArray($this->data, $pageData);
            $this->view->print($pageData);
            return true;
        }

        return false;
    }

    public function actionEdit(): bool
    {
        if ($this->user instanceof User) {
            if (empty($_POST)) {
                $pageData = [
                    'form' => [
                        'class' => 'form',
                        'type' => 'profile',
                        'name' => 'profile',
                        'button' => [
                            'name' => 'Редактировать',
                            'position' => 'end',
                            'size' => 40,
                        ],
                        'page' => 'profile',
                        'js' => [
                            '/js/validation.js',
                            '/js/profileValidation.js'
                        ],
                    ],
                    'page' => [
                        'title' => 'Редактирование профиля',
                        'widthColumn' => 'col-md-10',
                    ]
                ];
                $pageData = self::addBasicPageDataArray($this->data, $pageData);
                $this->view->print($pageData);
            } else {
                $user = User::profileEdit($_POST, $this->user);
                if ($user instanceof User) {
                    header('Location: /profile/' . $this->user->getLogin());
                } else {
                    header('Location: 404');
                }
            }
            return true;
        }
        header('Location: /login');
        return true;
    }
}
