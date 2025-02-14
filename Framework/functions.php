<?php

declare(strict_types=1);

use Framework\Exceptions\ConfigNotFound;
use Framework\Paths;

function dd(mixed ...$args)
{
    echo "<pre >";
    var_dump(...$args);
    echo "</pre>";
    die();
}

function e(string $text)
{
    echo htmlspecialchars($text);
}

function config(string $name)
{
    try {
        $configDir = Paths::$CONFIGDIR;
        return include "$configDir/$name.php";
    } catch (Exception $e) {
        throw new  ConfigNotFound();
    }
}
