<?php

return array
(
    '^(logout)$' => 'user/logout',
    '^(login)$' => 'user/signIn',
    '^(registration)$' => 'user/signUp',
    'main/page/([0-9]+)' => 'main/index',
    '^(main)$' => 'main/index',
    '^(profile/edit)$' => 'profile/edit',
    'profile/([а-яА-ЯР-Цр-цёЁa-zA-Z]+)' => 'profile/view/$1',
    'validation' => 'validation/index',
    '^(event/add)$' => 'event/add',
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
