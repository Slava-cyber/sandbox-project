<?php

namespace App\View;

use App\System\View;
use App\Models\Users\User as User;

class ModalWindowView extends View
{
    public static function simplyCase(array $info, string $innerContent, ?User $user): string
    {
        return self::render(
            'ModalWindow/simplyCase',
            $user,
            [
                'info' => $info,
                'innerContent' => $innerContent,
            ]
        );
    }
}