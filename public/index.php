<?php
declare(strict_types=1);

session_start();

if (isset($_SESSION['loged'])) {
    $originalInfo = $_SESSION['loged'];
    unset($_SESSION['loged']);
    session_regenerate_id();
    $_SESSION['loged'] = $originalInfo;
}

require_once __DIR__ . "/../vendor/autoload.php";

use Rob\Aluraplay\Web\Request;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

$routes = require_once __DIR__ . "/../src/config/routes.php";

$request = new Request();
$requestRoute = "{$request->method}|{$request->path}";

if (!isset($routes[$requestRoute])) {
    $requestRoute = "404";
}

$controllerType = $routes[$requestRoute];
$controller = new $controllerType();
$controller->processRequest();
