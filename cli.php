<?php

declare(strict_types=1);

use Database\Database;

include __DIR__ . "/database/Database.php";

$databaseDir = __DIR__ . '/database';

$config = [

    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'phphiggy'

];


$db = new Database($config, 'root', '');
$create_users = file_get_contents($databaseDir . '/create_users_table.sql');
$create_transactions = file_get_contents($databaseDir . '/create_transaction_table.sql');
$create_receipts = file_get_contents($databaseDir . '/create_receipts_table.sql');
$db->query($create_users);
$db->query($create_transactions);
$db->query($create_receipts);
