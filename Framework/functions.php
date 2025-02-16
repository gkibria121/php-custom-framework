<?php

declare(strict_types=1);



use Framework\Exceptions\ConfigNotFound;
use Framework\Paths;
use Framework\Template;

function dd(mixed ...$args)
{
    dump(...$args);
    die();
}

function dump(mixed ...$args)
{

    echo "<pre >";
    var_dump(...$args);
    echo "</pre>";
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


function notFound()
{
    $templateEngine = new Template(Paths::$VIEWSDIR);
    echo $templateEngine->renderView("not-found");
}
function redirectTo(string $path)
{
    http_response_code(302);
    header("Location: $path");
    exit;
}

function back()
{
    redirectTo($_SERVER["HTTP_REFERER"]);
}

function env(string $key, string $default = null)
{

    return $_ENV[$key] ?? $default;
}


function flattenArray($arr)
{
    $res = [];

    foreach ($arr as $val) {
        if (is_array($val)) {
            $res = array_merge($res, flattenArray($val));
        } else {
            $res[] = $val;
        }
    }

    return $res;
}
