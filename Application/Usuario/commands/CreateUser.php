<?php
namespace Application\Usuario\commands;

// 👇 Requerimos las dependencias manualmente
require_once __DIR__ . '/../../../Domain/Usuario.php';
require_once __DIR__ . '/../../../Domain/UsuarioRepositoryInterface.php';
require_once __DIR__ . '/../../../Domain/VO_User/Nombre.php';
require_once __DIR__ . '/../../../Domain/VO_User/Email.php';
require_once __DIR__ . '/../../../Domain/VO_User/Password.php';

use Domain\Usuario;
use Domain\UsuarioRepositoryInterface;
use Domain\VO_User\Nombre;
use Domain\VO_User\Email;
use Domain\VO_User\Password;

class CreateUser {
    private UsuarioRepositoryInterface $repository;

    public function __construct(UsuarioRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(int $id, string $nombre, string $email, string $password): void {
        $usuario = new Usuario(
            $id,
            new Nombre($nombre),
            new Email($email),
            new Password($password)
        );

        $this->repository->create($usuario);
    }
}

