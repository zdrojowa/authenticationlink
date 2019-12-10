<?php

return [
    'token' => [
        'lifetime' => 60 // Default token lifetime in seconds
    ],

    'database_connection' => 'mysql',

    'user_model' => 'Zdrojowa\AuthenticationLink\Models\User',
    'system_model' => 'Zdrojowa\AuthenticationLink\Models\System',
    'system_code' => env('AUTHENTICATION_LINK_SYSTEM_CODE'),
    'migrations' => true,
    'routes' => true,
    'failed_redirect_link' => '/',
    'success_redirect_link' => '/dashboard'

];
