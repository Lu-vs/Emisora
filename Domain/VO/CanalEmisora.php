<?php
namespace Domain\VO;

class CanalEmisora {
    private string $value;

    public function __construct(string $value) {
        if (!preg_match('/^[0-9A-Za-z]+$/', $value)) {
            throw new \InvalidArgumentException("El canal debe ser alfanumérico.");
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

