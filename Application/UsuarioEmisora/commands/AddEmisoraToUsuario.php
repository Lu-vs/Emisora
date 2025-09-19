<?php
namespace Application\UsuarioEmisora\commands;

use Domain\UsuarioRepositoryInterface;
use Domain\EmisoraRepositoryInterface;
use Exception;

class AddEmisoraToUsuario {
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

        if ($this->usuarioRepo->checkEmisoraExists($usuario, $emisora)) {
            throw new Exception("La emisora ya está asociada al usuario");
        }

        $this->usuarioRepo->addEmisora($usuario, $emisora);
    }
}

