<?php

declare(strict_types=1);


function dd(array|null ...$args)
{
    echo "<pre >";
    var_dump(...$args);
    echo "</pre>";
    die();
}
