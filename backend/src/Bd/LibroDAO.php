<?php

namespace Raiz\Bd;

use Raiz\Models\Autor;
use Raiz\Models\Libro;
use Raiz\Aux\Serializador;
use PDO;

class LibroDAO implements InterfaceDAO
{
    public static function listar(): array
    {

        $sql = 'SELECT *  FROM  libros';
        $cnx = ConectarBD::conectar();
        $consulta = $cnx->prepare($sql);
        $consulta->execute();
        $listaLibros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $libros = [];
        foreach ($listaLibros as $libro) {
            $libro['categoria'] = CategoriaDAO::encontrarUno($libro['id_categoria']);
            $libro['genero'] = GeneroDAO::encontrarUno($libro['id_genero']);
            $libro['editorial'] = EditorialDAO::encontrarUno($libro['id_editorial']);

            $libro['autor'] = static::buscarEscritoresporLibro($libro['id']);

            $libros[] = Libro::deserializar($libro);
        }

        return $libros;
    }
    public static function buscarEscritoresporLibro($id)
    {
        $sql = 'SELECT id_autor FROM autores_libros WHERE id_libro =:id;';
        $autores_ids = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        $autores = [];

        foreach ($autores_ids as $autor_id) {
            $autor = AutorDAO::encontrarUno($autor_id['id_autor']);
            $autores[] = $autor;
        }

        return $autores;
    }

    public static function encontrarUno(string $id): ?libro
    {
        $sql = 'SELECT * FROM libros WHERE id =:id;';
        $libro = ConectarBD::leer(sql: $sql, params: [':id' => $id]);
        if (count($libro) === 0) {
            return null;
        } else {

            $libro[0]['categoria'] = CategoriaDAO::encontrarUno($libro[0]['id_categoria']);
            $libro[0]['genero'] = GeneroDAO::encontrarUno($libro[0]['id_genero']);
            $libro[0]['editorial'] = EditorialDAO::encontrarUno($libro[0]['id_editorial']);
            $libro[0]['autor'] = static::buscarEscritoresporLibro($libro[0]['id']);

            $libro = Libro::deserializar($libro[0]);
            return $libro;
        }
    }

    public static function crear(Serializador $instancia): void
    {
        $params = $instancia->serializar();
        $sql = 'INSERT INTO libros (titulo, id_genero, id_categoria, cant_paginas, anio, estado, id_editorial) 
        VALUES (:titulo, :id_genero, :id_categoria, :cant_paginas, :anio, :estado, :id_editorial);';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':titulo' => $params['titulo'],
                ':id_genero' => $params['genero']['id'],
                ':id_categoria' => $params['categoria']['id'],
                ':cant_paginas' => $params['cant_paginas'],
                ':anio' => $params['anio'],
                ':estado' => $params['estado'],
                ':id_editorial' => $params['editorial']['id'],
            ]
        );

        foreach ($params['autor'] as $autor) {
            $sql = 'INSERT INTO autores_libros (id_autor, id_libro) 
            VALUES ( :id_autor, :id_libro)';
            ConectarBD::escribir(
                sql: $sql,
                params: [
                    ':id_libro' => static::buscarUltimoLibro(),
                    ':id_autor' => $autor['id']
                ]
            );
        }
    }

    public static function actualizar(Serializador $instancia): void
    {
        $params = $instancia->serializar();
        $sql = 'UPDATE libros SET titulo =:titulo WHERE id=:id';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':titulo' => $params['titulo'],
            ]
        );
    }
    public static function buscarUltimoLibro(): int
    {
        $sql = 'SELECT MAX(id) as id FROM libros ';
        $cnx = ConectarBD::conectar();
        $consulta = $cnx->prepare($sql);
        ConectarBD::escribir(
            sql: $sql,
            params: []
        );
        $consulta = $cnx->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC)[0]["id"];
    }
    public static function actualizarEstado(Serializador $instancia): void
    {
        $params = $instancia->serializar();
        $sql = 'UPDATE libros SET estado =:estado WHERE id=:id';
        ConectarBD::escribir(
            sql: $sql,
            params: [
                ':id' => $params['id'],
                ':estado' => $params['estado'],
            ]
        );
    }
    public static function borrar(string $id)
    {
        $sql = 'DELETE FROM libros WHERE id=:id';
        ConectarBD::escribir(sql: $sql, params: [':id' => $id]);
    }
}
