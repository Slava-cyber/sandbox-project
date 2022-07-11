<?php

namespace App\Controllers;

use App\System\Controller;
use App\Models\Events\Requests;

class RequestController extends Controller
{
    public function actionSendRequest(): bool
    {
        if (!empty($_POST)) {
            $data = json_decode($_POST['all'], true);
            Requests::create($data);
        } else {
            return false;
        }
        return true;
    }
}
