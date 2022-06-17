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
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->render('Registration/registrationForm', ['error' => $e->getMessage()]);
                return true;
            }
            if ($user instanceof User) {
                $this->view->render('Registration/SuccessRegistration');
                return true;
            }
        }

        $this->view->render('Registration/registrationForm');
        return true;
    }

    public function actionSignIn()
    {
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

}