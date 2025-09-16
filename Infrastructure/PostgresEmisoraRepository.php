<?php
namespace Infrastructure;

require_once __DIR__ . '/../Domain/EmisoraRepositoryInterface.php';
require_once __DIR__ . '/../Domain/Emisora.php';

use Domain\Emisora;
use Domain\EmisoraRepositoryInterface;
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

    public function delete($id): void {
        $stmt = $this->conn->prepare("DELETE FROM emisoras WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM emisoras");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapRowToEmisora($row), $rows);
    }

    public function findById($id): ?Emisora {
        $stmt = $this->conn->prepare("SELECT * FROM emisoras WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToEmisora($row) : null;
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

    private function mapRowToEmisora(array $row): Emisora {
    echo "Datos de la fila:\n";
    print_r($row);
    
    try {
        return new Emisora(
            $row['id'],
            new NombreEmisora($row['nombre']),
            new CanalEmisora($row['canal']),
            !empty($row['banda_fm']) ? new BandaFm($row['banda_fm']) : null,
            !empty($row['banda_am']) ? new BandaAm($row['banda_am']) : null,
            new NumLocutores((int)$row['num_locutores']),
            new GeneroEmisora($row['genero']),
            new HorarioEmisora($row['horario']),
            new PatrocinadorEmisora($row['patrocinador']),
            new PaisEmisora($row['pais']),
            new DescripcionEmisora($row['descripcion']),
            new NumProgramas((int)$row['num_programas']),
            new NumCiudades((int)$row['num_ciudades'])
        );
    } catch (\Exception $e) {
        echo "ERROR en mapRowToEmisora: " . $e->getMessage() . "\n";
        throw $e;
    }
}
}

