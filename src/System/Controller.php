<?php

namespace App\System;

use App\Controllers\Authorization;

abstract class Controller
{
    protected $view;
    protected $user;
    protected static $data = [
        'navbar' => [
            'class' => 'navbar',
            'type' => 'default',
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
}
