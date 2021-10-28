<?php
namespace App\Controllers;
use App\Models\User;
use App\Controllers\Controller;

class UserController extends Controller
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