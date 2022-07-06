<?php

namespace App\View;

use App\System\View as View;
use App\Models\Events\Event as Event;
use App\Models\Users\User as User;

class EventView extends View
{
    public static function wholeView(Event $event, ?User $user): string
    {
        return EventView::render('Event/eventWholly', $user, ['event' => $event]);
    }
}
