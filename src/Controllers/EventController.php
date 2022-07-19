<?php

namespace App\Controllers;

use App\Controllers\Authorization;
use App\System\Controller;
use App\System\View as View;
use App\Models\Users\User as User;
use App\Models\Events\Event as Event;
use App\Models\Events\Requests;

class EventController extends Controller
{
    public function actionAdd(): bool
    {
        if ($this->user instanceof User) {
            if (empty($_POST)) {
                $pageData = [
                    'navbar' => [
                        'active' => 'Создать ивент',
                    ],
                    'form' => [
                        'class' => 'form',
                        'type' => 'event',
                        'name' => 'eventAdd',
                        'page' => 'event/add',
                        'button' => [
                            'name' => 'Создать',
                            'position' => 'center',
                            'size' => 25,
                        ],
                        'js' => [
                            '../js/validation.js',
                            '../js/eventValidation.js'
                        ]
                    ],
                    'page' => [
                        'title' => 'Создание ивента'
                    ]
                ];
                $pageData = self::addBasicPageDataArray($this->data, $pageData);
                $this->view->print($pageData);
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

    public function actionCurrent()
    {
        if ($this->user instanceof User) {
            $pageData = self::pageListData();
            $pageData['navbar']['active'] = 'Текущие ивенты';
            $pageData['list']['paginator']['currentPage'] = self::getCurrentPage();
            $pageData['list']['paginator']['prefix'] = '/event/current/page/';
            $pageData['list']['title'] = 'Текущие ивенты';
            $pageData['page']['title'] = 'Текущие ивенты';
            $pageData['list']['data'] = self::formListData($this->user, 'current');
            $pageData = self::addBasicPageDataArray($this->data, $pageData);
            $this->view->print($pageData);
        } else {
            header('Location: /login');
        }
        return true;
    }

    public function actionArchive()
    {
        if ($this->user instanceof User) {
            $pageData = self::pageListData();
            $pageData['list']['paginator']['currentPage'] = self::getCurrentPage();
            $pageData['list']['paginator']['prefix'] = '/event/archive/page/';
            $pageData['list']['title'] = 'Прошедшие ивенты';
            $pageData['page']['title'] = 'Архив';
            $pageData['list']['data'] = self::formListData($this->user, 'archive');
            $pageData = self::addBasicPageDataArray($this->data, $pageData);
            $this->view->print($pageData);
        } else {
            header('Location: /login');
        }
        return true;
    }

    private static function formListData(User $user, string $type)
    {
        date_default_timezone_set('UTC');
        $date = date("Y-m-d");
        $events = Event::getAllEventsByUser($user, $date, $type);
        $requests = Requests::getRequests($events, $user);
        return self::arrayUnion($events, $requests, 'event', 'request');
    }


    private static function pageListData(): array
    {
        return [
            'list' => [
                'class' => 'list',
                'type' => 'oneColumnWithDivider',
                'entity' => 'event',
                'typePart' => 'wholeView',
                'paginator' => [
                    'perPage' => 3,
                ],
                'js' => [
                ]
            ],
        ];
    }
}
