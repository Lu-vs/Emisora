<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../Infrastructure/PostgresEmisoraRepository.php';
require_once __DIR__ . '/../Application/commands/CreateEmisora.php';
require_once __DIR__ . '/../Application/commands/ListEmisora.php';
require_once __DIR__ . '/../Application/commands/DeleteEmisora.php';
require_once __DIR__ . '/../Application/commands/FindEmisora.php'; // <<-- te faltaba este
require_once __DIR__ . '/../Application/commands/UpdateEmisora.php';

use Infrastructure\PostgresEmisoraRepository;
use Application\commands\CreateEmisora;
use Application\commands\ListEmisora;
use Application\commands\DeleteEmisora;
use Application\commands\FindEmisora;
use Application\commands\UpdateEmisora;

// instanciamos el repositorio con la conexión
$repository = new PostgresEmisoraRepository($pdo);

// ruta y método
$method = $_SERVER['REQUEST_METHOD'];
$uri = strtok($_SERVER["REQUEST_URI"], '?');

header("Content-Type: application/json");

if ($uri === '/emisoras' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $useCase = new CreateEmisora($repository);
    $useCase->execute($data);
    echo json_encode(["message" => "Emisora creada con éxito"]);
}

elseif ($uri === '/emisoras' && $method === 'GET') {
    $useCase = new ListEmisora($repository);
    $emisoras = $useCase->execute();
    echo json_encode($emisoras);
}

elseif (preg_match("#^/emisoras/(\d+)$#", $uri, $matches) && $method === 'DELETE') {
    $id = (int) $matches[1];
    $useCase = new DeleteEmisora($repository);
    $useCase->execute($id);
    echo json_encode(["message" => "Emisora eliminada con éxito"]);
}

elseif (preg_match("#^/emisoras/(\d+)$#", $uri, $matches) && $method === 'GET') {
    $id = (int)$matches[1];
    $useCase = new FindEmisora($repository);
    $emisora = $useCase->execute($id);

    if ($emisora) {
        echo json_encode($emisora);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Emisora no encontrada"]);
    }
}

elseif (preg_match("#^/emisoras/(\d+)$#", $uri, $matches) && $method === 'PUT') {
    $id = (int)$matches[1];
    $data = json_decode(file_get_contents("php://input"), true);

    $useCase = new UpdateEmisora($repository);
    $updated = $useCase->execute($id, $data);

    if ($updated) {
        echo json_encode(["message" => "Emisora actualizada con éxito"]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Emisora no encontrada"]);
    }
}

else {
    http_response_code(404);
    echo json_encode(["error" => "Ruta no encontrada"]);
}

