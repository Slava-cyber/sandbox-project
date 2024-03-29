<?php

namespace App\View;

use App\System\View as View;
use App\Models\Users\User as User;

// use App\System\View as View;

class NavbarView extends View
{
    public static function mainTopNavbar(array $info, ?User $user): string
    {
        if ($user == null) {
            $navbar =
                [
                    'active' => $info['active'],
                    'main' => [
                        'Главная' => '/main',
                        'Войти' => '/login',
                    ],
                ];
        } else {
            $navbar =
                [
                    'active' => (isset($info['active'])) ? $info['active'] : '',
                    'main' =>
                        [
                            'Главная' => '/main',
                            'Текущие ивенты' => '/event/current',
                            'Создать ивент' => '/event/add',
                        ],
                    'dropdown' =>
                        [
                            'Профиль' => '/profile/' . $user->getLogin(),
                            'Безопасность' => '/account/security',
                            'Архив' => '/event/archive',
                            'divider' => 'default',
                            'Выйти' => '/logout',
                        ]
                ];
            if ($user->getRole() == 'administrator') {
                $navbar['main']['Админ'] = '/admin';
            }
        }
        return NavbarView::render('Navbar/navbar', $user, ['navbar' => $navbar]);
    }
}
