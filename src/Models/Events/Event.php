<?php

namespace App\Models\Events;

use App\Exceptions\InvalidArgumentException as InvalidArgumentException;
use App\Models\Validation\Validation as Validation;
use App\System\Db as Db;
use App\System\Model as Model;
use App\Models\Users\User as User;
use App\System\TimeZone;


class Event extends Model
{
    protected $author;
    protected $title;
    protected $datetime;
    protected $town;
    protected $category;
    protected $subcategory;
    protected $description;


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTown(): string
    {
        return $this->town;
    }

    public function getDescription(): string
    {
        return ($this->description != null) ? $this->description : "";
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getDate()
    {
        return $this->datetime;
    }

    public function getAuthor(): User
    {
        return User::getUserById($this->author);
    }


    public static function create(array $userData, User $user): ?Event
    {
        $event = null;
        $valid = new Validation($userData, 'eventAdd');
        $status = $valid->validate();
        if ($status['status']) {
            $event = new Event();
            $event->author = $user->getId();
            $event->title = $userData['title'];
            $event->datetime = $userData['datetime'];
            if ($userData['town'] == "") {
                $userData['town'] = ($user->getTown() != null) ? $user->getTown() : 'Москва';
            }
            $event->town = $userData['town'];
            $event->category = $userData['category'];
            $event->description = ($userData['description'] != null) ? $userData['description'] : "";
            $event->save();
        }
        return $event;
    }

    public static function getAllEventsByUser(User $user, $date, string $type): ?array
    {
        $eventsCreation = self::getEventCreationByUser($user, $date, $type);
        $eventsByRequest = self::getEventByRequest($user, $date, $type);
        return array_merge($eventsCreation, $eventsByRequest);
    }

    public static function getEventCreationByUser(User $user, $date, string $type): ?array
    {
        $db = Db::getInstance();
        ($type == 'archive') ? $comparisonSign = '<' : $comparisonSign = '>';
        $sql = "SELECT * FROM " . static::getNameTable() . " WHERE (`author` = :value AND  `datetime` " .
            $comparisonSign . " '" . $date . "')";
        return $db->query($sql, ['value' => $user->getId()], static::class);
    }

    public static function getEventByRequest(User $user, $date, string $type): ?array
    {
        $db = Db::getInstance();
        ($type == 'archive') ? $comparisonSign = '<' : $comparisonSign = '>';
        $sql = "SELECT events.* FROM events 
                INNER JOIN event_requests ON 
                    (events.id = event_requests.event AND event_requests.user = :value) 
                WHERE events.datetime " . $comparisonSign . " :date";
        return $db->query($sql, ['value' => $user->getId(), 'date' => $date], static::class);
    }

    public static function getAllEvents(array $data): ?array
    {
        if (!isset($data['town'])) {
            $data['town'] = 'Москва';
        }
        if (!isset($data['datetime']) || empty($data['datetime'])) {
            $time = new TimeZone($data['town']);
            date_default_timezone_set('UTC');
            $duration = $time->timezone();
            $data['datetime'] = date("Y-m-d H:i:s", strtotime("+$duration sec"));
        }
        if (!isset($data['title'])) {
            $data['title'] = '%%';
        } else {
            $data['title'] = '%' . $data['title'] . '%';
        }
        return Event::getAll($data);
    }

    public static function checkExistenceEventByUser(User $user, int $id): ?Event
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM events WHERE `id` = :id AND `author` = :author LIMIT 1";
        $result = $db->query($sql, ['author' => $user->getId(), 'id' => $id], static::class);
        return ($result != null) ? $result[0] : null;
    }

    protected static function getNameTable(): string
    {
        return 'events';
    }
}
