<?php

declare(strict_types=1);

use Database\DB;

include __DIR__ . "/database/Database.php";

$databaseDir = __DIR__ . '/database';

$config = [

    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'phphiggy'

];


$db = new DB($config, 'root', '');
$create_users = file_get_contents($databaseDir . '/create_users_table.sql');
$db->query($create_users);
