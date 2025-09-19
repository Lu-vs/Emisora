<?php
//database
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../Infrastructure/Router.php';
require_once __DIR__ . '/../Infrastructure/PostgresEmisoraRepository.php';
// appliocation commands (Emisora)
require_once __DIR__ . '/../Application/commands/DeleteEmisora.php';

use Infrastructure\Router;
use Infrastructure\PostgresEmisoraRepository;
use Application\commands\DeleteEmisora;

header("Content-Type: application/json");

// repositorio y router
$repository = new PostgresEmisoraRepository($pdo);
$router = new Router($repository);


$router->add('DELETE', '/emisoras/(\d+)', function($id) use ($repository) {
    $useCase = new DeleteEmisora($repository);
    $useCase->execute((int)$id);
    return ["message" => "Emisora eliminada con éxito"];
});

// lo que arma la vuelta de la url 
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);

