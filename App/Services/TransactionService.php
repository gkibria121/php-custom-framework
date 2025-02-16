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
        echo "Adding transaction...";
        dd($formData);
    }
}
