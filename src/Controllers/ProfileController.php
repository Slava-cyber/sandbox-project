<?php

namespace App\Controllers;

use App\System\Controller;
use App\System\View as View;

class ProfileController extends Controller
{
    public function actionEdit()
    {
        $this->view->render('nsk');
        return true;
    }

    public function actionView($nickname)
    {
        echo $nickname;
        $this->view->render('l-a');
        return true;
    }

}
