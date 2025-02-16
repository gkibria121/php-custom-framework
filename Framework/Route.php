<?php

declare(strict_types=1);



namespace Framework;

use Error;
use Exception;
use Framework\Contracts\Middleware;
use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\RouteException;
use Framework\Exceptions\RouteNotFound;

class Route
{


    private static array $routes = [];
    private static array $gropuMiddlewares = [];

    /**
     * @param array{class: string, method: string} $controller
     */

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
        $params = $this->getRouteParams($route, $url);
        $action = fn() =>  $controllerInstance->$controllerMethod(...$params);
        $middlewares  = $route['middlewares'] ?? [];


        if (count($middlewares) == 0) {
            $action();
            return;
        }
        $actionWithMiddlewares = $this->applyMiddlewares($action, $middlewares, $container);
        $actionWithMiddlewares();
    }


    private function getRouteParams(array $route, string $uri)
    {
        preg_match_all("#(?:{)([^\/]+)(?:})#", $route['path'], $kyes);

        $regPath = $route['regPath'];

        preg_match_all("#$regPath#", $uri, $values);
        array_shift($values);

        $params = array_combine($kyes[1]  ?? [],  flattenArray($values)  ?? []);
        if (count($params))
            return $params;
        return [];
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
            $regPath = $route["regPath"];
            if (preg_match("#$regPath#", $uri) && $route['method'] === $method) {

                return $route;
            }
        }


        return null;
    }
    public static function add(string $path, $method, array $controller)
    {
        $path = self::normalizeUri($path);
        $regPath = self::getRegPath($path);
        self::$routes[] = [
            'path' => $path,
            'method' =>  $method,
            'controller' => $controller,
            'middlewares' => self::$gropuMiddlewares,
            "regPath" =>  $regPath

        ];
    }
    private static function getRegPath(string $path)
    {

        $path = preg_replace("#(?:{)([^\\\/]+)(?:})#", "([^\\\/]+)", $path);

        return  "^$path$";
    }
    /**
     * @template T of object
     * @param array{class: class-string<T>, method: key-of<T>} $controller
     */
    public static function get(string $uri, array $controller)
    {
        self::add($uri, "GET", $controller);
        return new static();
    }

    public static function post(string $uri, array $controller)
    {
        self::add($uri, "POST", $controller);
        return new static();
    }
    public static function put(string $uri, array $controller)
    {
        self::add($uri, "PUT", $controller);
        return new static();
    }
    public static function delete(string $uri, array $controller)
    {
        self::add($uri, "DELETE", $controller);
        return new static();
    }
    public static function addMiddlewares(string | array $middlewares)
    {
        $lastRoute = self::$routes[count(self::$routes) - 1];
        if (!$lastRoute) {
            throw new RouteException("Route does not exists.");
        }

        $previousMiddlewares = self::$routes[count(self::$routes) - 1]['middlewares'] ?? [];
        $middlewares = is_array($middlewares) ? [...$previousMiddlewares, ...$middlewares] : [...$previousMiddlewares, $middlewares];

        self::$routes[count(self::$routes) - 1]['middlewares'] = $middlewares;

        return new static();
    }


    public static function group(array   $middlewares, callable $callable)
    {

        $previousMiddleware =  self::$gropuMiddlewares;
        self::$gropuMiddlewares = [...self::$gropuMiddlewares, ...$middlewares];

        $callable();
        self::$gropuMiddlewares = $previousMiddleware;

        return new static();
    }
}
