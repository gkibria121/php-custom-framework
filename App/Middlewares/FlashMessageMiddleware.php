<?php

declare(strict_types=1);


namespace App\Middlewares;

use Framework\Contracts\MiddlewareInterface;
use Framework\Template;

class FlashMessageMiddleware implements MiddlewareInterface
{
    public function __construct(private Template $template) {}

    public function process(callable $next)
    {
        $errors = $_SESSION["errors"] ?? [];
        $error = $_SESSION["error"] ?? null;
        $oldData = $_SESSION["oldData"] ?? [];
        $success = $_SESSION["success"] ?? null;

        $this->template->addGlobal(['errors' => $errors, 'error' => $error, 'oldData' => $oldData, 'success' => $success]);
        $next();
        unset($_SESSION['errors']);
        unset($_SESSION['oldData']);
        unset($_SESSION["success"]);
        unset($_SESSION["error"]);
    }
}
