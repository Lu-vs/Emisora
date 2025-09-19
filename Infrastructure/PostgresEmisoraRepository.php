<?php
namespace Infrastructure;

require_once __DIR__ . '/../Domain/EmisoraRepositoryInterface.php';
require_once __DIR__ . '/../Domain/Emisora.php';

use Domain\EmisoraRepositoryInterface;class PostgresEmisoraRepository implements EmisoraRepositoryInterface {
    private \PDO $conn;

    public function __construct(\PDO $conn) {
        $this->conn = $conn;
    }

    

    public function delete($id): void {
        $stmt = $this->conn->prepare("DELETE FROM emisoras WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

}

