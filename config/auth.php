<?php

use App\Models\User;

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'user',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'user',

        ],
    ],

    'providers' => [
        'user' => [
            'driver' => 'eloquent',
            'model' => User::class,

        ]
    ],
    'secret' => env('JWT_SECRET')


];


