<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Validation\Validation as Validation;

class ValidationController extends Controller
{

    public function actionIndex()
    {
        //header("Content-Type: application/json; charset=UTF-8");
        $response['status'] = false;
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['form']) && isset($input['form'])) {
            $form = $input['form'];
            $data = $input['data'];

            $valid = new Validation($data, $form);
            $response['error'] = $valid->validate();
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
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($response);
        return true;
    }
}