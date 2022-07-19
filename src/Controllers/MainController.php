<?php

namespace App\Controllers;

use App\System\Controller;
use App\System\TimeZone;
use App\System\View as View;
use App\Models\Users\User as User;
use App\Models\Events\Event as Event;
use App\System\Model as Model;
use App\Models\Events\Requests as Requests;

class MainController extends Controller
{
    public function actionIndex(): bool
    {
        $pageData = self::pageData();
        $path = explode('/', $_SERVER['REQUEST_URI']);
        (isset($path[2])) ? $currentPage = $path[3] : $currentPage = 1;
        $pageData['list']['js'][0] = '../../js/mainPagination.js';
        $pageData['list']['paginator']['currentPage'] = $currentPage;
        $searchParameters = self::prepareSearchParameters($_POST, $this->user);
        $events = Event::getallEvents($searchParameters);
        if (!empty($events)) {
            $requests = Requests::getRequests($events, $this->user);
            $pageData['list']['data'] = self::arrayUnion($events, $requests, 'event', 'request');
        }
        $pageData = self::addBasicPageDataArray($this->data, $pageData);
        $this->view->print($pageData);
        return true;
    }

    private static function prepareSearchParameters(?array $parameters, $user): array
    {
        $result = $parameters;
        if (empty($result['town'])) {
            if ($user != null && $user->getTown() != null) {
                $result['town'] = $user->getTown();
            } else {
                $result['town'] = 'Москва';
            }
        }
        if (empty($result['datetime'])) {
            $time = new TimeZone($result['town']);
            date_default_timezone_set('UTC');
            $duration = $time->timezone();
            $result['datetime'] = date("Y-m-d H:i:s", strtotime("+$duration sec"));
        }
        if (!isset($result['title'])) {
            $result['title'] = '%%';
        } else {
            $result['title'] = '%' . $result['title'] . '%';
        }
        return $result;
    }

    private static function pageData(): ?array
    {
        return [
            'navbar' => [
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
                'type' => 'oneColumnWithDivider',
                'entity' => 'event',
                'typePart' => 'wholeView',
                'data' => [],
                'paginator' => [
                    'perPage' => 3,
                    'prefix' => '/main/page/'
                ],
                'js' => [
                    '/js/mainPagination.js',
                    '/js/mainRequest.js'
                ]
            ],
            'page' => [
                'title' => 'Главная'
            ]
        ];
    }
}