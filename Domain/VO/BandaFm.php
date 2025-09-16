<?php
namespace Domain\VO;

class BandaFm {
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

/* ejemplo de VO
class BandaFm {
    private string $value;

    public function __construct(string $value) {
        if (empty($value)) {
            throw new \InvalidArgumentException("La banda FM no puede estar vacía.");
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
*/
