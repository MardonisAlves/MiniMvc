<?php

use Illuminate\Database\Capsule\Manager;

$capsule = new Manager;

 $capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'blog_php_sem_framework',
    'username'  => 'root',
    'password'  => 'Jk8yup02@',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();