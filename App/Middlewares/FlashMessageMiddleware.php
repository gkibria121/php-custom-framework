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

        $this->template->addGlobal(['errors' => $errors]);
        $next();
        unset($_SESSION['errors']);
    }
}
