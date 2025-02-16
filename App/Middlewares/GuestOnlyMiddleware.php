<?php

declare(strict_types=1);


namespace App\Middlewares;

use App\Exceptions\ValidationException;
use Framework\Contracts\MiddlewareInterface;
use Framework\Template;

class GuestOnlyMiddleware implements MiddlewareInterface
{
    public function __construct(private Template $template) {}

    public function process(callable $next)
    {
        if (isset($_SESSION['user'])) {
            redirectTo("/");
        }
        $next();
    }
}
