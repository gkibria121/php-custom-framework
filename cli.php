<?php

declare(strict_types=1);

use Database\Database;

include __DIR__ . "/database/Database.php";


$config = [

    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'phphiggy'

];


$db = new Database($config, 'root', '');
