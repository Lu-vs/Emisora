<?php
namespace Application\Usuario\commands;

use Domain\UsuarioRepositoryInterface;

class DeleteUser {
    private UsuarioRepositoryInterface $repository;

    public function __construct(UsuarioRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(int $id): void {
        $this->repository->delete($id);
    }
}


