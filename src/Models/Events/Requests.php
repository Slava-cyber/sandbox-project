<?php

namespace App\Models\Events;

use App\System\Model;
use App\Models\Events\Event;
use App\Models\Users\User;

class Requests extends Model
{
    protected $user;
    protected $author;
    protected $status;
    protected $event;

    public function getUser(): string
    {
        return $this->user;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getStatus(): string
    {
        return ($this->status != null) ? $this->status : "";
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public static function getRequests(array $events, User $user): ?array
    {
        $result = [];
        $i = 0;
        foreach ($events as $event) {
            if ($user == $event->getAuthor()) {
                $result[$i]['possibility'] = false;
            } else {
                $result[$i]['possibility'] = true;
            }
            $result[$i]['data'] = Requests::findOneByColumn('event', $event->getId());
            $i += 1;
        }
        return $result;
    }

    public static function create(array $data): ?Requests
    {
        $request = new Requests();
        $request->user = $data['user'];
        $request->event = $data['event'];
        $request->author = $data['author'];
        $request->status = 'Ожидает подтверждения';
        $request->save();
        return $request;
    }


    protected static function getNameTable(): string
    {
        return 'event_requests';
    }
}
