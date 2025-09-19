<?php
//database
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../Infrastructure/Router.php';
require_once __DIR__ . '/../Infrastructure/PostgresEmisoraRepository.php';
// appliocation commands (Emisora)
require_once __DIR__ . '/../Application/commands/ListEmisora.php';

//  Usuarios 

// Value Objects de Usuario


use Infrastructure\Router;
use Infrastructure\PostgresEmisoraRepository;
use Application\commands\ListEmisora;
header("Content-Type: application/json");

// repositorio y router
$repository = new PostgresEmisoraRepository($pdo);
$router = new Router($repository);

$router->add('GET', '/emisoras', function() use ($repository) {
    $useCase = new ListEmisora($repository);
    return $useCase->execute();
});

// lo que arma la vuelta de la url 
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);

