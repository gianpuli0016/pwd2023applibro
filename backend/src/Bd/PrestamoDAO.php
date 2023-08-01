<?php

namespace Raiz\Bd;

use Exception;
use Raiz\Models\Prestamo;
use Raiz\Models\Libro;
use Raiz\Aux\Serializador;
use PDO;
use Raiz\Models\ModelBase;

class PrestamoDAO implements InterfaceDAO
{

    public static function listar(): array
    {
        $sql = 'SELECT * FROM prestamos';
        $listaPrestamos = ConectarBD::leer(sql: $sql);
        $prestamos = [];
        foreach ($listaPrestamos as $prestamo) {
            $prestamos[] = Prestamo::deserializar($prestamo);
        }
        return $prestamos;
    }

    public static function crear(Serializador $instancia): void
    {
        $params = $instancia->serializar();
        $sql = 'INSERT INTO prestamos (socio, libro, fecha_desde, fecha_hasta, fecha_dev) 
        VALUES (:id_socio, :id_libro, :fecha_desde, :fecha_hasta, :fecha_dev);';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id_socio' => $params['socio']->getId(),
                ':id_libro' => $params['libro']->getId(),
                ':fecha_desde' => $params['fecha_desde'],
                ':fecha_hasta' => $params['fecha_hasta'],
                ':fecha_dev' => $params['fecha_dev']
            ]
        );

        // Cambiar el estado del libro a "Prestado"
        $idLibro = $params['libro']->getId();
        LibroDAO::actualizarEstado($idLibro, 'Prestado');
    }

    public static function encontrarUno(string $id): ?Prestamo
    {
        $sql = 'SELECT * FROM prestamos WHERE id =:id;';
        $prestamo = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        if (count($prestamo) === 0) {
            return null;
        } else {
            $prestamo = Prestamo::deserializar($prestamo[0]);
            return $prestamo;
        }
    }

    public static function calcularDiasRetraso(string $id): int
    {
        $prestamo = self::encontrarUno($id);

        if ($prestamo !== null) {
            $libro = $prestamo->getLibro();
            $id_libro = $libro->getId();
            $diasRetraso = $prestamo->diasRetraso($id_libro);
            return $diasRetraso;
        }

        return null;
    }

    public static function verificarLibroDevuelvo(string $id): string
    {
        $prestamo = self::encontrarUno($id);

        if ($prestamo !== null) {
            $fechaDev = $prestamo->getFechaDev();
            if ($fechaDev == null) {
                return null;
            } else {
                return "Libro devuelto el dia: " . $fechaDev;
            };
        }

        return null;
    }

    public static function actualizar(Serializador $instancia)
    {
        $params = $instancia->serializar();
        $sql = 'UPDATE prestamos 
            SET socio = :id_socio, libro = :id_libro, fecha_desde = :fecha_desde, fecha_hasta = :fecha_hasta, fecha_dev = :fecha_dev
            WHERE id = :id;';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':id_socio' => $params['socio']->getId(),
                ':id_libro' => $params['libro']->getId(),
                ':fecha_desde' => $params['fecha_desde'],
                ':fecha_hasta' => $params['fecha_hasta'],
                ':fecha_dev' => $params['fecha_dev'],
            ]
        );

        // Si el préstamo es una devolución, cambia el estado del libro a "Activo"
        if ($params['fecha_dev'] !== null) {
            $idLibro = $params['libro']->getId();
            LibroDAO::actualizarEstado($idLibro, 'Activo');
        }
    }

    public static function borrar(string $id)
    {
        throw new Exception("Metodo no implementado");
    }
}
