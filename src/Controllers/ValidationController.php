<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Validation\Validation as Validation;

class ValidationController extends Controller
{

    public function actionIndex()
    {
        //header("Content-Type: application/json; charset=UTF-8");
        $response = [];
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['form']) && isset($input['form'])) {
            $form = $input['form'];
            $data = $input['data'];

            $valid = new Validation($data, $form);
            $response = $valid->validate();

        } else {
            $response['status'] = false;
        }
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($response);
        return true;
    }
}