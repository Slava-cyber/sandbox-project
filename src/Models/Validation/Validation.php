<?php

namespace App\Models\Validation;

use App\Controllers\ValidationController;
use App\Exceptions\InvalidArgumentException as InvalidArgumentException;
use App\Models\Users\User as User;
use App\System\Model as Model;

class Validation
{
    private $data;
    private $form;
    private $rules;
    private $paramsFunction;

    public function __construct(array $data, string $form)
    {
        $this->data = $data;
        $this->form = $form;
        $this->rules = $this->rules();
    }

    public function validate(): array
    {
        $response['status'] = false;
        if ($this->dataCheck()) {
            $response['error'] = $this->formErrorArray();
            $response['status'] = $this->status($response['error']);
        }
        return $response;
    }

    private function status(array $error): bool
    {
        $status = false;
        if (count($error) == 1) {
            $field = array_key_first($error);
            if ($field == 'avatar') {
                $value = $error[$field];
                $segments = explode('/', $value);
                if (count($segments) > 1) {
                    $status = true;
                }
            }
        } elseif (count($error) == 0) {
            $status = true;
        }
        return $status;
    }

    private function formErrorArray(): array
    {
        $errors = [];

        foreach ($this->data as $fields => $value) {
            $msg = '';
            $checkSet = explode('|', $this->rules[$fields]);
            $i = 0;
            while (!empty($checkSet) && $msg === '') {
                $checkType = array_shift($checkSet);
                if ($checkType != 'required' && $value == '' && $i == 0) {
                    break;
                }
                $nameFunction = 'check' . ucfirst(explode(':', $checkType)[0]);
                $this->paramsFunction = $checkType;
                $msg = $this->$nameFunction($value);
                if ($msg != '' || $fields == 'avatar') {
                    $errors[$fields] = $msg;
                }
                $i += 1;
            }
        }
        return $errors;
    }

    private function dataCheck(): bool
    {
        $status = false;

        $formsPattern = Validation::formsPattern();

        if (isset($formsPattern[$this->form])) {
            $fields = explode('/', $formsPattern[$this->form]);
            $keys = array_keys($this->data);
            $comparison = array_intersect($keys, $fields);
            if (count($this->data) == count($comparison)) {
                $status = true;
            }
        }
        return $status;
    }

    private function rules(): array
    {

        return [
            'name' => 'required|alpha|max:20',
            'surname' => 'required|alpha|max:20',
            'sex' => 'required|equal:Male,Female',
            'login_sign_up' => 'required|unique:user,login|alphaDash|between:5,20',
            'date_of_birth' => 'required|before:2022-17-05|after:1950-28-05',
            'password_sign_up' => 'required|alphaDash|between:8,20',
            'password_confirm' => 'required|alphaDash|between:8,20|same:password_sign_up',
            'login_sign_in' => 'required',
            'password' => 'required',
            'phone_number' => 'match:/^(([+7,7,8])+([0-9]){10})$/',
            'town' => 'alphaDash|max:20',
            'interest' => 'alphaDash|max:150|min:5',
            'description' => 'alphaDash|max:400|min:5',
            'path_image' => 'image',
            'avatar' => 'addImage',
            'file' => 'none',
            'title' => 'required|min:5|max:30',
            'datetime' => 'required|after:current',
            'category' => 'in:category',
        ];
    }

    private function checkIn($value): string
    {
        $msg = "";
        $params = ucfirst(explode(':', $this->paramsFunction)[1]);
        if ($params == 'category') {
            if (!in_array($value, $this->arrayCategory())) {
                $msg = "Некорректная категория";
            }
        }
        return $msg;
    }


    private function arrayCategory(): array
    {
        return [
            'Другое',
            'Активный отдых',
            'Ночная жизнь',
            'Спорт',
            'Охота/рыбалка',
            'Квесты/настольные игры',
            'Туризм'
        ];
    }


    private function checkNone($value): string
    {
        return "";
    }

    private function checkImage($value): string
    {
        $msg = "";
        $path = ROOT . "../public" . $value;
        if (!file_exists($path) && $value != "") {
            $msg = "Файла не существует";
        } else {
            $properties = getimagesize($path);

            if ($properties === false) {
                $msg = "Файл не является изображением";
            } elseif ($properties[2] > 3 || $properties[2] < 2) {
                $msg = "Файл недопустимого формата. Загрузите файл с форматом .jpg или .png";
            } elseif (filesize($path) > 10 * 1024 * 1024) {
                $msg = 'Размер не должен превышать 10 Мб';
            }
        }
        return $msg;
    }

    private function checkAddImage($value): string
    {
        $msg = '';

        $imageFolder = ROOT . '../public/images/save/';
        $imageName = $value['name'];
        $path = Validation::createPath($imageName, $imageFolder);
        copy($value['tmp_name'], $path);

        $msg = $this->checkImage('/images/save/' . $imageName);
        if ($msg == "") {
            $msg = '/images/save/' . $imageName;
        }
        return $msg;
    }

    public static function createPath(string $nameFile, string $folder): string
    {
        if (file_exists($folder . $nameFile)) {
            $nameFile = Validation::generateNewName($folder, $nameFile);
        }
        return $folder . $nameFile;
    }

    public static function generateNewName(string $imageFolder, string $name): string
    {
        $i = 2;
        while (true) {
            $newName = $i . '-' . $name;
            if (!file_exists($imageFolder . $newName)) {
                break;
            }
            $i += 1;
        }
        return $newName;
    }

    private function formsPattern(): array
    {
        return
            [
                'registration' => 'name/surname/sex/date_of_birth/login_sign_up/password_sign_up/password_confirm',
                'login' => 'login_sign_in/password',
                'image' => 'avatar',
                'profile' => 'file/path_image/name/surname/date_of_birth/town/phone_number/interest/description/avatar',
                'eventAdd' => 'title/town/datetime/category/description',
            ];
    }

    private function checkBefore($value): string
    {
        $msg = '';
        $border = mktime(0, 0, 0, date("m"), date("d"), date("Y") - 3);
        if ($value > (date("Y-m-d", $border))) {
            $msg = 'Введите корректную дату, до ' . date("Y-m-d", $border);
        }

        return $msg;
    }

    private function checkAfter($value): string
    {
        $msg = '';
        $params = ucfirst(explode(':', $this->paramsFunction)[1]);
        if ($params == 'Current') {
            $border = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        } else {
            $border = mktime(0, 0, 0, date("m"), date("d"), date("Y") - 80);
        }
        if ($value < date("Y-m-d", $border)) {
            $msg = 'Введите корректную дату, начиная с ' . date("Y-m-d", $border);
        }

        return $msg;
    }

    private function checkUnique($value): string
    {
        $msg = '';

        $params = ucfirst(explode(':', $this->paramsFunction)[1]);
        $params = explode(',', $params);
        $nameClass = $params[0];
        $fieldTable = $params[1];
        $object = User::findOneByColumn($fieldTable, $value);

        //TODO It's necessary fix for common case - $object = call_user_func_array(array($nameClass, '::findOneByColumn'), array($fieldTable, $value));

        if ($object != null) {
            $msg = 'Такоe значение уже существует';
        }

        return $msg;
    }

    private function checkRequired($value): string
    {
        $msg = '';
        if (empty($value)) {
            $msg = 'Заполните поле';
        }
        return $msg;
    }

    private function checkAlpha($value): string
    {
        $msg = '';
        if (!preg_match("~^([а-яА-ЯР-Цр-цёЁa-zA-Z]+)$~", $value)) {
            $msg = 'Поле должно содержать только буквы';
        }
        return $msg;
    }

    private function checkMax($value): string
    {
        $msg = '';

        $len = explode(':', $this->paramsFunction)[1];
        if (iconv_strlen($value) > $len) {
            $msg = 'Поле должно содержать не более ' . $len . ' символов';
        }
        return $msg;
    }

    private function checkMin($value): string
    {
        $msg = '';

        $len = explode(':', $this->paramsFunction)[1];
        if (iconv_strlen($value) < $len) {
            $msg = 'Поле должно содержать не менее ' . $len . ' символов';
        }
        return $msg;
    }

    private function checkBetween($value): string
    {
        $msg = '';

        $range = explode(':', $this->paramsFunction)[1];
        $range = explode(',', $range);
        if ((strlen($value) < $range[0]) || (strlen($value) > $range[1])) {
            $msg = 'Поле должно содержать от' . $range[0] . ' до ' . $range[1] . ' символов';
        }
        return $msg;
    }

    private function checkMatch($value): string
    {
        $msg = "";
        $pattern = explode(':', $this->paramsFunction)[1];
        if (!preg_match($pattern, $value)) {
            $msg = 'Номер должен иметь формать (+7/7/8){9 цифр}';
        }

        return $msg;
    }

    private function checkAlphaDash($value): string
    {
        $msg = '';
        if (!preg_match("~[a-zA-zа-яёр-цА-Я+0-9_+-+]~", $value)) {
            $msg = 'Допустимы только буквы, цифры, символы "_-". Начинаться должно с буквы';
        }
        return $msg;
    }

    private function checkSame($value): string
    {
        $msg = '';

        $same = explode(':', $this->paramsFunction)[1];
        if ($value != $this->data[$same]) {
            $msg = 'Пароли не совпадают';
        }

        return $msg;
    }

    private function checkEqual($value): string
    {
        $msg = '';
        $equals = explode(":", $this->paramsFunction)[1];
        $equals = explode(',', $equals);
        if (!in_array($value, $equals)) {
            $msg = 'Указано неверное значение';
        }
        return $msg;
    }
}
