<?php

namespace App\Models\Validation;

use App\Controllers\ValidationController;

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
        if ($this->dataCheck())
        {
            //$rules = Validation::rules();
            $response['data'] = $this->formErrorArray();
            if (empty($response['data']))
            {
                $response['status'] = true;
            }
        }
        return $response;
    }

    private function formErrorArray(): array
    {
        $errors = [];

        foreach($this->data as $field => $value)
        {
            $msg = '';
            $checkSet = explode('|', $this->rules[$field]);
            while (!empty($checkSet) && $msg === '')
            {
                $checkType = array_shift($checkSet);
                $nameFunction = 'check' . ucfirst(explode(':', $checkType)[0]);
                $this->paramsFunction = $checkType;
                $msg = $this->$nameFunction($value, $checkType);
                $errors[$field] = $msg;
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

    private function formsPattern() : array
    {
        return
            [
                'registration' => 'name/surname/login_sign_up/password_sign_up/password_confirm',
                'login' => 'login_sign_in, password',
            ];
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
            $msg = ' Поле должно содержать меньше '. $len . ' символов';
        }
        return $msg;
    }

    private function checkAlphaDash($value): string {
        $msg = '';
        if (!preg_match("~[а-яА-ЯёЁa-zA-Z][а-яА-ЯёЁa-zA-Z_-]~", $value))
        {
            $msg = 'Допустимы только буквы, цифры, символы "_-". Начинаться должно с буквы';
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