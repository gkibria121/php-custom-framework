<?php



declare(strict_types=1);



namespace App\Controllers;

use App\Services\ValidationService;
use Framework\Template;

class AuthController
{

    public function __construct(private Template $template, private ValidationService $validationService) {}

    public function registerView()
    {
        echo $this->template->renderView("register", ['title' => "Register"]);
    }
    public function register()
    {
        $this->validationService->registrationValidate($_POST);
    }
}
