<?php
namespace App\Controllers;
use Twig\Environment;

class Controller
{
    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
   
}