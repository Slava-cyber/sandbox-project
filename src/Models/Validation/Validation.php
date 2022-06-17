<?php

namespace App\Models\Validation;

class Validation
{
    private $data;
    private $rules;
    private $errors;

    public function __constructor(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function formErrorArray(): array
    {
        $errors = [];

        foreach($this->data as $field => $value)
        {
            $msg = '';
            $checkSet = explode('|', $this->rules[$field]);
            while (!empty($checkSet) && $msg === '')
            {
                $checkType = array_shift($checkSet);
                $nameFunction = 'check' . ucfirst(explode(':', $checkType[0]));
                $msg = Validation::$nameFunction($value, $checkSet[0]);
                $errors[$field] = $msg;
            }
        }

        return $errors;
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

        return $msg;
    }

    private static function checkMax($value, $params): string {
        $msg = '';

        return $msg;
    }

    private static function checkAlphaDash($value, $params): string {
        $msg = '';

        return $msg;
    }


    private static function checkEqual($value, $params): string {
        $msg = '';

        return $msg;
    }

}