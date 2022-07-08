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
        $dataPage = self::pageData();
        $path = explode('/', $_SERVER['REQUEST_URI']);
        (isset($path[2])) ? $currentPage = $path[3] : $currentPage = 1;
        if (count($path) > 2) {
            $dataPage['list']['js'][0] = '../../js/mainPagination';
        }
        $dataPage['list']['paginator']['currentPage'] = $currentPage;


        if (empty($_POST)) {
            if ($this->user != null && $this->user->getTown() != null) {
                $data['town'] = $this->user->getTown();
            } else {
                $data['town'] = 'Москва';
            }
            $events = Event::getAllEvents($data);
        } else {
            $events = Event::getAllEvents($_POST);
        }
        $dataPage['list']['data'] = $events;
        $this->view->generateHtml($dataPage);
        return true;
    }

    private static function pageData(): ?array
    {
        return [
            'navbar' => [
                'class' => 'navbar',
                'type' => 'default',
                'active' => 'Главная',
            ],
            'form' => [
                'class' => 'form',
                'name' => 'search',
                'action' => '/main/page/1',
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
                'entity' => 'event',
                'typePart' => 'wholeView',
                'paginator' => [
                    'perPage' => 3,
                    'prefix' => '/main/page/'
                ],
                'js' => [
                    '/js/mainPagination',
                    ]
            ],
            'page' => [
                'type' => 'oneColumnDefault',
                'title' => 'Главная'
            ]
        ];
    }
}