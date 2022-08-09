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
        return ($this->category != null) ? $this->category : "";;
    }

    public function getSubcategory(): string
    {
        return ($this->description != null) ? $this->description : "";
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function getAuthor(): User
    {
        return User::getUserById($this->author);
    }


    public static function create(array $userData, User $user, string $form, int $id): ?Event
    {
        $event = null;
        $valid = new Validation($userData, $form);
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

            $checkId = Event::findOneByColumn('id', $id);
            if ($checkId != null) {
                $event->id = $id;
            }

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
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . static::getNameTable() . " WHERE 
        ( `datetime` > '" . $data['datetime'] . "' AND `town` = '" .
            $data['town'] . "' AND `title` LIKE  '" . $data['title'] . "')";
        if (isset($data['category']) && !empty($data['category'])) {
            $sql = $sql . " and ( `category` = '" . $data['category'] . "')";
        }
        $sql = $sql . "ORDER BY `datetime` ASC";
        $result = $db->query($sql, [], static::class);
        if ($result === []) {
            return null;
        }
        return $result;
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
