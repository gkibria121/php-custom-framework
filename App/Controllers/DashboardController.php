<?php



declare(strict_types=1);



namespace App\Controllers;

use Framework\Template;

class DashboardController
{

    public function __construct(private Template $template) {}

    public function index()
    {
        echo $this->template->renderView("dashboard", ['title' => "Dashboard"]);
    }
}
