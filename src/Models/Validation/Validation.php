<?php

namespace App\Models\Validation;

use App\Controllers\ValidationController;

class Validation
{
    private $data;
    //private $rules;
    //private $errors;

    public function __constructor(array $data, array $rules)
    {
        $this->data = $data;
    }

    public function validate($form): array
    {
        $response['status'] = false;
        if (Validation::dataCheck($data, $form))
        {
            $rules = Validation::rules();
            $response['data'] = Validation::formErrorArray($data, $rules);
            if (empty($response['data']))
            {
                $response['status'] = true;
            }
        }
        return $response;
    }

    public static function formErrorArray($data, $rules): array
    {
        $errors = [];

        foreach($data as $field => $value)
        {
            $msg = '';
            $checkSet = explode('|', $rules[$field]);
            while (!empty($checkSet) && $msg === '')
            {
                $checkType = array_shift($checkSet);
                $nameFunction = 'check' . ucfirst(explode(':', $checkType)[0]);
                $msg = Validation::$nameFunction($value, $checkType);
                $errors[$field] = $msg;
            }
        }
        return $errors;
    }

    private static function dataCheck(array $data, string $form) : bool
    {
        $status = false;

        $formsPattern = Validation::formsPattern();

        if (isset($formsPattern[$form])) {
            $fields = explode('/', $formsPattern[$form]);
            $keys = array_keys($data);
            $comparison = array_intersect($keys, $fields);
            if (count($data) == count($comparison)) {
                $status = true;
            }
        }
        return $status;
    }

    private static function rules(): array
    {
        return [
            'name' => 'required|alpha|max:20',
            'surname' => 'required|alpha|max:20',
            'gender' => 'required|equal:Male,Female',
            'login_sign_up' => 'required|unique:users|alphaDash|between:5,20',
            'date_of_birth' => 'required|before:2022-17-05|after:1950-28-05',
            'password_sign_up' => 'required|alphaDash|between:8,20',
            'password_confirm' => 'same:password_sign_up',
            'login_sign_in' => 'required|in:users',
            'password'=> 'required|in:users',
            'phoneNumber' => 'match:/[a-z]+/',
        ];
    }

    private static function formsPattern() : array
    {
        return
            [
                'registration' => 'name/surname/login_sign_up/password_sign_up/password_confirm',
                'login' => 'login_sign_in, password',
            ];
    }



    private static function checkRequired($value, $params): string {
        $msg = '';
        if (empty($value))
        {
            $msg = 'Заполните поле';
        }
        return $msg;
    }

    private static function checkAlpha($value, $params): string {
        $msg = '';
        if (!preg_match("~^([а-яА-ЯёЁa-zA-Z]+)$~", $value))
        {
            $msg = 'Поле должно содержать только буквы';
        }
        return $msg;
    }

    private static function checkMax($value, $params): string {
        $msg = '';

        $len = explode(':', $params)[1];
        if (strlen($value) > $len)
        {
            $msg = ' Поле должно содержать меньше '. $len . ' символов';
        }
        return $msg;
    }

    private static function checkAlphaDash($value, $params): string {
        $msg = '';
        if (!preg_match("~[а-яА-ЯёЁa-zA-Z][а-яА-ЯёЁa-zA-Z_-]~", $value))
        {
            $msg = 'Допустимы только буквы, цифры, символы "_-". Начинаться должно с буквы';
        }
        return $msg;
    }


    private static function checkEqual($value, $params): string {
        $msg = '';
        $equals = explode(":", $params)[1];
        $equals = explode(',', $equals);
        if (!in_array($value, $equals))
        {
            $msg = 'указано неверное значение';
        }
        return $msg;
    }

}