<?php

use Illuminate\Database\Capsule\Manager;
$env = parse_ini_file('../.env');

$capsule = new Manager;

 $capsule->addConnection([
    'driver'    => $env['DRIVE'],
    'host'      => $env['HOST'],
    'database'  => $env['DATABASE'],
    'username'  => $env['USERNAME'],
    'password'  => $env['PASSWORD'],
    'charset'   => $env['CHARSET'],
    'collation' => $env['COLLECTION'],
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();