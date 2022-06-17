<?php

namespace App\System;

use App\Models\Users\Authorization;

Abstract class Controller {

    protected $view;
    protected $user;

    public function __construct() {
        $this->user = Authorization::getUserByToken();
        //var_dump($this->user);
        $this->view = new View();
        $this->view->setHeader('user', $this->user);
    }
}