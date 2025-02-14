<?php

declare(strict_types=1);


function dd(mixed ...$args)
{
    echo "<pre >";
    var_dump(...$args);
    echo "</pre>";
    die();
}
