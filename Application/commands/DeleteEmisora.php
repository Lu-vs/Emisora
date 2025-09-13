<?php
namespace Application\commands;

use Infrastructure\PostgresEmisoraRepository;

class DeleteEmisora {
    private $repository;

    public function __construct(PostgresEmisoraRepository $repository) {
        $this->repository = $repository;
    }

    public function execute($id) {
        $this->repository->delete($id);
    }
}

