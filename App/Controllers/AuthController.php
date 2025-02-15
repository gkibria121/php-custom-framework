<?php



declare(strict_types=1);



namespace App\Controllers;

use Framework\Template;

class AuthController
{

    public function __construct(private Template $template) {}

    public function registerView()
    {
        echo $this->template->renderView("register", ['title' => "Register"]);
    }
}
