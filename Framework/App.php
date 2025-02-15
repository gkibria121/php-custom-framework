<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\RouteNotFound;
use Framework\Route;

class App
{
    private Container $container;

    public function __construct(private  Route $router)
    {
        $this->container = new Container(config('container-definations'));
    }


    public function run()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];
        try {
            $this->router->dispatch($uri, $method, $this->container);
        } catch (RouteNotFound $e) {

            notFound();
        }
    }
    public function registerRoutes(string $filepath, string $prefix = '')
    {
        include __DIR__ . "/../routes/" . $filepath . ".php";
    }
}
