<?php

declare(strict_types=1);


namespace App\Services;

use App\Exceptions\ValidationException;
use Database\Database;

class TransactionService
{


    public function __construct(private Database $db) {}




    public function addTransaction(array $formData)
    {

        $this->db->query("INSERT INTO transactions(user_id,description,amount,date) VALUES(:user_id,:description,:amount,:date)", [
            'description' => $formData['description'],
            'amount' => $formData['amount'],
            'date' => $formData['date'],
            'user_id' => $_SESSION['user']
        ]);
    }
    public function getUserTransactions(int $currentPage = 1, int $limit = 5, string $queryString = null): array
    {
        $limit = $limit;
        $offset = (($currentPage - 1) * $limit);



        $this->db->query("SELECT * FROM transactions WHERE user_id = :user_id AND   description LIKE '%$queryString%' LIMIT $limit OFFSET $offset", [
            'user_id' => $_SESSION['user'],
        ]);
        $transactions =  $this->db->fetchAll()->get();


        $this->db->query("SELECT * FROM transactions WHERE user_id = :user_id", [
            'user_id' => $_SESSION['user'],
        ]);
        $total = $this->db->fetchAll()->count();


        return [$transactions, $total];
    }
    public function getUserTransaction(int $id): array | bool
    {


        $this->db->query("SELECT * FROM transactions WHERE user_id = :user_id AND id = $id", [
            'user_id' => $_SESSION['user'],
        ]);

        return $this->db->fetch()->get();
    }
    public function updateUserTransaction(int $id, array $formData): array | bool
    {


        $this->db->query("UPDATE  transactions SET  description = :description, amount = :amount , date = :date WHERE user_id = :user_id AND id = $id", [
            'description' => $formData['description'],
            'amount' => $formData['amount'],
            'date' => $formData['date'],
            'user_id' => $_SESSION['user'],
        ]);

        return $this->getUserTransaction($id);
    }
}
