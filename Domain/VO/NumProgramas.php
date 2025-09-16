<?php
namespace Domain\VO;

class NumProgramas {
    private int $value;

    public function __construct(int $value) {
        if ($value < 0) {
            throw new \InvalidArgumentException("El número de programas no puede ser negativo.");
        }
        $this->value = $value;
    }

    public function Value(): int {
        return $this->value;
    }

    public function __toString(): string {
        return (string) $this->value;
    }
}

