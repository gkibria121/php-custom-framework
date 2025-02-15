<?php


include __DIR__ . "/../vendor/autoload.php";


use Framework\App;
use Framework\Route;

$app = new App(new Route());
$app->registerRoutes('web');
return $app;
