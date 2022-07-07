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
        if (empty($_POST)) {
            if ($this->user != null && $this->user->getTown() != null) {
                $town = $this->user->getTown();
            } else {
                $town = 'Москва';
            }
            $path = explode('/', $_SERVER['REQUEST_URI']);
            (isset($path[2])) ? $currentPage = $path[3] : $currentPage = 1;

            $events = Event::getAllEvents($town);


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
                        'size' => 35,
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
                    'paginator' => [
                        'currentPage' => $currentPage,
                        'perPage' => 3,
                        'prefix' => '/main/page/'
                    ],
                ],
                'page' => [
                    'type' => 'oneColumnDefault',
                    'title' => 'Главная'
                ]
            ];


            $this->view->generateHtml($data);
            return true;
        } else {
            header('location: /main');
            return true;
        }
    }
}
