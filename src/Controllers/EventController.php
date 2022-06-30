<?php

namespace App\Controllers;

use App\Models\Users\Authorization;
use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;
use App\Models\Events\Event as Event;

class EventController extends Controller
{
    public function actionAdd(): bool
    {
        if ($this->user instanceof User) {
            if (empty($_POST)) {
                $this->view->render('Event/add');
            } else {
                $event = Event::create($_POST, $this->user);
                if ($event instanceof Event) {
                    header('Location: /main');
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
