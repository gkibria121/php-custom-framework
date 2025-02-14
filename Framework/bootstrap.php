<?php


include __DIR__ . "/../vendor/autoload.php";
include __DIR__ . "/functions.php";

use Framework\App;
use Framework\Route;

$app = new App(new Route());
$app->registerRoutes('web');
return $app;
