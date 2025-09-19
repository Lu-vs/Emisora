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

    public function save(Emisora $emisora): void {
        $stmt = $this->conn->prepare(
            "INSERT INTO emisoras (nombre, canal, banda_fm, banda_am, num_locutores, genero, horario, patrocinador, pais, descripcion, num_programas, num_ciudades)
             VALUES (:nombre, :canal, :bandaFm, :bandaAm, :numLocutores, :genero, :horario, :patrocinador, :pais, :descripcion, :numProgramas, :numCiudades)"
        );

        $stmt->execute([
            ':nombre'        => $emisora->getNombre()->value(),
            ':canal'         => $emisora->getCanal()->value(),
            ':bandaFm'       => $emisora->getBandaFm() ? $emisora->getBandaFm()->value() : null,
            ':bandaAm'       => $emisora->getBandaAm() ? $emisora->getBandaAm()->value() : null,
            ':numLocutores'  => $emisora->getNumLocutores()->value(),
            ':genero'        => $emisora->getGenero()->value(),
            ':horario'       => $emisora->getHorario()->value(),
            ':patrocinador'  => $emisora->getPatrocinador()->value(),
            ':pais'          => $emisora->getPais()->value(),
            ':descripcion'   => $emisora->getDescripcion()->value(),
            ':numProgramas'  => $emisora->getNumProgramas()->value(),
            ':numCiudades'   => $emisora->getNumCiudades()->value()
        ]);
    }

    
    }

