<?php

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../src/templates');

$twig = new \Twig\Environment($loader, [
    'cache' => '../cache',
]);

return $twig;