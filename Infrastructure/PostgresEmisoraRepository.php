<?php
namespace Infrastructure;

require_once __DIR__ . '/../Domain/EmisoraRepositoryInterface.php';
require_once __DIR__ . '/../Domain/Emisora.php';

use Domain\EmisoraRepositoryInterface;
use Domain\Emisora;


class PostgresEmisoraRepository implements EmisoraRepositoryInterface {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function save(Emisora $emisora) {
    $stmt = $this->conn->prepare(
        "INSERT INTO emisoras (nombre, canal, banda_fm, banda_am, num_locutores, genero, horario, patrocinador, pais, descripcion, num_programas, num_ciudades)
         VALUES (:nombre, :canal, :bandaFm, :bandaAm, :numLocutores, :genero, :horario, :patrocinador, :pais, :descripcion, :numProgramas, :numCiudades)"
    );

    $stmt->execute([
        ':nombre' => $emisora->getNombre(),
        ':canal' => $emisora->getCanal(),
        ':bandaFm' => $emisora->getBandaFm(),
        ':bandaAm' => $emisora->getBandaAm(),
        ':numLocutores' => $emisora->getNumLocutores(),
        ':genero' => $emisora->getGenero(),
        ':horario' => $emisora->getHorario(),
        ':patrocinador' => $emisora->getPatrocinador(),
        ':pais' => $emisora->getPais(),
        ':descripcion' => $emisora->getDescripcion(),
        ':numProgramas' => $emisora->getNumProgramas(),
        ':numCiudades' => $emisora->getNumCiudades()
    ]);
}


    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM emisoras WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM emisoras");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM emisoras WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

public function update($id, $data): bool {
    $fields = [];
    $params = [':id' => $id];

    foreach ($data as $key => $value) {
        // convertir claves de camelCase a snake_case si hace falta
        switch ($key) {
            case 'bandaFm': $column = 'banda_fm'; break;
            case 'bandaAm': $column = 'banda_am'; break;
            case 'numLocutores': $column = 'num_locutores'; break;
            case 'numProgramas': $column = 'num_programas'; break;
            case 'numCiudades': $column = 'num_ciudades'; break;
            default: $column = $key;
        }
        $fields[] = "$column = :$key";
        $params[":$key"] = $value;
    }

    $sql = "UPDATE emisoras SET " . implode(', ', $fields) . " WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);

    return $stmt->rowCount() > 0;
}

}

