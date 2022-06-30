<?php

return array
(
    '^(logout)$' => 'user/logout',
    '^(login)$' => 'user/signIn',
    '^(registration)$' => 'user/signUp',
    '^(main)$' => 'main/index',
    '^(profile/edit)$' => 'profile/edit',
    'profile/([a-z,0-9]+)' => 'profile/view/$1',
    'validation' => 'validation/index',
    '^(event/add)$' => 'event/add',
    //'profile/([a-z,0-9]+)/comments' =>  ,
    //'profile/([a-z,0-9]+)/comments/add' =>  ,
    //'profile/([a-z,0-9]+)/comments/([0-9]+)/edit' =>  ,
    //'event/add' => ,
    //'event/([0-9]+)' =>   ,
    //'event/([0-9]+)/edit' =>   ,
    //'event/([0-9]+)/request' =>   ,
    //'event/current' =>   ,
    //'event/archive' =>   ,

);
