<?php
namespace Application\UsuarioEmisora\commands;

use Domain\UsuarioRepositoryInterface;
use Domain\EmisoraRepositoryInterface;
use Exception;

class RemoveEmisoraFromUsuario {
    private $usuarioRepo;
    private $emisoraRepo;

    public function __construct(UsuarioRepositoryInterface $usuarioRepo, EmisoraRepositoryInterface $emisoraRepo) {
        $this->usuarioRepo = $usuarioRepo;
        $this->emisoraRepo = $emisoraRepo;
    }

    public function execute(int $userId, int $emisoraId): void {
        $usuario = $this->usuarioRepo->find($userId);
        $emisora = $this->emisoraRepo->findById($emisoraId);

        if (!$usuario || !$emisora) {
            throw new Exception("Usuario o emisora no encontrada");
        }

        $this->usuarioRepo->removeEmisora($usuario, $emisora);
    }
}


