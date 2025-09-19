<?php
namespace Infrastructure;

require_once __DIR__ . '/../Domain/EmisoraRepositoryInterface.php';
require_once __DIR__ . '/../Domain/Emisora.php';



use Domain\Emisora;
use Domain\EmisoraRepositoryInterface;


class PostgresEmisoraRepository implements EmisoraRepositoryInterface {
    private \PDO $conn;

    public function __construct(\PDO $conn) {
        $this->conn = $conn;
    }

    

public function update(Emisora $emisora): void {
    $stmt = $this->conn->prepare("
        UPDATE emisoras SET
            nombre = :nombre,
            canal = :canal,
            banda_fm = :bandaFm,
            banda_am = :bandaAm,
            num_locutores = :numLocutores,
            genero = :genero,
            horario = :horario,
            patrocinador = :patrocinador,
            pais = :pais,
            descripcion = :descripcion,
            num_programas = :numProgramas,
            num_ciudades = :numCiudades
        WHERE id = :id
    ");

    $stmt->execute([
        ':id'           => $emisora->getId(),
        ':nombre'       => $emisora->getNombre()->value(),
        ':canal'        => $emisora->getCanal()->value(),
        ':bandaFm'      => $emisora->getBandaFm() ? $emisora->getBandaFm()->value() : null,
        ':bandaAm'      => $emisora->getBandaAm() ? $emisora->getBandaAm()->value() : null,
        ':numLocutores' => $emisora->getNumLocutores()->value(),
        ':genero'       => $emisora->getGenero()->value(),
        ':horario'      => $emisora->getHorario()->value(),
        ':patrocinador' => $emisora->getPatrocinador()->value(),
        ':pais'         => $emisora->getPais()->value(),
        ':descripcion'  => $emisora->getDescripcion()->value(),
        ':numProgramas' => $emisora->getNumProgramas()->value(),
        ':numCiudades'  => $emisora->getNumCiudades()->value(),
    ]);
}

    }

