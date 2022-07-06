<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Validation\Validation as Validation;

class ValidationController extends Controller
{

    public function actionIndex(): bool
    {
        if (!empty($_POST)) {
            $formData = json_decode($_POST['all'], true);
            $form = $formData['form'];
            if (isset($formData['data'])) {
                $data = $formData['data'];
            }
            if (!empty($_FILES)) {
                $data = [
                    'avatar' => $_FILES['userfile'],
                ];
            }
            $valid = new Validation($data, $form);
            $response = $valid->validate();
            echo json_encode($response);
        } else {
            return false;
        }
        return true;
    }
}
