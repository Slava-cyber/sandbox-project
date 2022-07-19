<?php

namespace App\View;

use App\System\View;
use App\Models\Users\User as User;

class PageView extends View
{
    public static function oneColumnDefault(array $content, array $js, ?User $user, array $page)
    {
        $navbar = $content['navbar'];
        unset($content['navbar']);
        return PageView::render(
            'PageType/oneColumnDefault',
            $user,
            [
                'page' => $page,
                'js' => $js,
                'content' => $content,
                'navbar' => $navbar
            ]
        );
    }
}
