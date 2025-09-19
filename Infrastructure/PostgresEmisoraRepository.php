<?php
namespace Infrastructure;

require_once __DIR__ . '/../Domain/EmisoraRepositoryInterface.php';
require_once __DIR__ . '/../Domain/Emisora.php';
require_once __DIR__ . '/../Domain/VO/NombreEmisora.php'; // si tienes más VO
require_once __DIR__ . '/../Domain/VO/CanalEmisora.php';
require_once __DIR__ . '/../Domain/VO/BandaFm.php';
require_once __DIR__ . '/../Domain/VO/BandaAm.php';
require_once __DIR__ . '/../Domain/VO/NumLocutores.php';
require_once __DIR__ . '/../Domain/VO/HorarioEmisora.php';
require_once __DIR__ . '/../Domain/VO/PatrocinadorEmisora.php';
require_once __DIR__ . '/../Domain/VO/PaisEmisora.php';
require_once __DIR__ . '/../Domain/VO/DescripcionEmisora.php';
require_once __DIR__ . '/../Domain/VO/NumProgramas.php';
require_once __DIR__ . '/../Domain/VO/NumCiudades.php';
require_once __DIR__ . '/../Domain/VO/GeneroEmisora.php';

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

    

    public function findById($id): ?Emisora {
        $stmt = $this->conn->prepare("SELECT * FROM emisoras WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToEmisora($row) : null;
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

