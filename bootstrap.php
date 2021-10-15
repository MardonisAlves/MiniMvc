<?php
require __DIR__. '/vendor/autoload.php';
require __DIR__. '/config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';


$router = new \Mardonis\PhpMvcSiteCms\Router($method, $path);
$router->get('/ola-{nome}', 'App\Controllers\HomeController::hello');
$router->get('/users', 'App\Controllers\HomeController::listUsers');
$result = $router->handler();

// se retornar false, dou um erro 404 de página não encontrada
if (!$result) {
    http_response_code(404);
    echo 'Página não encontrada!';
    die();
}
// a nova linha
$twig = require(__DIR__ . '/renderView.php');

if ($result instanceof Closure) {
    // imprimo a página atual
    echo $result($router->getParams());

// se não for uma função anônima e for uma string
} elseif (is_string($result)) {
    // eu quebro a string nos dois-pontos, dois::pontos
    // transformando em array
    $result = explode('::', $result);

    // instancio o controller
    $controller = new $result[0]($twig);
    // guardo o método a ser executado (em um controller ele se chama action)
    $action = $result[1];

    // finalmente executo o método da classe
    echo $controller->$action($router->getParams());
}
