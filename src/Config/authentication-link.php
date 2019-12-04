<?php

return [
    'token' => [
        'lifetime' => 1000 * 60 // Default token lifetime
    ],

    'database_connection' => 'default',

    'user_model' => 'App\User',
    'system_model' => 'App\System',

    'migrations' => false,

];
