<?php

declare(strict_types=1);


namespace App\Services;

use Database\DB;

class UserService
{


    public function __construct(private DB $db) {}

    public function login(string $email, string $password)
    {
        echo "$email $password";
    }
    public function register(array $formData)
    {
        dd($formData);
    }
}
