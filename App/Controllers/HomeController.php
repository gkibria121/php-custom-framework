<?php



declare(strict_types=1);



namespace App\Controllers;

use Framework\Paths;
use Framework\Template;

class HomeController
{

    public function __construct(private Template $template) {}

    public function index()
    {
        echo $this->template->renderView('home', ['title' => "Title is<p> home</p>"]);
    }
}
