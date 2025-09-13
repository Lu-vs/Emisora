<?php
namespace Domain;

class Emisora {
    private ?int $id;
    private string $nombre;
    private string $canal;
    private string $bandaFm;
    private ?string $bandaAm;
    private int $numLocutores;
    private string $genero;
    private string $horario;
    private string $patrocinador;
    private string $pais;
    private string $descripcion;
    private int $numProgramas;
    private int $numCiudades;

    public function __construct(
        ?int $id,
        string $nombre,
        string $canal,
        string $bandaFm,
        ?string $bandaAm = null,
        int $numLocutores = 0,
        string $genero = '',
        string $horario = '',
        string $patrocinador = '',
        string $pais = '',
        string $descripcion = '',
        int $numProgramas = 0,
        int $numCiudades = 0
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->canal = $canal;
        $this->bandaFm = $bandaFm;
        $this->bandaAm = $bandaAm ?? '';
        $this->numLocutores = $numLocutores;
        $this->genero = $genero;
        $this->horario = $horario;
        $this->patrocinador = $patrocinador;
        $this->pais = $pais;
        $this->descripcion = $descripcion;
        $this->numProgramas = $numProgramas;
        $this->numCiudades = $numCiudades;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getCanal(): string { return $this->canal; }
    public function getBandaFm(): string { return $this->bandaFm; }
    public function getBandaAm(): string { return $this->bandaAm; }
    public function getNumLocutores(): int { return $this->numLocutores; }
    public function getGenero(): string { return $this->genero; }
    public function getHorario(): string { return $this->horario; }
    public function getPatrocinador(): string { return $this->patrocinador; }
    public function getPais(): string { return $this->pais; }
    public function getDescripcion(): string { return $this->descripcion; }
    public function getNumProgramas(): int { return $this->numProgramas; }
    public function getNumCiudades(): int { return $this->numCiudades; }
}

