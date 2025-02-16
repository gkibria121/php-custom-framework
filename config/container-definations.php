<?php

use App\Services\UserService;
use App\Services\ValidationService;
use Framework\Paths;
use Framework\Template;

return [
    Template::class => fn() => new Template(Paths::$VIEWSDIR),
    ValidationService::class => fn() => new ValidationService(),
    UserService::class => fn() => new UserService()
];
