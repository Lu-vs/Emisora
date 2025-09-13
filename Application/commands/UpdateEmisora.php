<?php
namespace Application\commands;

use Infrastructure\PostgresEmisoraRepository;

class UpdateEmisora {
    private $repository;

    public function __construct(PostgresEmisoraRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(int $id, array $data): bool {
        return $this->repository->update($id, $data);
    }
}

