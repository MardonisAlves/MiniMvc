<?php
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';


$router = new \Router\RouteRequest($method, $path);
$router->get('/', 'App\Controllers\HomeController::home');
$router->get('/ola-{nome}', 'App\Controllers\HomeController::hello');
$router->get('/users', 'App\Controllers\HomeController::listUsers');
$result = $router->handler();

if (!$result) {
    http_response_code(404);
    echo 'Página não encontrada!';
    die();
}

$twig = require(__DIR__ . '/../config/renderView.php');

if ($result instanceof Closure) {
    echo $result($router->getParams());
} elseif (is_string($result)) {
    $result = explode('::', $result);
    $controller = new $result[0]($twig);
    $action = $result[1];
    echo $controller->$action($router->getParams());
}