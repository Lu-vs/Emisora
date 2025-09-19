<?php
namespace Application\Usuario\commands;

require_once __DIR__ . '/../../../Domain/Usuario.php';
require_once __DIR__ . '/../../../Domain/UsuarioRepositoryInterface.php';
require_once __DIR__ . '/../../../Domain/VO_User/Nombre.php';
require_once __DIR__ . '/../../../Domain/VO_User/Email.php';

use Domain\UsuarioRepositoryInterface;
use Domain\VO_User\Nombre;
use Domain\VO_User\Email;

class UpdateUser {
    private UsuarioRepositoryInterface $repository;

    public function __construct(UsuarioRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(int $id, string $nombre, string $email): void {
        $this->repository->updatePublic(
            $id,
            new Nombre($nombre),
            new Email($email)
        );
    }
}

