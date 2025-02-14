<?php



declare(strict_types=1);



namespace App\Controllers;

use Framework\Paths;
use Framework\Template;

class HomeController
{
    private Template $template;
    public function __construct()
    {
        $this->template = new Template(Paths::$VIEWSDIR);
    }

    public function index()
    {
        echo $this->template->renderView('home');
    }
}
