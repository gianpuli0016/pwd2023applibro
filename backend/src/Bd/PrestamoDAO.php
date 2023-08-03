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
        $cnx = ConectarBD::conectar();
        $consulta = $cnx->prepare($sql);
        $consulta->execute();
        $listaPrestamos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $prestamos = [];
        foreach ($listaPrestamos as $prestamo) {
            $prestamo['socio'] = SocioDAO::encontrarUno($prestamo['id_socio']);
            $prestamo['libro'] = LibroDAO::encontrarUno($prestamo['id_libro']);

            $prestamos[] = Prestamo::deserializar($prestamo);
        }

        return $prestamos;
    }

    public static function crear(Serializador $instancia): void
    {
        $params = $instancia->serializar();
        $sql = 'INSERT INTO prestamos (id_libro, id_socio, fecha_desde, fecha_hasta) 
        VALUES (:id_libro, :id_socio, :fecha_desde, :fecha_hasta);';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id_libro' => $params['libro']['id'],
                ':id_socio' => $params['socio']['id'],
                ':fecha_desde' => $params['fecha_desde'],
                ':fecha_hasta' => $params['fecha_hasta']
            ]
        );
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
            $id_libro = $libro[0]->getId();
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
