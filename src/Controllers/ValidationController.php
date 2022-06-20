<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Validation\Validation;

class ValidationController extends Controller {

    public function actionIndex() {
        $response['status'] = false;
        $input = json_decode(file_get_contents("php://input"), true);

        if (isset($input['form']) && isset($input['form']))
        {
            $form = $input['form'];
            $data = $input['data'];

            $response = Validation::validate($data, $form);
            // form json response;
            /*if (ValidationController::dataCheck($data, $form)) {
                $rules = ValidationController::rules();
                $validation = new Validation($data, $rules);
                $errors = $validation->formErrorArray();
                // form json response with array of errors;
            }*/
        }

        //form json response with status false and without errors;
    }

    /*
    private static function rules(): array
    {
        return [
            'name' => 'required|alpha|max:20',
            'surname' => 'required|alpha|max:20',
            'gender' => 'equal:Male,Female',
            'login_sign_up' => 'required|unique:users|alphaDash|between:5,20',
            'date_of_birth' => 'required|before:2022-17-05|after:1950-28-05',
            'password_sign_up' => 'required|alpha_dash|between:8,20',
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
    }*/


    // checking the correctness of the data set for the given form
/*    private static function dataCheck(array $data, string $form) : bool
    {
        $status = false;

        $formsPattern = ValidationController::formsPattern();

        if (isset($formsPattern[$form])) {
            $fields = explode('/', $formsPattern[$form]);
            $keys = array_keys($data);
            $comparison = array_intersect($keys, $fields);
            if (count($data) == count($comparison)) {
                $status = true;
            }
        }
        return $status;
    }*/

}