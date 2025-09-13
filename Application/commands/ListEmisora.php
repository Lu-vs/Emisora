<?php
namespace Application\commands;

use Infrastructure\PostgresEmisoraRepository;

class ListEmisora {
    private $repository;

    public function __construct(PostgresEmisoraRepository $repository) {
        $this->repository = $repository;
    }

    public function execute() {
        return $this->repository->getAll();
    }
}

