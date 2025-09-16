<?php
namespace Application\commands;

use Domain\EmisoraRepositoryInterface;

class ListEmisora {
    private EmisoraRepositoryInterface $repository;

    public function __construct(EmisoraRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(): array {
        return $this->repository->getAll();
    }
}

