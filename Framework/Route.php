<?php

declare(strict_types=1);



namespace Framework;

use Error;
use Exception;

class Route
{


    private static array $routes = [];

    /**
     * @param array{class: string, method: string} $controller
     */
    public function add(string $path, $method, array $controller)
    {

        self::$routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,

        ];
    }
    private static function normalizeUri(string $uri)
    {
        $parsedUri = parse_url($uri);
        $pathName = $parsedUri['path'];
        $trimmedPathname = trim($pathName, '/');
        $pathName = preg_replace('#//#', "/", "/$trimmedPathname/");
        return $pathName;
    }

    public function dispatch(string $uri, string $method)
    {

        $url = $this->normalizeUri($uri);
        $method = strtoupper($method);
        $route = $this->findRoute($url, $method);

        if (!$route) {
            throw new Exception("Route Not Found!");
        }
        $controller = $route['controller'][0];
        $controllerMethod = $route['controller'][1];
        $controllerInstance = new $controller();
        $controllerInstance->$controllerMethod();
    }


    public function findRoute(string $uri, string $method): array|null
    {
        foreach (self::$routes as $route) {
            if ($route['path'] === $uri && $route['method'] === $method) {
                return $route;
            }
        }
        return null;
    }
    /**
     * @param array{class: string, method: string} $controller
     */
    public static function get(string $uri, array $controller)
    {
        $path = self::normalizeUri($uri);
        self::$routes[] = [
            'path' => $path,
            'method' => "GET",
            'controller' => $controller,

        ];
    }
}
