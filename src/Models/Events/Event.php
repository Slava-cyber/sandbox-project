<?php

namespace App\Models\Events;

use App\Exceptions\InvalidArgumentException as InvalidArgumentException;
use App\Models\Validation\Validation as Validation;
use App\System\Db as Db;
use App\System\Model as Model;
use App\Models\Users\User as User;


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

    public static function getAllEvents(string $town): ?array
    {
        return Event::getAll('datetime', $town);
    }

    public static function getEvents(array $form): ?array
    {

    }

    protected static function getNameTable(): string
    {
        return 'events';
    }
}
