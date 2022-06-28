<?php

namespace App\System;

use App\Models\Users\Authorization;

abstract class Controller
{
    protected $view;
    protected $user;

    public function __construct()
    {
        $this->user = Authorization::getUserByToken();
        $this->view = new View();
        $this->view->setHeader('user', $this->user);
    }
}
