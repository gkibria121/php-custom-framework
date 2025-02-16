<?php

declare(strict_types=1);


namespace Database;

use Exception;
use PDO;
use PDOStatement;

class Database
{

    public PDO $connection;
    private PDOStatement $stmt;
    public function __construct(array $config, string $username, string $password, string $dirver = 'mysql')
    {
        $dsn = $dirver . ":" . http_build_query(data: $config, arg_separator: ';');

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query(string $queryString, array $placeholders = [])
    {
        $this->stmt =  $this->connection->prepare($queryString);
        $this->stmt->execute($placeholders);
    }
}
