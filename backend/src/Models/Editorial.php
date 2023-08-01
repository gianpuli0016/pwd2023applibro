<?php

declare(strict_types=1);

namespace Raiz\Models;

use Raiz\Models\ModelBase;

class Editorial extends ModelBase
{
    private string $nombre;

    function __construct(
        int $id,
        string $nombre
    ) {
        parent::__construct($id);
        $this->nombre = $nombre;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre($nuevo_nombre): void
    {
        $this->nombre = $nuevo_nombre;
    }

    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->nombre,
        ];
    }

    public static function deserializar(array $datos): self
    {
        $id = $datos['id'];
        $nombre = $datos['nombre'];

        return new self($id, $nombre);
    }
}
