<?php

namespace App\Models\Users;

use App\Exceptions\InvalidArgumentException as InvalidArgumentException;
use App\System\Db as Db;
use App\System\Model as Model;


class User extends Model {
    //protected $fields;
    protected $name;
    protected $surname;
    protected $login;
    protected $password;
    protected $authToken;
    protected $sex;
    protected $dateOfBirth;
    protected $town;
    protected $interest;
    protected $description;
    protected $phoneNumber;
    protected $role;

    public function getPassword() {
        return $this->password;
    }

    public function getAuthToken() {
        return $this->authToken;
    }

    public function getLogin() {
        return $this->login;
    }

    public static function signUp(array $userData) : ?User {
        //var_dump('data:', $userData['login']);
        if (static::findOneByColumn("login", $userData['login']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким логином уже сущетсвует');
        }

        $user = new User();
        $user->sex = $userData['gender'];
        $user->login = $userData['login'];
        $user->name = $userData['name'];
        $user->surname = $userData['surname'];
        $user->dateOfBirth = $userData['birth_date'];
        $user->password = password_hash($userData['password'], PASSWORD_DEFAULT);
        //$user->authToken = sha1(random_bytes(100) . sha1(random_bytes(100)));
        $user->role = 'user';
        $user->generateAuthToken();
        $user->save();
       /* if ($user->getId()==0) {
            throw new InvalidArgumentException('Что-то пошло не так, проверьте правильность полей');
        }*/
        return $user;
    }

    public static function signIn(array $userData) : User {
        $user = User::findOneByColumn("login", $userData['login']);
        //var_dump($user);
        if ($user == null) {
            throw new InvalidArgumentException('Пользователя с таким логином не сущетсвует');
        }

        if (!password_verify($userData['password'], $user->getPassword())) {
            throw new InvalidArgumentException('Неправильный пароль');
        }

        $user->generateAuthToken();
        //var_dump($user->authToken);
        $user->save();

        return $user;
    }

    public static function logout(User $user): void
    {
        $user->generateAuthToken();
        $user->save();
    }

    private function generateAuthToken() {
        $this->authToken = sha1(random_bytes(50) . sha1(random_bytes(50)));
    }

    protected static function getNameTable(): string {
        return 'users';
    }



}