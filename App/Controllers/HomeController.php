<?php



declare(strict_types=1);



namespace App\Controllers;

use Framework\Paths;
use Framework\Template;

class HomeController
{

    public function __construct(private Template $template) {}

    public function about()
    {
        echo $this->template->renderView('about', ['title' => "About"]);
    }
}
