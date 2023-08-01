<?php

declare(strict_types=1);

namespace Raiz\Models;

use Raiz\Models\ModelBase;

class Autor extends ModelBase
{

    private string $nombre_apellido;

    function __construct(
        int $id,
        string $nombre_apellido
    ) {
        parent::__construct($id);
        $this->nombre_apellido = $nombre_apellido;
    }

    public function getNombre_apellido(): string
    {
        return $this->nombre_apellido;
    }

    public function setNombreApellido($nuevo_nombre_apellido): void
    {
        $this->nombre_apellido = $nuevo_nombre_apellido;
    }

    public function serializar(): array
    {
        return [
            'id' => $this->getId(),
            'nombre_apellido' => $this->nombre_apellido,
        ];
    }

    public static function deserializar(array $datos): ModelBase
    {
        $id = $datos['id'] === null ? 0 : $datos['id'];
        $nombre_apellido = $datos['nombre_apellido'];

        return new self($id, $nombre_apellido);
    }
}
