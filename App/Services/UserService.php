<?php

declare(strict_types=1);


namespace App\Services;

use Database\Database;

class UserService
{


    public function __construct(private Database $db) {}

    public function login(string $email, string $password)
    {
        echo "$email $password";
    }
    public function register(array $formData)
    {
        $password = password_hash($formData['password'], PASSWORD_BCRYPT);
        $this->db->query("INSERT INTO users(email,password, age, country, socialMediaURL) VALUES(:email,:password, :age, :country, :socialMediaURL)", [
            'email' => $formData['email'],
            'password' =>  $password,
            'age' => $formData['age'],
            'country' => $formData['country'],
            'socialMediaURL' => $formData['socialMediaUrl'],
        ]);
    }
    public function isEmailTaken(string $email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email", [
            "email" => $email
        ]);
        return $this->db->fetch()->count();
    }
}
