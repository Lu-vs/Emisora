<?php
namespace Domain;

use Domain\Usuario;
use Domain\VO_User\Email;
use domain\VO_User\Nombre;
use Domain\Emisora;

interface UsuarioRepositoryInterface {
    public function create(Usuario $usuario): void;
    public function delete(int $id): void;
    public function find(int $id): ?Usuario;
    public function all(): array;

   //  Métodos públicos para la contraseña
    public function findPublic(int $id): ?array;
    public function allPublic(): array;
    public function updatePublic(int $id, Nombre $nombre, Email $email): void; // solo nombre/email
  // gestionar estaciones para usuario emisoras_usuario
    public function addEmisora(Usuario $usuario, Emisora $emisora): void; // inserta sin validar
    public function removeEmisora(Usuario $usuario, Emisora $emisora): void; // borra
    public function listEmisorasOfUsuario(Usuario $usuario): array; // devuelve array de Emisoras
    public function checkEmisoraExists(Usuario $usuario, Emisora $emisora): bool; // solo para uso interno de los commands
}

