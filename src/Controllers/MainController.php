<?php

namespace App\Controllers;

use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;

class MainController extends Controller
{
    public function actionIndex()
    {
        $this->view->render('Main/main');
        return true;
    }

}

