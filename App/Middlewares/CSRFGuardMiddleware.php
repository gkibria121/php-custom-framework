<?php

declare(strict_types=1);


namespace App\Middlewares;

use App\Exceptions\ValidationException;
use Framework\Contracts\MiddlewareInterface;
use Framework\Template;

class CSRFGuardMiddleware implements MiddlewareInterface
{
    public function __construct(private Template $template) {}

    public function process(callable $next)
    {
        $methods = ["PUT", "POST", "DELETE"];
        if (!in_array($_SERVER["REQUEST_METHOD"], $methods)) {
            $next();
        }
        $_csrf = $_POST['_csrf'] ?? '';
        $currentCsrf = $_SESSION['_csrf'];

        if ($_csrf !== $currentCsrf) {
            throw new ValidationException(['_csrf' => 'Invalid CSRF token.']);
        }
        $next();
        unset($_SESSION['_csrf']);
    }
}
