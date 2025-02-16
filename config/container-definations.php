<?php

use App\Services\UserService;
use App\Services\ValidationService;
use Database\DB;
use Framework\Paths;
use Framework\Template;

return [
    Template::class => fn() => new Template(Paths::$VIEWSDIR),
    ValidationService::class => fn() => new ValidationService(),
    UserService::class => function () {;
        $config = [
            'host' => env('HOST'),
            'port' =>  env('PORT'),
            'dbname' =>  env('DB_NAME'),

        ];
        $username =  env('DB_USER');
        $password =  env('DB_PASSWORD');
        $driver =  env('DB_DRIVER');

        return    new UserService(new DB($config, $username, $password, $driver));
    }
];
