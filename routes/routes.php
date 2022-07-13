<?php

return array
(
    '^(logout)$' => 'user/logout',
    '^(login)$' => 'user/signIn',
    '^(registration)$' => 'user/signUp',
    'main/page/([0-9]+)' => 'main/index',
    '^(main)$' => 'main/index',
    '^(profile/edit)$' => 'profile/edit',
    'profile/([a-zA-Zа-яА-ЯёЁр-цР-Ц0-9_.-]+)' => 'profile/view/$1',
    'validation' => 'validation/index',
    '^(event/add)$' => 'event/add',
    '^(sendRequest)$' => 'request/sendRequest',
    'event/current/page/([0-9]+)' => 'event/current',
    '^(event/current)$' => 'event/current',
    'event/archive/page/([0-9]+)' => 'event/archive',
    '^(event/archive)$' => 'event/archive',
    'event/([0-9]+)/request' => 'request/view/$1',
    //'Profile/([a-z,0-9]+)/comments' =>  ,
    //'Profile/([a-z,0-9]+)/comments/add' =>  ,
    //'Profile/([a-z,0-9]+)/comments/([0-9]+)/edit' =>  ,
    //'event/add' => ,
    //'event/([0-9]+)' =>   ,
    //'event/([0-9]+)/edit' =>   ,
    //'event/([0-9]+)/request' =>   ,
    //'event/current' =>   ,
    //'event/archive' =>   ,

);
