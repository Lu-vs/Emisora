<?php
namespace Application\commands;

use Infrastructure\PostgresEmisoraRepository;

class FindEmisora {
    private $repository;

    public function __construct(PostgresEmisoraRepository $repository) {
        $this->repository = $repository;
    }

    public function execute($id) {
        return $this->repository->findById($id);
    }
}

