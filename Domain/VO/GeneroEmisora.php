<?php
namespace Domain\VO;

class GeneroEmisora {
    private string $value;

    public function __construct(string $value) {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException("El genero de la emisora no puede estar vacío.");
        }
        $this->value = $value;
    }

    public function Value(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}

