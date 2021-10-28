<?php

namespace Router;

use Illuminate\Support\Facades\App;
use Twig\Environment;

class Register
{
    public static function handle(Environment $twig, Router $router)
    {
        $loader = $twig->getLoader();
        $loader->addPath('../src/templates');
       
        $router->get('/users', 'App\Controllers\UsersController::index')
            // um middleware de autenticação
            ->before(function () {
                // troque de true para false e vice versa para ver o resultado
                // estou simulando um processo de verificação de usuário autenticado
                $checkUserIsAuth = true;
                if (!$checkUserIsAuth) {
                    http_response_code(401);
                    echo '<h1 style="color: red">Você não está autenticado</h1>';
                }
                return $checkUserIsAuth;
            })
            ->before(function () {
                echo '<p>segundo middleware</p>';
                return true;
            })
            ->before(function () {
                echo '<p>terceiro middleware</p>';
                return true;
            })
            ->after(function () {
                echo '<p>finalização</p>';
                return true;
            });
    }
}