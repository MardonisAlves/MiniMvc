<?php
namespace App\Controllers;
use App\Models\User;
use Twig\Environment;
class HomeController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    public function home()
    {
        return "Home";
    }

    public function hello($params)
    {
        return "Ola {$params[1]}";
    }

    public function listUsers()
    {
        return $this->twig->render('users/index.html', ['users' => User::all()]);
    }
}