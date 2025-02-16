<?php

declare(strict_types=1);


namespace App\Middlewares;

use Framework\Contracts\MiddlewareInterface;
use Framework\Template;

class AuthOnlyMiddleware implements MiddlewareInterface
{
    public function __construct(private Template $template) {}

    public function process(callable $next)
    {
        if (empty($_SESSION['user'])) {
            redirectTo("/login");
        }
        $next();
    }
}
