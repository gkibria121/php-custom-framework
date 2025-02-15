<?php

declare(strict_types=1);



namespace Framework;

use Error;
use Exception;
use Framework\Contracts\Middleware;
use Framework\Exceptions\RouteException;
use Framework\Exceptions\RouteNotFound;

class Route
{


    private static array $routes = [];
    private static array $middlewares = [];

    /**
     * @param array{class: string, method: string} $controller
     */
    public function add(string $path, $method, array $controller)
    {

        self::$routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => []

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

    public function dispatch(string $uri, string $method, Container $container = null)
    {

        $url = $this->normalizeUri($uri);
        $method = strtoupper($method);
        $route = $this->findRoute($url, $method);

        if (!$route) {
            throw new RouteNotFound();
        }
        $controllerClass = $route['controller'][0];

        $controllerMethod = $route['controller'][1];



        $controllerInstance = $this->getInstance($container, $controllerClass);
        $action = fn() =>  $controllerInstance->$controllerMethod();
        $middlewares  = $route['middlewares'] ?? [];
        if (count($middlewares) == 0) {
            $action();
            return;
        }
        $actionWithMiddlewares = $this->applyMiddlewares($action, $middlewares, $container);
        $actionWithMiddlewares();
    }

    private function applyMiddlewares(callable $action, array $middlewares, Container  $container)
    {



        $middlewares = array_reverse($middlewares);

        foreach ($middlewares as $middleware) {
            $middlewareInstance = $this->getInstance($container, $middleware);
            $action = fn() => $middlewareInstance->process($action);
        }
        return $action;
    }

    private function getInstance(Container $container, string $className)
    {
        return $container ? $container->resolve($className) : new $className;
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
     * @template T of object
     * @param array{class: class-string<T>, method: key-of<T>} $controller
     */
    public static function get(string $uri, array $controller)
    {
        $path = self::normalizeUri($uri);
        self::$routes[] = [
            'path' => $path,
            'method' => "GET",
            'controller' => $controller,

        ];
        return new static();
    }
    public static function middlewares(string | array $middlewares)
    {
        $lastRoute = self::$routes[count(self::$routes) - 1];
        if (!$lastRoute) {
            throw new RouteException("Route does not exists.");
        }
        self::$routes[count(self::$routes) - 1]['middlewares'] = is_array($middlewares) ? $middlewares : [$middlewares];
        return new static();
    }
}
