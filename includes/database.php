<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$db = new mysqli( 
    $_SERVER["DB_HOST"], 
    $_SERVER["DB_USER"], 
    $_SERVER["DB_PASSWORD"], 
    $_SERVER["DB_SCHEME"]
);


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
