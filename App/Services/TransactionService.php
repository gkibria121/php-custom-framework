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

        $this->db->query("INSERT INTO transactions(user_id,discription,amount,date) VALUES(:user_id,:discription,:amount,:date)", [
            'discription' => $formData['description'],
            'amount' => $formData['amount'],
            'date' => $formData['date'],
            'user_id' => $_SESSION['user']
        ]);
    }
}
