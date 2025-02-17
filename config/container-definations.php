<?php

use App\Library\Actions\FileManagerAction;
use App\Services\ReceiptService;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\ValidationService;
use Database\Database;
use Framework\Container;
use Framework\Paths;
use Framework\Template;

return [
    Template::class => fn() => new Template(Paths::$VIEWSDIR),
    ValidationService::class => fn() => new ValidationService(),
    UserService::class => function (Container $container) {;
        $db = $container->get(Database::class);
        return    new UserService($db);
    },
    FileManagerAction::class => fn() => new FileManagerAction(),

    Database::class => function () {
        $config = [
            'host' => env('HOST'),
            'port' =>  env('PORT'),
            'dbname' =>  env('DB_NAME'),

        ];
        $username =  env('DB_USER');
        $password =  env('DB_PASSWORD');
        $driver =  env('DB_DRIVER');
        return new Database($config, $username, $password, $driver);
    },
    TransactionService::class =>  function (Container $container) {;
        $db = $container->get(Database::class);
        return    new TransactionService($db);
    },
    ReceiptService::class =>  function (Container $container) {;
        $db = $container->get(Database::class);
        $fileManagerAction = $container->get(FileManagerAction::class);
        return    new ReceiptService($db, $fileManagerAction);
    },

];
