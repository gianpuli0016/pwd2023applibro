<?php

namespace Raiz\Controllers;

use Raiz\Bd\CategoriaDAO;
use Raiz\Models\Categoria;

class CategoriaController implements InterfaceController
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
        $categorias = [];
        $listadoCategorias = CategoriaDAO::listar();
        foreach ($listadoCategorias as $Categoria) {
            $categorias[] = $Categoria->serializar();
        }
        return $categorias;
    }

    public static function encontrarUno(string $id): ?array
    {
        $categoria = CategoriaDAO::encontrarUno($id);
        if ($categoria === null) {
            return $categoria;
        } else {
            return $categoria->serializar();
        }
    }

    public static function crear(array $parametros): array
    {
        $categoria = Categoria::deserializar($parametros);
        CategoriaDAO::crear($categoria);
        return $categoria->serializar();
    }

    public static function actualizar(array $parametros): array
    {
        $categoria = Categoria::deserializar($parametros);
        CategoriaDAO::actualizar($categoria);
        return $categoria->serializar();
    }

    public static function borrar(string $id): void
    {
        CategoriaDAO::borrar($id);
    }
}
