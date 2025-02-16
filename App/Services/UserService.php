<?php

declare(strict_types=1);


namespace App\Services;



class UserService
{


    public function __construct() {}

    public function login(string $email, string $password)
    {
        echo "$email $password";
    }
    public function register(array $formData)
    {
        dd($formData);
    }
}
