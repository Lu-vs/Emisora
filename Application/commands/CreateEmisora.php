<?php
namespace Application\commands;

use Domain\Emisora;
use Domain\EmisoraRepositoryInterface;

class CreateEmisora {
    private $repository;

    public function __construct(EmisoraRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(array $data) {
        // Crear entidad emisora desde los datos
    $emisora = new Emisora(
            $data['id'],
            $data['nombre'],
            $data['canal'],
            $data['bandaFm'],
            $data['bandaAm'],
            $data['numLocutores'],
            $data['genero'],
            $data['horario'],
            $data['patrocinador'],
            $data['pais'],
            $data['descripcion'],
            $data['numProgramas'],
            $data['numCiudades']
        );

        // Guardar emisora en el repositorio
        $this->repository->save($emisora);
    }
}

