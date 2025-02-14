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
    return htmlspecialchars($text);
}

function config(string $name)
{
    $configDir = Paths::$CONFIGDIR;
    $filePath = "$configDir/" . strtok($name, '.') . ".php";

    if (!file_exists($filePath)) {
        throw new  ConfigNotFound();
    }

    $data = include $filePath;
    $offset = strtok('.');
    while ($offset !== false) {
        $data = $data[$offset];
        $offset = strtok('.');
    }
    return $data;
}


function asset(string $path)
{
    $protocol = config('app.protocol');
    $serverName = config('app.host');

    return "$protocol://$serverName/$path";
}
