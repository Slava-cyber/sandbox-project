<?php

namespace App\Controllers;

use App\Models\Users\Authorization;
use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;
use  App\Exceptions\InvalidArgumentException;

class UserController extends Controller
{
    public function actionSignUp()
    {
        $user = Authorization::getUserByToken();

        if ($user instanceof User)
        {
            header('Location: /main');
            return true;
        }

        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->render('Registration/registrationForm', ['error' => $e->getMessage()]);
                return true;
            }
            if ($user instanceof User) {
                Authorization::createToken($user);
                header('location: /main');
                //$this->view->render('Registration/SuccessRegistration');
                return true;
            }
        }

        $this->view->render('Registration/registrationForm');
        return true;
    }

    public function actionSignIn()
    {
        $user = Authorization::getUserByToken();

        if ($user instanceof User)
        {
            header('Location: /main');
            return true;
        }

        if (!empty($_POST)) {
            try {
                $user = User::signIn($_POST);
                //var_dump($user);
                Authorization::createToken($user);
                header('Location: /main');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->render('Login/loginForm', ['error' => $e->getMessage()]);
                return true;
            }
        }
        $this->view->render('Login/loginForm');
        return true;
    }

    public function actionLogout()
    {
        $user = Authorization::getUserByToken();
        if ($user instanceof User) {
            User::logout($user);
        }
        header('Location: /login');
        return true;
    }

}