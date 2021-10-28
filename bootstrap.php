<?php
use Illuminate\Support\Facades\Route;
require __DIR__. '/vendor/autoload.php';
require __DIR__. '/config/database.php';
$twig = require(__DIR__.'/renderView.php');

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';


$router = new \Router\Router($method, $path);
$router->get('/', 'App\Controllers\HomeController::home');
$router->get('/users', 'App\Controllers\UserController::listUsers');

Router\Register::handle($twig, $router);
$result = $router->handler();

if (!$result) {
    http_response_code(404);
    echo 'Página não encontrada!';
    die();
}

// pego os dados da entidade
$data = $result->getData();

// rodo os middlewares before
foreach ($data['before'] as $before) {
    // rodo o middleware
    if (!$before($router->getParams())) {
        // se retornar false eu paro a execução do código
        die();
    }
}

// rodo a ação principal
if ($data['action'] instanceof Closure) {
    echo $data['action']($router->getParams());
} elseif (is_string($data['action'])) {
    $data['action'] = explode('::', $data['action']);

    $controller = new $data['action'][0]($twig);
    $action = $data['action'][1];

    echo $controller->$action($router->getParams());
}


// rodo os middlewares after
foreach ($data['after'] as $after) {
    // rodo o middleware
    if (!$after($router->getParams())) {
        // se retornar false eu paro a execução do código
        die();
    }
}



if ($result instanceof Closure) {
    echo $result($router->getParams());
} elseif (is_string($result)) {
    $result = explode('::', $result);
    $controller = new $result[0]($twig);
    $action = $result[1];
    echo $controller->$action($router->getParams());
}

