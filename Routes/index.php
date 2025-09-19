<?php
//database
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../Infrastructure/Router.php';
require_once __DIR__ . '/../Infrastructure/PostgresEmisoraRepository.php';
// appliocation commands (Emisora)
require_once __DIR__ . '/../Application/commands/FindEmisora.php';

//  Usuarios 
// Application commands (Usuario)
use Infrastructure\Router;
use Infrastructure\PostgresEmisoraRepository;
use Application\commands\FindEmisora;
header("Content-Type: application/json");

// repositorio y router
$repository = new PostgresEmisoraRepository($pdo);
$router = new Router($repository);


$router->add('GET', '/emisoras/(\d+)', function($id) use ($repository) {
    $useCase = new FindEmisora($repository);
    $emisora = $useCase->execute((int)$id);
    if ($emisora) {
        return $emisora;
    }
    http_response_code(404);
    return ["error" => "Emisora no encontrada"];
});

// lo que arma la vuelta de la url 
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);

