<?php

use Framework\Paths;
use Framework\Template;

return [
    Template::class => fn() => new Template(Paths::$VIEWSDIR)
];
