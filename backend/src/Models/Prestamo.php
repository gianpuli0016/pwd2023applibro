<?php

declare(strict_types=1);

namespace Raiz\Models;

use DateTime;

class Prestamo extends ModelBase
{
    /** @var Libro */
    private $libro;
    /** @var Socio */
    private $socio;
    private DateTime $fecha_desde;
    private DateTime $fecha_hasta;
    private $fecha_dev;

    public function __construct(
        ?int $id,
        Libro $libro,
        Socio $socio,
        DateTime $fecha_desde,
        DateTime $fecha_hasta,
        DateTime $fecha_dev = null
    ) {
        parent::__construct($id);
        $this->libro = $libro;
        $this->socio = $socio;
        $this->fecha_desde = $fecha_desde;
        $this->fecha_hasta = $fecha_hasta;
        $this->fecha_dev = $fecha_dev;
    }

    public function getSocio(): Socio
    {
        return $this->socio;
    }

    public function setSocio(Socio $socio): void
    {
        $this->socio = $socio;
    }

    public function getLibro(): Libro
    {
        return $this->libro;
    }

    public function setLibro(Libro $libro): void
    {
        $this->libro = $libro;
    }

    public function getFechaDesde(): DateTime
    {
        return $this->fecha_desde;
    }

    public function setFechaDesde(DateTime $fecha_desde): void
    {
        $this->fecha_desde = $fecha_desde;
    }

    public function getFechaHasta(): DateTime
    {
        return $this->fecha_hasta;
    }

    public function setFechaHasta(DateTime $fecha_hasta): void
    {
        $this->fecha_hasta = $fecha_hasta;
    }

    public function getFechaDev(): ?DateTime
    {
        return $this->fecha_dev;
    }

    public function setFechaDev(?DateTime $fecha_dev): void
    {
        $this->fecha_dev = $fecha_dev;
    }

    public function diasRetraso(int $id_libro): int
    {
        $hoy = new DateTime();
        $fecha_hasta = $this->getFechaHasta();

        if ($hoy > $fecha_hasta) {
            $diferencia = $hoy->diff($fecha_hasta);
            return $diferencia->days;
        }

        return 0;
    }

    public function cantLibrosPrestados($id_socio): int
    {
        $cant_libros_prestados = 0;

        if ($this->socio->getId() === $id_socio && $this->fecha_dev === null) {
            $cant_libros_prestados++;
        }

        return $cant_libros_prestados;
    }

    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'socio' => $this->socio->serializar(),
            'libro' => $this->libro->serializar(),
            'fecha_desde' => $this->fecha_desde->format('Y-m-d'),
            'fecha_hasta' => $this->fecha_hasta->format('Y-m-d'),
            'fecha_dev' => $this->fecha_dev !== null ? $this->fecha_dev->format('Y-m-d') : null,
        ];
    }

    public static function deserializar(array $datos): ModelBase
    {
        $id = $datos['id'] === null ? 0 : $datos['id'];
        $socio = $datos['socio'];
        $libro = $datos['libro'];
        $fecha_desde = \DateTime::createFromFormat('Y-m-d', $datos['fecha_desde']);
        $fecha_hasta = \DateTime::createFromFormat('Y-m-d', $datos['fecha_hasta']);
        $fecha_dev = isset($datos['fecha_dev']) ? DateTime::createFromFormat('Y-m-d', $datos['fecha_dev']) : null;

        return new self($id, $libro, $socio, $fecha_desde, $fecha_hasta, $fecha_dev);
    }
}
