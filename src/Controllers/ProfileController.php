<?php

namespace App\Controllers;

use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;

class ProfileController extends Controller
{
    public function actionView($nickname)
    {
        $user = User::getUserByLogin($nickname);
        if ($user instanceof User)
        {
            $this->view->render('Profile/profile', ['user' => $user]);
            return true;
        }

        return false;
    }

    public function actionEdit()
    {
        if ($this->user instanceof User) {
            $this->view->render('Profile/edit');
            return true;
        }

        return false;
    }

}
