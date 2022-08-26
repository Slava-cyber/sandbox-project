<?php

namespace App\Controllers;

use App\Models\Users\User as User;

class AdminUserEntityController extends AdminController
{
    public function actionCheckAdminStatus(): bool
    {
        $status = 'failure';
        if ($this->user instanceof User && $this->user->getRole() == 'administrator') {
                $status = 'success';
        }
        echo json_encode(['status' => $status]);

        return true;
    }
}
