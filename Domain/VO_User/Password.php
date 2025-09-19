<?php
namespace Domain\VO_User;

class Password {
    private string $value;

    public function __construct(string $value) {
        if (strlen($value) < 6) {
            throw new \InvalidArgumentException("La contraseña debe tener al menos 6 caracteres.");
        }
        // 👉 Aquí podrías decidir si almacenar en texto plano o encriptado
        $this->value = password_hash($value, PASSWORD_BCRYPT);
    }

    public function verify(string $plainPassword): bool {
        return password_verify($plainPassword, $this->value);
    }

    public function getValue(): string {
        return $this->value;
    }
}

