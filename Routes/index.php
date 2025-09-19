<?php
//database
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../Infrastructure/Router.php';
require_once __DIR__ . '/../Infrastructure/PostgresEmisoraRepository.php';
// appliocation commands (Emisora)
require_once __DIR__ . '/../Application/commands/CreateEmisora.php';




use Infrastructure\Router;
use Infrastructure\PostgresEmisoraRepository;
//emiasora
use Application\commands\CreateEmisora;
header("Content-Type: application/json");

// repositorio y router
$repository = new PostgresEmisoraRepository($pdo);
$router = new Router($repository);

$router->add('POST', '/emisoras', function() use ($repository) {
    $data = json_decode(file_get_contents("php://input"), true);
    $useCase = new CreateEmisora($repository);
    $useCase->execute($data);
    return ["message" => "Emisora creada con éxito"];
});


// lo que arma la vuelta de la url 
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);

