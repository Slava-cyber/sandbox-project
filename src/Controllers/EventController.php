<?php

namespace App\Controllers;

use App\Controllers\Authorization;
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
                $data = [
                    'navbar' => [
                        'class' => 'navbar',
                        'type' => 'default',
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
                            '../js/validation',
                            '../js/eventValidation'
                        ]
                    ],
                    'page' => [
                        'type' => 'oneColumnDefault',
                        'title' => 'Создание ивента'
                    ]
                ];
                $this->view->generateHtml($data);
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
