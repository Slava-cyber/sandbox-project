<?php

namespace App\View;

use App\System\View as View;
use App\Models\Users\User as User;

class ListView extends View
{
    public static function default(array $info, ?User $user): string
    {
        $classView = 'App\View\\' . ucfirst($info['entity']) . 'View';
        $method = $info['typePart'];
        $arrayOfItem = [];
        foreach ($info['data'] as $item) {
            $element = $classView::$method($item, $user);
            array_push($arrayOfItem, $element);
        }

        return ListView::render('Lists/listDefault', $user, ['arrayOfItem' => $arrayOfItem]);
    }
}
