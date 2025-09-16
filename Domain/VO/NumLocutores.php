<?php
namespace Domain\VO;

class NumLocutores {
    private int $value;

    public function __construct(int $value) {
        if ($value < 0) {
            throw new \InvalidArgumentException("El número de locutores no puede ser negativo.");
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

