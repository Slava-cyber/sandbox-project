<?php

namespace App\Controllers;

use App\Models\Users\Authorization;
use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;

class ProfileController extends Controller
{
    public function actionView($nickname): bool
    {
        $user = User::getUserByLogin($nickname);
        if ($user instanceof User) {
            $this->view->render('Profile/profile', ['user' => $user]);
            return true;
        }

        return false;
    }

    public function actionEdit(): bool
    {
        if ($this->user instanceof User) {
            if (empty($_POST)) {
                $this->view->render('Profile/edit');
            } else {
                $user = User::profileEdit($_POST, $this->user);
                if ($user instanceof User) {
                    header('Location: /profile/' . $this->user->getLogin());
                } else {
                    header('Location: 404');
                }
            }
            return true;
        }
        header('Location: /login');
        return true;
    }
}

