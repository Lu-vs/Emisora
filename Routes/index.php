<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../Infrastructure/Router.php';
require_once __DIR__ . '/../Infrastructure/PostgresEmisoraRepository.php';
require_once __DIR__ . '/../Application/commands/CreateEmisora.php';
require_once __DIR__ . '/../Application/commands/ListEmisora.php';
require_once __DIR__ . '/../Application/commands/DeleteEmisora.php';
require_once __DIR__ . '/../Application/commands/FindEmisora.php';
require_once __DIR__ . '/../Application/commands/UpdateEmisora.php';

use Infrastructure\Router;
use Infrastructure\PostgresEmisoraRepository;
use Application\commands\CreateEmisora;
use Application\commands\ListEmisora;
use Application\commands\DeleteEmisora;
use Application\commands\FindEmisora;
use Application\commands\UpdateEmisora;

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

$router->add('GET', '/emisoras', function() use ($repository) {
    $useCase = new ListEmisora($repository);
    return $useCase->execute();
});

$router->add('GET', '/emisoras/(\d+)', function($id) use ($repository) {
    $useCase = new FindEmisora($repository);
    $emisora = $useCase->execute((int)$id);
    if ($emisora) {
        return $emisora;
    }
    http_response_code(404);
    return ["error" => "Emisora no encontrada"];
});

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

$router->add('DELETE', '/emisoras/(\d+)', function($id) use ($repository) {
    $useCase = new DeleteEmisora($repository);
    $useCase->execute((int)$id);
    return ["message" => "Emisora eliminada con éxito"];
});

// lo que arma la vuelta de la url 
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);

