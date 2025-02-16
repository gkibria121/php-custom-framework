<?php

declare(strict_types=1);


namespace App\Middlewares;

use Exception;
use Framework\Contracts\MiddlewareInterface;
use RuntimeException;

class SessionMiddleware implements MiddlewareInterface
{
    public function __construct() {}

    public function process(callable $next)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new RuntimeException("Session is already active.");
        }
        if (headers_sent($filename, $line)) {
            throw new RuntimeException("Header is already sent. At File: $filename, Line : $line ");
        }
        session_set_cookie_params([
            "httpOnly" => true
        ]);
        session_start();


        $next();
    }
}
