<?php

namespace App\View;

use App\System\View as View;
use App\Models\Users\User as User;

class DisplayView extends View
{

    public static function profile(array $info, ?User $user): string
    {
        return FormView::render(
            'Profile/profile',
            $user,
            [
                'data' => DisplayView::profileData($user),
                'info' => $info,
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