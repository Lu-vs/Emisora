<?php
namespace Application\Usuario\commands;

use Domain\UsuarioRepositoryInterface;

class FindUser {
    private UsuarioRepositoryInterface $repository;

    public function __construct(UsuarioRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(int $id) {
        return $this->repository->findPublic($id);
    }
}

