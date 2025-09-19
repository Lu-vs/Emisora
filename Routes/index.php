<?php
//database
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../Infrastructure/Router.php';
require_once __DIR__ . '/../Infrastructure/PostgresEmisoraRepository.php';
// appliocation commands (Emisora)
require_once __DIR__ . '/../Application/commands/UpdateEmisora.php';

//  Usuarios 


// Application commands (Usuario)

use Infrastructure\Router;
use Infrastructure\PostgresEmisoraRepository;
use Application\commands\UpdateEmisora;
header("Content-Type: application/json");

// repositorio y router
$repository = new PostgresEmisoraRepository($pdo);
$router = new Router($repository);

$router->add('PUT', '/emisoras/(\d+)', function($id) use ($repository) {
    $data = json_decode(file_get_contents("php://input"), true);
    $useCase = new UpdateEmisora($repository);
    $updated = $useCase->execute((int)$id, $data);
    if ($updated) {
        return ["message" => "Emisora actualizada con éxito"];
    }
    http_response_code(404);
    return ["error" => "Emisora no encontrada"];
});

// lo que arma la vuelta de la url 
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);

