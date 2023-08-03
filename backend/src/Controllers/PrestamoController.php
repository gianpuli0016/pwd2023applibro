<?php

namespace Raiz\Controllers;

use DateTime;
use Raiz\Bd\LibroDAO;
use Raiz\Bd\PrestamoDAO;
use Raiz\Models\Prestamo;
use Raiz\Bd\SocioDAO;




class PrestamoController implements InterfaceController
{

    public static function listar(): array
    {
        $prestamos = [];
        $listadoPrestamos = PrestamoDAO::listar();

        foreach ($listadoPrestamos as $prestamo) {

            $prestamos[] = $prestamo->serializar();
        }

        return $prestamos;
    }

    public static function encontrarUno(string $id): ?array
    {
        $prestamo = PrestamoDAO::encontrarUno($id);
        if ($prestamo === null) {
            return $prestamo;
        } else {
            return $prestamo->serializar();
        }
    }

    public static function calcularDiasRetraso(string $id): int
    {
        $diasRetraso = PrestamoDAO::calcularDiasRetraso($id);

        if ($diasRetraso !== null) {
            return $diasRetraso;
        }

        return null;
    }

    public static function verificarLibroDevuelvo(string $id): int
    {
        $libroDevuelto = PrestamoDAO::verificarLibroDevuelvo($id);

        if ($libroDevuelto !== null) {
            return $libroDevuelto;
        }

        return null;
    }



    public static function crear(array $parametros): array
    {
        $parametros['socio'] = SocioDAO::encontrarUno($parametros['id_socio']);
        $parametros['libro'] = LibroDAO::encontrarUno($parametros['id_libro']);

        $prestamo = new Prestamo(
            id: null,
            libro: $parametros["libro"],
            socio: $parametros['socio'],
            fecha_desde: new DateTime($parametros["fecha_desde"]),
            fecha_hasta: new DateTime($parametros["fecha_hasta"])
        );

        return $prestamo->serializar();
    }

    public static function actualizar(array $parametros): array
    {
        $prestamo = prestamo::deserializar($parametros);
        PrestamoDAO::actualizar($prestamo);
        return $prestamo->serializar();
    }

    public static function borrar(string $id): void
    {
        PrestamoDAO::borrar($id);
    }
}
