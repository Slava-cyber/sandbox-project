<?php

namespace App\View;

use App\Models\Users\User as User;
use App\System\View;
use App\Models\Events\Requests;

class RequestView extends View
{
    public static function view(array $data, ?User $user, int $number): string
    {
        return EventView::render(
            'Request/request',
            $user,
            [
                'user' => $data['user'],
                'request' => $data['request'],
                'number' => $number,
            ]
        );
    }
}