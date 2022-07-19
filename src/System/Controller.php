<?php

namespace App\System;

use App\Controllers\Authorization;

abstract class Controller
{
    protected $view;
    protected $user;
    protected $data = [
        'navbar' => [
            'class' => 'navbar',
            'type' => 'mainTopNavbar',
            'active' => '',
        ],
        'page' => [
            'type' => 'oneColumnDefault',
            'widthColumn' => 'col-md-10',
        ]
    ];

    public function __construct()
    {
        $this->user = Authorization::getUserByToken();
        $this->view = new View();
        $this->view->setHeader('user', $this->user);
    }

    protected static function addBasicPageDataArray(?array $basic, ?array $custom): ?array
    {
        if (empty($custom['navbar'])) {
            $custom['navbar'] = $basic['navbar'];
        } else {
            $custom['navbar'] = array_merge($basic['navbar'], $custom['navbar']);
        }
        if (empty($custom['page'])) {
            $custom['page'] = $basic['page'];
        } else {
            $custom['page'] = array_merge($basic['page'], $custom['page']);
        }

        return $custom;
    }

    protected static function arrayUnion(array $first, array $second, string $firstName, string $secondName): ?array
    {
        $result = [];
        $array_size = count($first);
        for ($i = 0; $i < $array_size; $i++) {
            $result[$i][$firstName] = $first[$i];
            $result[$i][$secondName] = $second[$i];
        }
        return $result;
    }

    protected static function getCurrentPage(): ?int
    {
        // TODO $pageData = self::pageListData();

        $path = explode('/', $_SERVER['REQUEST_URI']);
        (isset($path[4])) ? $currentPage = $path[4] : $currentPage = 1;
        return $currentPage;
    }

    protected static function trimmer(?array $userData): ?array
    {
        if (!empty($userData)) {
            foreach ($userData as $field => $value) {
                $userData[$field] = trim($value);
            }
        }
        return $userData;
    }


    /*protected static function basicDataArrayForAllPages(): array
    {
        return [
            'navbar' => [
                'class' => 'navbar',
                'type' => 'mainTopNavbar',
            ],
            'page' => [
                'type' => 'oneColumnDefault',
            ]
        ];
    }*/
}
