<?php
namespace Domain;

require_once __DIR__ . '/VO_User/Nombre.php';
require_once __DIR__ . '/VO_User/Email.php';
require_once __DIR__ . '/VO_User/Password.php';

use Domain\VO_User\Nombre;
use Domain\VO_User\Email;
use Domain\VO_User\Password;

class Usuario {
    private int $id;
    private Nombre $nombre;
    private Email $email;
    private ?Password $password;

    public function __construct(
        int $id,
        Nombre $nombre,
        Email $email,
        ?Password $password
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this-> password = $password;
  }

     public static function fromPublicData(int $id, Nombre $nombre, Email $email): self {
        return new self($id, $nombre, $email, null);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): Nombre {
        return $this->nombre;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function getPassword(): ?Password {
        return $this->password;
  }

}

