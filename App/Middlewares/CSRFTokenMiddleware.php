<?php

declare(strict_types=1);


namespace App\Middlewares;

use Framework\Contracts\MiddlewareInterface;
use Framework\Template;

class CSRFTokenMiddleware implements MiddlewareInterface
{
    public function __construct(private Template $template) {}

    public function process(callable $next)
    {


        $_csrf = $_SESSION['_csrf'] ?? bin2hex(random_bytes(32));
        $this->template->addGlobal(['_csrf' => $_csrf]);
        $_SESSION['_csrf'] = $_csrf;
        $next();
    }
}
