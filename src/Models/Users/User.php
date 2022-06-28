<?php

namespace App\Models\Users;

use App\Exceptions\InvalidArgumentException as InvalidArgumentException;
use App\Models\Validation\Validation as Validation;
use App\System\Db as Db;
use App\System\Model as Model;


class User extends Model
{
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
    protected $avatar;
    /*protected $rating = 0;
    protected $number_of_reviews = 0;*/
    protected $role;


    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function getTown()
    {
        return $this->town;
    }

    public function getInterest()
    {
        return $this->interest;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAvatar()
    {
        if ($this->avatar == null || !file_exists(ROOT . '../public' . $this->avatar)) {
            return null;
        } else {
            return $this->avatar;
        }
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getRole()
    {
        return $this->role;
    }

    /*public function getRating() {
        return $this->rating;
    }

    /*public function getNumberOfReviews() {
        return $this->number_of_reviews;
    }*/

    public function getPassword()
    {
        return $this->password;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    public static function signUp(array $userData): ?User
    {
        $user = null;
        $valid = new Validation($userData, 'registration');
        $status = $valid->validate();
        if ($status['status']) {
            $user = new User();
            $user->sex = $userData['sex'];
            $user->login = $userData['login_sign_up'];
            $user->name = $userData['name'];
            $user->surname = $userData['surname'];
            $user->dateOfBirth = $userData['date_of_birth'];
            $user->password = password_hash($userData['password_sign_up'], PASSWORD_DEFAULT);
            $user->role = 'user';
            $user->generateAuthToken();
            $user->save();
        }
        return $user;
    }

    public static function profileEdit(array $userData, User $user): ?User
    {
        $valid = new Validation($userData, 'profile');
        $status = $valid->validate();
        if ($status['status']) {
            $user->name = $userData['name'];
            $user->surname = $userData['surname'];
            $user->dateOfBirth = $userData['date_of_birth'];
            $user->town = $userData['town'];
            $user->interest = $userData['interest'];
            $user->description = $userData['description'];
            $user->phoneNumber = $userData['phone_number'];
            if ($userData['path_image'] != "") {
                unlink(ROOT . '../public' . $user->avatar);
                $newPath = User::storeImage($userData['path_image']);
                $user->avatar = $newPath;
            }
            $user->save();
        }
        return $user;
    }

    private static function storeImage($path)
    {
        $segments = explode('/', $path);
        $prefix = ROOT . '../public';
        $storePrefixPath = $prefix . '/images/avatar/';
        array_shift($segments);
        array_shift($segments);
        array_shift($segments);
        $imageName = implode($segments);
        //$newPath = '/images/avatar/' . implode($segments);
        if (file_exists($storePrefixPath . $imageName)) {
            $imageName = Validation::generateNewName($storePrefixPath, $imageName);
        }
        copy($prefix . $path, $storePrefixPath . $imageName);
        return '/images/avatar/' . $imageName;
    }

    public static function signIn(array $userData): ?User
    {
        $valid = new Validation($userData, 'login');
        $status = $valid->validate();
        if ($status) {
            $user = User::findOneByColumn("login", $userData['login_sign_in']);
            if ($user instanceof User && password_verify($userData['password'], $user->getPassword())) {
                $user->generateAuthToken();
                $user->save();
            } else {
                $user = null;
            }
        }
        return $user;
    }

    public static function logout(User $user): void
    {
        $user->generateAuthToken();
        $user->save();
    }

    public static function getUserByLogin($value): ?User
    {
        $user = User::findOneByColumn("login", $value);
        return $user;
    }


    private function generateAuthToken()
    {
        $this->authToken = sha1(random_bytes(50) . sha1(random_bytes(50)));
    }

    protected static function getNameTable(): string
    {
        return 'users';
    }

}
