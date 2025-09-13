<?php
use Application\commands\CreateEmisora;
use Infrastructure\PostgresEmisoraRepository;

require_once __DIR__ . '/../database/db.php';

// POST /emisoras → crear emisora
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/emisoras') {
    $data = json_decode(file_get_contents('php://input'), true);

    $repository = new PostgresEmisoraRepository($pdo);
    $useCase = new CreateEmisora($repository);
    $useCase->execute($data);

    echo json_encode(["message" => "Emisora creada con éxito"]);
    exit;
}

// GET /emisoras → listar emisoras
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/emisoras') {
    $repository = new PostgresEmisoraRepository($pdo);
    $emisoras = $repository->getAll();   // ✅ corregido: era findAll()

    echo json_encode($emisoras);
    exit;
}

// GET /emisoras/{id} → obtener una emisora por ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('#^/emisoras/(\d+)$#', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $matches)) {
    $id = (int)$matches[1];

    $repository = new PostgresEmisoraRepository($pdo);
    $useCase = new \Application\commands\FindEmisora($repository);
    $emisora = $useCase->execute($id);

    if ($emisora) {
        echo json_encode($emisora);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Emisora no encontrada"]);
    }
    exit;
}

// PUT /emisoras/{id} → actualizar emisora
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('#^/emisoras/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];
    $data = json_decode(file_get_contents('php://input'), true);

    $repository = new PostgresEmisoraRepository($pdo);
    $repository->update($id, $data);

    echo json_encode(["message" => "Emisora actualizada con éxito"]);
    exit;
}

// DELETE /emisoras/{id} → eliminar emisora
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#^/emisoras/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];

    $repository = new PostgresEmisoraRepository($pdo);
    $repository->delete($id);

    echo json_encode(["message" => "Emisora eliminada con éxito"]);
    exit;
}


