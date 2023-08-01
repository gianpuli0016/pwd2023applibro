<?php

namespace Raiz\Controllers;

use Raiz\Bd\LibroDAO;
use Raiz\Bd\PrestamoDAO;
use Raiz\Models\prestamo;
use Raiz\Models\Socio;
use Raiz\Bd\SocioDAO;




class PrestamoController implements InterfaceController
{

    //Clase que controla de acuerdo a lo que pida la vista: 
    // --- CRUD --- 
    //  Listar 
    //  encontrar uno
    //  crear
    //  actualizar
    //  borrar  

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
            socio: $parametros['socio'],
            libro: $parametros["libro"],
            fecha_desde: $parametros["fecha_desde"],
            fecha_hasta: $parametros["fecha_hasta"]
        );
        PrestamoDAO::crear($prestamo);
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
