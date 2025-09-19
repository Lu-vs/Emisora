<?php
namespace Infrastructure;
//VOS de usuario
use Domain\Usuario;
use Domain\UsuarioRepositoryInterface;
use Domain\VO_User\Nombre;
use Domain\VO_User\Email;
use Domain\VO_User\Password;

///VOS de emisora
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

use PDO;

class PostgresUsuarioRepository implements UsuarioRepositoryInterface {
    private PDO $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

   public function create(Usuario $usuario): void {
        $stmt = $this->conn->prepare("
            INSERT INTO usuarios (id, nombre, email, password)
            VALUES (:id, :nombre, :email, :password)
        ");
        $stmt->execute([
            ':id'       => $usuario->getId(),
            ':nombre'   => $usuario->getNombre()->getValue(),
            ':email'    => $usuario->getEmail()->getValue(),
            ':password' => $usuario->getPassword()->getValue(),
        ]);
    }

    
public function updatePublic(int $id, Nombre $nombre, Email $email): void {
    $stmt = $this->conn->prepare("
        UPDATE usuarios
        SET nombre = :nombre, email = :email
        WHERE id = :id
    ");
    $stmt->execute([
        ':id' => $id,
        ':nombre' => $nombre->getValue(),
        ':email' => $email->getValue()
    ]);
}


    public function delete(int $id): void {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function find(int $id): ?Usuario {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToUsuario($row) : null;
    }

    public function all(): array {
        $stmt = $this->conn->query("SELECT * FROM usuarios");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapRowToUsuario($row), $rows);
    }
    //mapea los datos para enviar
    private function mapRowToUsuario(array $row): Usuario {
        return new Usuario(
            (int)$row['id'],
            new Nombre($row['nombre']),
            new Email($row['email']),
            new Password($row['password'] ?? '') // no lo estamos mandando solo guardando
        );
    }

    // Método público para exponer solo datos públicos (sin contraseña)
    public function allPublic(): array {
        return array_map(fn($user) => $this->toPublicArray($user), $this->all());
    }

    public function findPublic(int $id): ?array {
        $user = $this->find($id);
        return $user ? $this->toPublicArray($user) : null;
    }

    /** Convierte Usuario a array público */
    private function toPublicArray(Usuario $usuario): array {
        return [
            'id'     => $usuario->getId(),
            'nombre' => (string)$usuario->getNombre(),
            'email'  => (string)$usuario->getEmail(),
        ];
  }

//  EMISORA_USUARIO ---------  Sistema de guardar emisoras
// Solo inserta sin validar duplicado
public function addEmisora(Usuario $usuario, Emisora $emisora): void {
    $stmt = $this->conn->prepare(
        "INSERT INTO usuario_emisoras (usuario_id, emisora_id) VALUES (:uid, :eid)"
    );
    $stmt->execute([
        ':uid' => $usuario->getId(),
        ':eid' => $emisora->getId()
    ]);
}

public function removeEmisora(Usuario $usuario, Emisora $emisora): void {
    $stmt = $this->conn->prepare(
        "DELETE FROM usuario_emisoras WHERE usuario_id = :uid AND emisora_id = :eid"
    );
    $stmt->execute([
        ':uid' => $usuario->getId(),
        ':eid' => $emisora->getId()
    ]);
}

public function listEmisorasOfUsuario(Usuario $usuario): array {
    $stmt = $this->conn->prepare(
        "SELECT e.* FROM emisoras e
         INNER JOIN usuario_emisoras ue ON e.id = ue.emisora_id
         WHERE ue.usuario_id = :uid"
    );
    $stmt->execute([':uid' => $usuario->getId()]);
    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return array_map(fn($row) => $this->mapRowToEmisora($row), $rows);
}

public function checkEmisoraExists(Usuario $usuario, Emisora $emisora): bool {
    $check = $this->conn->prepare(
        "SELECT 1 FROM usuario_emisoras WHERE usuario_id = :uid AND emisora_id = :eid"
    );
    $check->execute([
        ':uid' => $usuario->getId(),
        ':eid' => $emisora->getId()
    ]);

    return (bool) $check->fetch();
}
    /** ------------------- MAPEO FILA → EMISORA ------------------- */

    private function mapRowToEmisora(array $row): Emisora {
        return new Emisora(
            (int)$row['id'],
            new NombreEmisora($row['nombre']),
            new CanalEmisora($row['canal']),
            $row['banda_fm'] !== null ? new BandaFm($row['banda_fm']) : null,
            $row['banda_am'] !== null ? new BandaAm($row['banda_am']) : null,
            new NumLocutores((int)$row['num_locutores']),
            new GeneroEmisora($row['genero']),
            new HorarioEmisora($row['horario']),
            new PatrocinadorEmisora($row['patrocinador']),
            new PaisEmisora($row['pais']),
            new DescripcionEmisora($row['descripcion']),
            new NumProgramas((int)$row['num_programas']),
            new NumCiudades((int)$row['num_ciudades'])
        );
    }
}


