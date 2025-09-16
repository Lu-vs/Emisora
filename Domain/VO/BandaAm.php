<?php
namespace Domain\VO;

class BandaAm {
    private string $value;

    public function __construct(?string $value) {
        $this->value = $value ?? '';
    }

    public function Value(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}

