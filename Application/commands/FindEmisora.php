<?php
namespace Application\commands;

use Domain\Emisora;
use Domain\EmisoraRepositoryInterface;

class FindEmisora {
    private EmisoraRepositoryInterface $repository;

    public function __construct(EmisoraRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(int $id): ?Emisora {
        return $this->repository->findById($id);
    }
}

