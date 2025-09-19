<?php

namespace Domain\VO_User;

class Nombre {
    private string $value;

    public function __construct(string $value) {
        if (strlen($value) < 3) {
            throw new \InvalidArgumentException("El nombre de usuario debe tener al menos 3 caracteres.");
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}

