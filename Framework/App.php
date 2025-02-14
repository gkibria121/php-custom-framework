<?php

declare(strict_types=1);

namespace Framework;

use Framework\Route;

class App
{

    public function __construct(private  Route $router) {}


    public function run()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];
        $this->router->dispatch($uri, $method);
    }
    public function registerRoutes(string $filepath, string $prefix = '')
    {
        include __DIR__ . "/../routes/" . $filepath . ".php";
    }
}
