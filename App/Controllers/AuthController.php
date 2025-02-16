<?php



declare(strict_types=1);



namespace App\Controllers;

use App\Services\UserService;
use App\Services\ValidationService;
use Framework\Template;

class AuthController
{

    public function __construct(private Template $template, private ValidationService $validationService, private UserService $userService) {}

    public function registerView()
    {
        echo $this->template->renderView("register", ['title' => "Register"]);
    }
    public function register()
    {
        $this->validationService->registrationValidate($_POST);
        $this->userService->isEmailTaken($_POST['email']);
        $this->userService->register($_POST);
        redirectTo('/');
    }
    public function loginView()
    {
        echo $this->template->renderView("login", ['title' => "Login"]);
    }
    public function login()
    {
        $this->validationService->loginValidate($_POST);
        $this->userService->login($_POST['email'], $_POST['password']);
        redirectTo("/");
    }
}
