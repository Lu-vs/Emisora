<?php
namespace Application\commands;

use Domain\EmisoraRepositoryInterface;

class DeleteEmisora {
    private EmisoraRepositoryInterface $repository;

    public function __construct(EmisoraRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(int $id): void {
        $this->repository->delete($id);
    }
}

