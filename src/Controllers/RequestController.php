<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Events\Requests;
use App\Models\Events\Event;
use App\Models\Users\User;
use App\Controllers\EventController;
use App\System\View;

class RequestController extends Controller
{
    public function actionSendRequest(): bool
    {
        if (!empty($_POST['all'])) {
            $wholeData = json_decode($_POST['all'], true);
            $type = $wholeData['type'];
            $data = $wholeData['data'];
            if ($type == 'create' || $type == 'accept' || $type == 'reject') {
                $request = Requests::changeRequestStatus($data, $type);
            } else {
                return false;
            }
        } else {
            return false;
        }
        return ($request instanceof Requests) ? true : false;
    }

    public function actionView($id): bool
    {
        if ($this->user instanceof User) {
            $event = Event::checkExistenceEventByUser($this->user, $id);
            if ($event != null) {
                $pageData = self::pageListData();
                $path = explode('/', $_SERVER['REQUEST_URI']);
                if (count($path) > 2) {
                    $pageData['list']['js'][0] = '../../../../js/eventRequest';
                }
                $pageData['list']['paginator']['currentPage'] = self::getCurrentPage();
                $pageData['list']['paginator']['prefix'] = '/event/' . $event->getId() . 'request/page/';
                $pageData['page']['title'] = 'Запросы к ивенту';
                $pageData['list']['table']['countColumn'] = 3;
                $pageData['list']['table']['data'] = [
                    'Пользователь (рейтинг/отзывы)',
                    'Статус запроса',
                    'Действие',
                ];


                $pageData['list']['data'] = self::formListData($event);
                $this->view->generateHtml($pageData);
            } else {
                return false;
            }
        } else {
            header('Location: /login');
        }
        return true;
    }

    private static function formListData(Event $event)
    {
        $requests = Requests::requestsForOneEvent($event);
        $users = User::getUsersForRequests($requests);
        return self::arrayUnion($users, $requests, 'user', 'request');
    }


    private static function pageListData(): array
    {
        return [
            'navbar' => [
                'class' => 'navbar',
                'type' => 'default',
            ],
            'list' => [
                'class' => 'list',
                'type' => 'default',
                'entity' => 'request',
                'typePart' => 'view',
                'data' => [],
                'paginator' => [
                    'perPage' => 3,
                ],
                'js' => [
                    '/js/eventRequest'
                ]
            ],
            'page' => [
                'type' => 'oneColumnDefault',
            ]
        ];
    }
}
