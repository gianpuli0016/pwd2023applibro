<?php

declare(strict_types=1);

namespace Raiz\Models;

use DateTime;

class Socio extends ModelBase
{
    private string $nombre_apellido;
    private DateTime $fecha_alta;
    private int $activo;
    private int $telefono;
    private string $direccion;

    function __construct(
        int $id,
        string $nombre_apellido,
        DateTime $fecha_alta,
        int $activo,
        int $telefono,
        string $direccion
    ) {
        parent::__construct($id);
        $this->nombre_apellido = $nombre_apellido;
        $this->fecha_alta = $fecha_alta;
        $this->activo = $activo;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
    }

    public function getFecha_alta(): DateTime
    {
        return $this->fecha_alta;
    }

    public function setFecha_alta(DateTime $fecha_alta): void
    {
        $this->fecha_alta = $fecha_alta;
    }

    public function isActivo(): bool
    {
        return $this->activo === 1;
    }

    public function setActivo(bool $activo): void
    {
        $this->activo = $activo ? 1 : 0;
    }

    public function getTelefono(): int
    {
        return $this->telefono;
    }
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'nombre_apellido' => $this->nombre_apellido,
            'fecha_alta' => $this->fecha_alta->format('Y-m-d'),
            'activo' => $this->activo,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
        ];
    }

    public static function deserializar(array $datos): self
    {
        $id = $datos['id'];
        $nombre_apellido = $datos['nombre_apellido'];
        $fecha_alta = \DateTime::createFromFormat('Y-m-d', $datos['fecha_alta']);
        $activo = $datos['activo'];
        $telefono = $datos['telefono'];
        $direccion = $datos['direccion'];

        return new self($id, $nombre_apellido, $fecha_alta, $activo, $telefono, $direccion);
    }
}
