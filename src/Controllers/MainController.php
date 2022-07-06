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
        $events = Event::getAllEvents();
        $data = [
            'navbar' => [
                'class' => 'navbar',
                'type' => 'default',
                'active' => 'Главная',
            ],
            'form' => [
                'class' => 'form',
                'name' => 'search',
                'button' => [
                    'name' => 'Найти',
                    'size' => 2,
                ],
                'type' => 'event',
                'page' => 'main',
                'separator' => true,
            ],
            'list' => [
                'class' => 'list',
                'type' => 'default',
                'data' => $events,
                'entity' => 'event',
                'typePart' => 'wholeView',
                'paginator' => true,
            ],
            'page' => [
                'type' => 'oneColumnDefault',
                'title' => 'Главная'
            ]
        ];
        $this->view->generateHtml($data);
        return true;
    }
}
