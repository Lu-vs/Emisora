<?php
//database
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../Infrastructure/Router.php';
require_once __DIR__ . '/../Infrastructure/PostgresEmisoraRepository.php';
// appliocation commands (Emisora)
require_once __DIR__ . '/../Application/commands/CreateEmisora.php';
require_once __DIR__ . '/../Application/commands/ListEmisora.php';
require_once __DIR__ . '/../Application/commands/DeleteEmisora.php';
require_once __DIR__ . '/../Application/commands/FindEmisora.php';
require_once __DIR__ . '/../Application/commands/UpdateEmisora.php';

//  Usuarios 
require_once __DIR__ . '/../Domain/Usuario.php';
require_once __DIR__ . '/../Domain/UsuarioRepositoryInterface.php';
require_once __DIR__ . '/../Infrastructure/PostgresUsuarioRepository.php';

// Value Objects de Usuario
require_once __DIR__ . '/../Domain/VO_User/Nombre.php';
require_once __DIR__ . '/../Domain/VO_User/Email.php';
require_once __DIR__ . '/../Domain/VO_User/Password.php';

// Application commands (Usuario)
require_once __DIR__ . '/../Application/Usuario/commands/CreateUser.php';
require_once __DIR__ . '/../Application/Usuario/commands/DeleteUser.php';
require_once __DIR__ . '/../Application/Usuario/commands/FindUser.php';
require_once __DIR__ . '/../Application/Usuario/commands/ListUser.php';
require_once __DIR__ . '/../Application/Usuario/commands/UpdateUser.php';

require_once __DIR__ . '/../Application/UsuarioEmisora/commands/AddEmisoraToUsuario.php';
require_once __DIR__ . '/../Application/UsuarioEmisora/commands/ListEmisorasOfUsuario.php';
require_once __DIR__ . '/../Application/UsuarioEmisora/commands/RemoveEmisoraFromUsuario.php';

use Infrastructure\Router;
use Infrastructure\PostgresEmisoraRepository;
use Infrastructure\PostgresUsuarioRepository;
//emiasora
use Application\commands\CreateEmisora;
use Application\commands\ListEmisora;
use Application\commands\DeleteEmisora;
use Application\commands\FindEmisora;
use Application\commands\UpdateEmisora;
//usuario
use Domain\Usuario;
use Application\Usuario\commands\CreateUser;
use Application\Usuario\commands\DeleteUser;
use Application\Usuario\commands\FindUser;
use Application\Usuario\commands\ListUser;
use Application\Usuario\commands\UpdateUser;
use Infrastructure\UsuarioResponse;
//usuarioEmisora
use Application\UsuarioEmisora\commands\AddEmisoraToUsuario;
use Application\UsuarioEmisora\commands\RemoveEmisoraFromUsuario;
use Application\UsuarioEmisora\commands\ListEmisorasOfUsuario;

header("Content-Type: application/json");

// repositorio y router
$repository = new PostgresEmisoraRepository($pdo);
$usuarioRepo = new PostgresUsuarioRepository($pdo);
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

/// USUARIOS

// Lista todos los usuarios (solo datos públicos)
$router->add('GET', '/usuarios', function() use ($usuarioRepo) {
    return $usuarioRepo->allPublic();
});

$router->add('GET', '/usuarios/(\d+)', function($id) use ($usuarioRepo) {
    $user = $usuarioRepo->findPublic((int)$id);
    if ($user) return $user;
    http_response_code(404);
    return ['error' => 'Usuario no encontrado'];
});

$router->add('POST', '/usuarios', function() use ($usuarioRepo) {
    $data = json_decode(file_get_contents("php://input"), true);
    $useCase = new CreateUser($usuarioRepo);
    $useCase->execute($data['id'], $data['nombre'], $data['email'], $data['password']);
    return ["status" => "Usuario creado"];
});

//borrar usuario
$router->add('DELETE', '/usuarios/(\d+)', function($id) use ($usuarioRepo) {
    $useCase = new DeleteUser($usuarioRepo);
    $useCase->execute((int)$id);
    return ["status" => "Usuario eliminado"];
});

$router->add('PUT', '/usuarios/(\d+)', function($id) use ($usuarioRepo) {
    $data = json_decode(file_get_contents("php://input"), true);
    $useCase = new UpdateUser($usuarioRepo);
    $useCase->execute((int)$id, $data['nombre'], $data['email']);
    return ["status" => "Usuario actualizado"];
});
//USUARIO EMISORA ------ GUARDAR EMISORAS ETC

$router->add('POST', '/usuarios/(\d+)/emisoras/(\d+)', function($userId, $emisoraId) use ($usuarioRepo, $repository) {
    try {
        $command = new AddEmisoraToUsuario($usuarioRepo, $repository);
        $command->execute((int)$userId, (int)$emisoraId);

        return ["message" => "Emisora asociada al usuario"];
    } catch (\Exception $e) {
        http_response_code(404);
        return ["error" => $e->getMessage()];
    }
});

$router->add('DELETE', '/usuarios/(\d+)/emisoras/(\d+)', function($userId, $emisoraId) use ($usuarioRepo, $repository) {
    try {
        $command = new RemoveEmisoraFromUsuario($usuarioRepo, $repository);
        $command->execute((int)$userId, (int)$emisoraId);

        return ["message" => "Emisora eliminada del usuario"];
    } catch (\Exception $e) {
        http_response_code(404);
        return ["error" => $e->getMessage()];
    }
});

$router->add('GET', '/usuarios/(\d+)/emisoras', function($userId) use ($usuarioRepo) {
    try {
        $command = new ListEmisorasOfUsuario($usuarioRepo);
        $emisoras = $command->execute((int)$userId);

        // devolver como array limpio
        $result = [];
        foreach ($emisoras as $e) {
            $result[] = [
                'id' => $e->getId(),
                'nombre' => $e->getNombre()->Value(),
                'canal' => $e->getCanal()->Value(),
                'banda_fm' => $e->getBandaFm()?->Value(),
                'banda_am' => $e->getBandaAm()?->Value(),
                'num_locutores' => $e->getNumLocutores()->Value(),
                'genero' => $e->getGenero()->Value(),
                'horario' => $e->getHorario()->Value(),
                'patrocinador' => $e->getPatrocinador()->Value(),
                'pais' => $e->getPais()->Value(),
                'descripcion' => $e->getDescripcion()->Value(),
                'num_programas' => $e->getNumProgramas()->Value(),
                'num_ciudades' => $e->getNumCiudades()->Value(),
            ];
        }

        return $result;
    } catch (\Exception $e) {
        http_response_code(404);
        return ["error" => $e->getMessage()];
    }
});
// lo que arma la vuelta de la url 
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);

