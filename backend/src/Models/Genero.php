<?php

declare(strict_types=1);

namespace Raiz\Models;

use Raiz\Models\ModelBase;

class Genero extends ModelBase
{
    private string $descripcion;

    function __construct(
        int $id,
        string $descripcion
    ) {
        parent::__construct($id);
        $this->descripcion = $descripcion;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion($nueva_descripcion): void
    {
        $this->descripcion = $nueva_descripcion;
    }

    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'descripcion' => $this->descripcion,
        ];
    }

    public static function deserializar(array $datos): self
    {
        $id = $datos['id'];
        $descripcion = $datos['descripcion'];

        return new self($id, $descripcion);
    }
}
