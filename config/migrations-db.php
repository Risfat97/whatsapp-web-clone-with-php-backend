<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . "/../vendor/autoload.php";

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__ . "/../.env");

return [
    'dbname' => $_ENV['MYSQL_DATABASE'],
    'user' => $_ENV['MYSQL_USER'],
    'password' => $_ENV['MYSQL_PASSWORD'],
    'host' => $_ENV['MYSQL_HOST'],
    'driver' => 'pdo_mysql',
];