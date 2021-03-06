<?php
namespace App\Controllers;
use App\Models\User;

class HomeController extends Controller
{
   
    public function home()
    {
        return $this->twig->render('home/index.html');
    }

    public function listUsers()
    {
        $users =   User::all();
        return $this->twig->render('users/index.html',['users' => $users]);
    }
}