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

    public function __construct(array $dataOut, string $formOut)
    {
        $this->data = $dataOut;
        $this->form = $formOut;
        $this->rules = $this->rules();
    }

    public function validate(): array
    {
        $response['status'] = false;
        $response = [];
        if ($this->dataCheck())
        {
            $response['error'] = $this->formErrorArray();
            $count = 0;
            foreach($response['error'] as $field => $msg)
            {
                if ($msg != '')
                {
                    $count += 1;
                }
            }
            if ($count == 0) {
                $response['status'] = true;
            }
        }
        return $response;
    }

    private function formErrorArray(): array
    {
        $errors = [];

        foreach($this->data as $fields => $value)
        {
            $msg = '';
            $checkSet = explode('|', $this->rules[$fields]);
            while (!empty($checkSet) && $msg === '')
            {
                $checkType = array_shift($checkSet);
                $nameFunction = 'check' . ucfirst(explode(':', $checkType)[0]);
                $this->paramsFunction = $checkType;
                $msg = $this->$nameFunction($value);
                $errors[$fields] = $msg;
            }
        }
        return $errors;
    }

    private function dataCheck() : bool
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
            'login_sign_in' => 'required|in:user,login',
            'password'=> 'required|pswVerify',
            'phoneNumber' => 'match:/[a-z]+/',
        ];
    }

    private function checkPswVerify($value) : string {
        $msg = '';

        $user = User::findOneByColumn("login", $this->data['login_sign_in']);
        if ($user != null) {
            if (!password_verify($value, $user->getPassword())) {
                $msg = 'Неверный пароль';
            }
        } else {
            $msg = 'Такого пользователя не существует';
        }


        return $msg;
    }


    private function checkIn($value) : string {
        $msg = '';

        $params = ucfirst(explode(':', $this->paramsFunction)[1]);
        $params = explode(',', $params);
        $nameClass= $params[0];
        $fieldTable = $params[1];
        $object = User::findOneByColumn($fieldTable, $value);
        //$object = call_user_func_array(array($nameClass, '::findOneByColumn'), array($fieldTable, $value));
        if ($object == null)
        {
            $msg = 'Неправильное значение';
        }

        return $msg;
    }


    private function formsPattern() : array
    {
        return
            [
                'registration' => 'name/surname/sex/date_of_birth/login_sign_up/password_sign_up/password_confirm',
                'login' => 'login_sign_in/password',
            ];
    }


    private function checkBefore($value): string {
        $msg = '';
        $border = mktime(0,0,0, date("m"), date("d"), date("Y") - 3);
        //$border = date("Y-m-d", $border);
        if ($value > (date("Y-m-d", $border)))
        {
            $msg = 'Введите корректную дату, до '. date("Y-m-d", $border);
        }

        return $msg;
    }


    private function checkAfter($value): string {
        $msg = '';
        $border = mktime(0,0,0, date("m"), date("d"), date("Y") - 80);
        if ($value < date("Y-m-d", $border))
        {
            $msg = 'Введите корректную дату, после '. date("Y-m-d", $border);
        }

        return $msg;
    }

    private function checkUnique($value): string {
        $msg = '';

        $params = ucfirst(explode(':', $this->paramsFunction)[1]);
        $params = explode(',', $params);
        $nameClass= $params[0];
        $fieldTable = $params[1];
        $object = User::findOneByColumn($fieldTable, $value);
        //$object = call_user_func_array(array($nameClass, '::findOneByColumn'), array($fieldTable, $value));
        if ($object != null)
        {
            $msg = 'Такоe значение уже существует';
        }

        return $msg;
    }

    private function checkRequired($value): string {
        $msg = '';
        if (empty($value))
        {
            $msg = 'Заполните поле';
        }
        return $msg;
    }

    private function checkAlpha($value): string {
        $msg = '';
        if (!preg_match("~^([а-яА-ЯёЁa-zA-Z]+)$~", $value))
        {
            $msg = 'Поле должно содержать только буквы';
        }
        return $msg;
    }

    private function checkMax($value): string {
        $msg = '';

        $len = explode(':', $this->paramsFunction)[1];
        if (strlen($value) > $len)
        {
            $msg = 'Поле должно содержать не более '. $len . ' символов';
        }
        return $msg;
    }

    private function checkMin($value): string {
        $msg = '';

        $len = explode(':', $this->paramsFunction)[1];
        if (strlen($value) < $len)
        {
            $msg = 'Поле должно содержать не менее '. $len . ' символов';
        }
        return $msg;
    }

    private function checkBetween($value): string {
        $msg = '';

        $range = explode(':', $this->paramsFunction)[1];
        $range = explode(',', $range);
        if ((strlen($value) < $range[0]) || (strlen($value) > $range[1]))
        {
            $msg = 'Поле должно содержать от'. $range[0] . ' до ' . $range[1] . ' символов';
        }
        return $msg;
    }

    private function checkAlphaDash($value): string {
        $msg = '';
        //if (!preg_match("~[а-яА-ЯёЁa-zA-Z][а-яА-ЯёЁa-zA-Z_-]~", $value))
        if (!preg_match("~[a-zA-zа-яА-Я+0-9+_+-+]~", $value))
        {
            $msg = 'Допустимы только буквы, цифры, символы "_-". Начинаться должно с буквы';
        }
        return $msg;
    }

    private function checkSame($value): string {
        $msg = '';

        $same = explode(':', $this->paramsFunction)[1];
        if ($value != $this->data[$same])
        {
            $msg = 'Пароли не совпадают';
        }

        return $msg;
    }


    private function checkEqual($value): string {
        $msg = '';
        $equals = explode(":", $this->paramsFunction)[1];
        $equals = explode(',', $equals);
        if (!in_array($value, $equals))
        {
            $msg = 'Указано неверное значение';
        }
        return $msg;
    }

}