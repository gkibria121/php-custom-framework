<?php


include __DIR__ . "/../vendor/autoload.php";


use Framework\App;
use Framework\Route;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();
$app = new App(new Route());
$app->registerRoutes('web');
return $app;
