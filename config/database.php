<?php

return [
    'mysql' => [
        'driver'   => env('DB_CONNECTION','mysql'),
        'host'     => env('DB_HOST'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'charset'  => 'utf8',
        'collation'=> 'utf8_unicode_ci',
        'prefix'   => '',
    ]
];
