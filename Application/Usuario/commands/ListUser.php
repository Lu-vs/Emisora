<?php
namespace Application\Usuario\commands;

use Domain\UsuarioRepositoryInterface;

class ListUser {
    private UsuarioRepositoryInterface $repository;

    public function __construct(UsuarioRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(): array {
        return $this->repository->allpublic();
    }
}

