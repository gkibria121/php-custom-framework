<?php

declare(strict_types=1);


namespace App\Middlewares;

use App\Exceptions\ValidationException;
use Framework\Contracts\MiddlewareInterface;
use Framework\Template;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function __construct(private Template $template) {}

    public function process(callable $next)
    {

        try {
            $next();
        } catch (ValidationException $e) {
            echo $e->getMessage() . $e->getFile() . " " . $e->getLine();
            $_SESSION['errors'] = $e->errors;
            $_SESSION['oldData'] = $e->formData;
            if (!empty($_SERVER["HTTP_REFERER"]))
                redirectTo($_SERVER["HTTP_REFERER"]);
        }
    }
}
