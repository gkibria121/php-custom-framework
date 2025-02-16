<?php

declare(strict_types=1);


namespace Database;

use PDO;
use PDOStatement;

class Database
{

    public PDO $connection;
    private PDOStatement $stmt;
    private mixed $result;
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

        return  $this->stmt->execute($placeholders);
    }
    public function fetch()
    {
        $this->result =  $this->stmt->fetch();
        return $this;
    }
    public function fetchAll()
    {
        $this->result =   $this->stmt->fetchAll();
        return $this;
    }
    public function count()
    {
        return $this->stmt->rowCount();
    }
    public function get()
    {
        return $this->result;
    }
}
