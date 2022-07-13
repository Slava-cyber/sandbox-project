<?php

namespace App\Models\Events;

use App\System\Model;
use App\Models\Events\Event;
use App\Models\Users\User;
use App\System\Db as Db;

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

    protected function setStatus($value): void
    {
        $this->status = $value;
    }

    public static function getRequests(array $events, ?User $user): ?array
    {
        $result = [];
        $i = 0;
        foreach ($events as $event) {
            if ($user == $event->getAuthor() || $user == null) {
                $result[$i]['possibility'] = false;
            } else {
                $result[$i]['possibility'] = true;
            }
            $result[$i]['data'] = Requests::findOneByColumn('event', $event->getId());
            $i += 1;
        }
        return $result;
    }

    public static function requestsForOneEvent(Event $event): ?array
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM event_requests WHERE `event` = :id";
        return $db->query($sql, ['id' => $event->getId()], static::class);
    }


    public static function changeRequestStatus(array $data, string $type): ?Requests
    {
        if (isset($data['id']) && $type != 'create') {
            $request = self::findOneByColumn('id', $data['id']);
            if ($request instanceof Requests) {
                if ($type == 'accept') {
                    $request->setStatus('Запрос принят');
                } else {
                    $request->setStatus('Запрос отклонен');
                }
            } else {
                return null;
            }
        } elseif (
            $type == 'create' &&
            isset($data['user']) &&
            isset($data['event']) &&
            isset($data['author'])
        ) {
            $request = new Requests();
            $request->user = $data['user'];
            $request->event = $data['event'];
            $request->author = $data['author'];
            $request->status = 'Ожидает подтверждения';
        } else {
            return null;
        }
        $request->save();
        return $request;
    }


    protected static function getNameTable(): string
    {
        return 'event_requests';
    }
}
