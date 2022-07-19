<?php

namespace App\View;

use App\System\View as View;
use App\Models\Users\User as User;

class ProfileView extends View
{

    public static function wholeProfile(array $info, ?User $user): string
    {
        return FormView::render(
            'Profile/profile',
            $user,
            [
                'data' => ProfileView::profileData($info['user']),
                'info' => $info,
                'user' => $user,
            ]
        );
    }

    private static function profileData(?User $user)
    {
        return [
            'Основная информация' => [
                'ФИО:' => $user->getName() . ' ' . $user->getSurname(),
                'Дата рождения:' => $user->getDateOfBirth(),
                'Город:' => $user->getTown(),
            ],
            'Контакты' => [
                'Телефон:' => $user->getPhoneNumber(),
            ],
            'Личная информация' => [
                'Интересы:' => $user->getInterest(),
                'О себе:' => $user->getDescription(),
            ],
        ];
    }
}