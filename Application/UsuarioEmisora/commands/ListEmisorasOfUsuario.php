<?php
namespace Application\UsuarioEmisora\commands;

use Domain\UsuarioRepositoryInterface;
use Exception;

class ListEmisorasOfUsuario {
    private $usuarioRepo;

    public function __construct(UsuarioRepositoryInterface $usuarioRepo) {
        $this->usuarioRepo = $usuarioRepo;
    }

    public function execute(int $userId): array {
        $usuario = $this->usuarioRepo->find($userId);

        if (!$usuario) {
            throw new Exception("Usuario no encontrado");
        }

        return $this->usuarioRepo->listEmisorasOfUsuario($usuario);
    }
}

