<?php

namespace App\Models\Users;

use App\Exceptions\InvalidArgumentException as InvalidArgumentException;
use App\Models\Validation\Validation as Validation;
use App\System\Db as Db;
use App\System\Model as Model;
use App\Models\Events\Requests;


class User extends Model
{
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
    protected $email;
    protected $rating;
    protected $numberOfReviews;
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

    public function getRating()
    {
        return ($this->rating != null) ? number_format($this->rating, 1) : 0;
    }

    public function getNumberOfReviews()
    {
        return ($this->numberOfReviews != null) ? $this->numberOfReviews : 0;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    public function getEmail()
    {
        return $this->email;
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
        $segments = array_slice($segments, 3);
        $imageName = implode($segments);
        if (file_exists($storePrefixPath . $imageName)) {
            $imageName = Validation::generateNewName($storePrefixPath, $imageName);
        }
        copy($prefix . $path, $storePrefixPath . $imageName);
        return '/images/avatar/' . $imageName;
    }

    public static function saveEmail(array $userData, User $user): bool
    {
        $valid = new Validation($userData, 'email');
        if ($valid->validate()) {
            $user->email = $userData['email'];
            $user->save();
        } else {
            return false;
        }
        return true;
    }

    public static function checkLoginEmail(array $userData): string
    {
        $msg = '';
        if (!empty($userData['login']) && !empty($userData['email'])) {
            $db = Db::getInstance();
            $sql = "SELECT * FROM users WHERE `login` = :login AND `email` = :email";
            $result = $db->query(
                $sql,
                [
                    'login' => $userData['login'],
                    'email' => $userData['email'],
                ],
                static::class
            );
            if (empty($result)) {
                $msg = 'Неккоректные данные';
            }
        } else {
            $msg = 'Заполните все поля';
        }
        return $msg;
    }

    public static function signInPreparation(array $userData): ?User
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

    public static function changePassword(User $user, string $newPassword): ?User
    {
        $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
        $user->save();
        return $user;
    }

    public static function getUsersForRequests(array $requests): ?array
    {
        $result = [];
        $i = 0;
        foreach ($requests as $request) {
            $result[$i] = User::findOneByColumn('id', $request->getUser());
            $i += 1;
        }
        return $result;
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

    public static function getUserById($value): ?User
    {
        $user = User::findOneByColumn("id", $value);
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
