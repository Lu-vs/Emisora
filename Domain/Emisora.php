<?php
namespace Domain;

use Domain\VO\NombreEmisora;
use Domain\VO\CanalEmisora;
use Domain\VO\BandaFm;
use Domain\VO\BandaAm;
use Domain\VO\NumLocutores;
use Domain\VO\GeneroEmisora;
use Domain\VO\HorarioEmisora;
use Domain\VO\PatrocinadorEmisora;
use Domain\VO\PaisEmisora;
use Domain\VO\DescripcionEmisora;
use Domain\VO\NumProgramas;
use Domain\VO\NumCiudades;

class Emisora {
    private ?int $id;
    private NombreEmisora $nombre;
    private CanalEmisora $canal;
    private ?BandaFm $bandaFm;
    private ?BandaAm $bandaAm;
    private NumLocutores $numLocutores;
    private GeneroEmisora $genero;
    private HorarioEmisora $horario;
    private PatrocinadorEmisora $patrocinador;
    private PaisEmisora $pais;
    private DescripcionEmisora $descripcion;
    private NumProgramas $numProgramas;
    private NumCiudades $numCiudades;

    public function __construct(
        ?int $id,
        NombreEmisora $nombre,
        CanalEmisora $canal,
        ?BandaFm $bandaFm,
        ?BandaAm $bandaAm,
        NumLocutores $numLocutores,
        GeneroEmisora $genero,
        HorarioEmisora $horario,
        PatrocinadorEmisora $patrocinador,
        PaisEmisora $pais,
        DescripcionEmisora $descripcion,
        NumProgramas $numProgramas,
        NumCiudades $numCiudades
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->canal = $canal;
        $this->bandaFm = $bandaFm;
        $this->bandaAm = $bandaAm;
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
    public function getNombre(): NombreEmisora { return $this->nombre; }
    public function getCanal(): CanalEmisora { return $this->canal; }
    public function getBandaFm(): ?BandaFm { return $this->bandaFm; }
    public function getBandaAm(): ?BandaAm { return $this->bandaAm; }
    public function getNumLocutores(): NumLocutores { return $this->numLocutores; }
    public function getGenero(): GeneroEmisora { return $this->genero; }
    public function getHorario(): HorarioEmisora { return $this->horario; }
    public function getPatrocinador(): PatrocinadorEmisora { return $this->patrocinador; }
    public function getPais(): PaisEmisora { return $this->pais; }
    public function getDescripcion(): DescripcionEmisora { return $this->descripcion; }
    public function getNumProgramas(): NumProgramas { return $this->numProgramas; }
    public function getNumCiudades(): NumCiudades { return $this->numCiudades; }
}

