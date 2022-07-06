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
        $user = User::getUserByLogin($nickname);
        if ($user instanceof User) {
            $data = [
                'navbar' => [
                    'class' => 'navbar',
                    'type' => 'default',
                    'active' => '',
                ],
                'display' => [
                    'class' => 'display',
                    'type' => 'profile'
                ],
                'page' => [
                    'type' => 'oneColumnDefault',
                    'title' => 'Профиль',
                    'widthColumn' => 'col-md-12',
                ]
            ];
            $this->view->generateHtml($data);
            return true;
        }

        return false;
    }

    public function actionEdit(): bool
    {
        if ($this->user instanceof User) {
            if (empty($_POST)) {
                $data = [
                    'navbar' => [
                        'class' => 'navbar',
                        'type' => 'default',
                        'active' => '',
                    ],
                    'form' => [
                        'class' => 'form',
                        'type' => 'profile',
                        'name' => 'profile',
                        'button' => [
                            'name' => 'Редактировать',
                            'position' => 'end',
                            'size' => 2,
                        ],
                        'page' => 'profile',
                        'js' => [
                            '../js/validation',
                            '../js/profileValidation'
                        ],
                    ],
                    'page' => [
                        'type' => 'oneColumnDefault',
                        'title' => 'Редактирование профиля',
                        'widthColumn' => 'col-md-10',
                    ]
                ];
                $this->view->generateHtml($data);
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

