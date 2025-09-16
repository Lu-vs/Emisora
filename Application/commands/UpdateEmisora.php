<?php
namespace Application\commands;

use Domain\Emisora;
use Domain\VO\NombreEmisora;
use Domain\VO\CanalEmisora;
use Domain\VO\BandaFm;
use Domain\VO\BandaAm;
use Domain\VO\NumLocutores;
use Domain\VO\GeneroEmisora;
use Domain\VO\HorarioEmisora;
use Domain\VO\PatrocinadorEmisora;
use Domain\VO\PaisEmisora;
use Domain\VO\DescripcionEmisora;
use Domain\VO\NumProgramas;
use Domain\VO\NumCiudades;
use Domain\EmisoraRepositoryInterface;


require_once __DIR__ . '/../../Domain/VO/NombreEmisora.php';
require_once __DIR__ . '/../../Domain/VO/CanalEmisora.php';
require_once __DIR__ . '/../../Domain/VO/BandaFm.php';
require_once __DIR__ . '/../../Domain/VO/BandaAm.php';
require_once __DIR__ . '/../../Domain/VO/NumLocutores.php';
require_once __DIR__ . '/../../Domain/VO/GeneroEmisora.php';
require_once __DIR__ . '/../../Domain/VO/HorarioEmisora.php';
require_once __DIR__ . '/../../Domain/VO/PatrocinadorEmisora.php';
require_once __DIR__ . '/../../Domain/VO/PaisEmisora.php';
require_once __DIR__ . '/../../Domain/VO/DescripcionEmisora.php';
require_once __DIR__ . '/../../Domain/VO/NumProgramas.php';
require_once __DIR__ . '/../../Domain/VO/NumCiudades.php';



class UpdateEmisora {
    private EmisoraRepositoryInterface $repository;

    public function __construct(EmisoraRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(int $id, array $data): bool {
        $emisora = new Emisora(
            $id,
            new NombreEmisora($data['nombre']),
            new CanalEmisora($data['canal']),
            new BandaFm($data['bandaFm']),
            isset($data['bandaAm']) ? new BandaAm($data['bandaAm']) : null,
            new NumLocutores($data['numLocutores']),
            new GeneroEmisora($data['genero']),
            new HorarioEmisora($data['horario']),
            new PatrocinadorEmisora($data['patrocinador']),
            new PaisEmisora($data['pais']),
            new DescripcionEmisora($data['descripcion']),
            new NumProgramas($data['numProgramas']),
            new NumCiudades($data['numCiudades'])
        );

        $this->repository->update($emisora);
        return true;
    }
}

