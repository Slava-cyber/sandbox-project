<?php

namespace App\Controllers;

use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;
use App\Models\Events\Event as Event;
use App\System\Model as Model;

class MainController extends Controller
{
    public function actionIndex(): bool
    {
        //if (empty($_POST)) {
        //}
        $events = Event::getAllEvents();
        $this->view->render('Main/main', ['events' => $events]);
        return true;
    }
}
