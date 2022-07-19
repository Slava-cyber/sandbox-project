<?php

namespace App\View;

use App\System\View;
use App\Models\Users\User as User;

class FormView extends View
{
    public static function passwordRecovery(array $info, ?User $user): string
    {
        $innerPart = FormView::render(
            'Forms/PasswordRecovery/passwordRecovery',
            $user,
            [
                'info' => $info
            ]
        );
        return self::renderFormTemplate($user, $info, $innerPart);
    }

    public static function profile(array $info, ?User $user): string
    {
        $innerPart = FormView::render(
            'Forms/Profile/profile',
            $user,
            [
                'data' => FormView::profileData($user),
                'info' => $info
            ]
        );
        return self::renderFormTemplate($user, $info, $innerPart);
    }

    public static function email(array $info, ?User $user): string
    {
        $innerPart = FormView::render(
            'Forms/Email/email',
            $user,
            [
                'info' => $info
            ]
        );
        return self::renderFormTemplate($user, $info, $innerPart);
    }

    public static function event(array $info, ?User $user): string
    {
        $innerPart = FormView::render(
            'Forms/EventTemplate/eventContent',
            $user,
            [
                'data' => FormView::arrayForEvent(),
                'info' => $info,
            ]
        );
        $innerPart = FormView::render(
            'Forms/EventTemplate/eventTemplate',
            $user,
            [
                'innerPart' => $innerPart,
                'info' => $info,
            ]
        );
        return self::renderFormTemplate($user, $info, $innerPart);
    }

    public static function oneColumnTemplate(array $info, ?User $user)
    {
        if ($info['page'] == 'login') {
            $data = null;
        } else {
            $data = FormView::registrationData();
        }
        if (isset($info['error'])) {
            $data['error'] = $info['error'];
        }
        $innerPart = FormView::render(
            'Forms/OneColumnTemplate/' . $info['name'],
            $user,
            [
                'data' => $data,
            ]
        );
        return self::renderFormTemplate($user, $info, $innerPart);
    }

    private static function renderFormTemplate(?User $user, array $info, string $innerPart): ?string
    {
        return self::render(
            'Forms/formTemplate',
            $user,
            [
                'innerPart' => $innerPart,
                'info' => $info,
            ]
        );
    }

    private static function profileData(?User $user)
    {
        return [
            'Основная информация' => [
                'name' => [
                    'value' => $user->getName(),
                    'type' => 'text',
                    'label' => 'Имя',
                    'placeholder' => 'Имя',
                ],
                'surname' => [
                    'value' => $user->getSurname(),
                    'type' => 'text',
                    'label' => 'Фамилия',
                    'placeholder' => 'Фамилия',
                ],
                'date_of_birth' => [
                    'value' => $user->getDateOfBirth(),
                    'type' => 'date',
                    'label' => 'Дата рождения',
                    'placeholder' => ''
                ],
                'town' => [
                    'value' => $user->getTown(),
                    'type' => 'text',
                    'label' => 'Город',
                    'placeholder' => 'Введите город'
                ]
            ],
            'Контакты' => [
                'phone_number' => [
                    'value' => $user->getPhoneNumber(),
                    'type' => 'text',
                    'label' => 'Номер телефона ',
                    'placeholder' => 'Введите номер телефона'
                ]
            ],
            'Личная информация' => [
                'interest' => [
                    'value' => $user->getInterest(),
                    'rows' => '5',
                    'label' => 'Интересы',
                    'placeholder' => 'Опишите свои интересы'
                ],
                'description' => [
                    'value' => $user->getDescription(),
                    'rows' => '10',
                    'label' => 'О себе',
                    'placeholder' => 'Расскажите о себе'
                ]
            ],
        ];
    }


    private static function registrationData()
    {
        date_default_timezone_set('UTC');
        //$date = date('Y-m-d');
        $dateMax = strtotime('-3 years');
        $dateMin = strtotime('-103 years');
        return [
            'name' => [
                'type' => 'text',
                'label' => 'Имя',
                'placeholder' => 'Введите имя',
            ],
            'surname' => [
                'type' => 'text',
                'label' => 'Фамилия',
                'placeholder' => 'Введите имя',
            ],
            'sex' => 'default',
            'date_of_birth' => [
                'max' => $dateMax,
                'min' => $dateMin,
            ],
            'login_sign_up' => [
                'type' => 'text',
                'label' => 'Логин',
                'placeholder' => 'Введите свой логин',
            ],
            'password_sign_up' => [
                'type' => 'password',
                'label' => 'Пароль',
                'placeholder' => 'Введите пароль',
            ],
            'password_confirm' => [
                'type' => 'password',
                'label' => 'Подтверждение пароля',
                'placeholder' => 'Подтвердите пароль',
            ],
        ];
    }

    private static function arrayForEvent()
    {
        return [
            'category' => [
                'Активный отдых',
                'Cпорт',
                'Квесты/настольные игры',
                'Ночная жизнь',
                'Охота/рыбалка',
                'Туризм',
                'Другое',
            ],
            'subcategory' => [
                '-',
            ],
        ];
    }
}
