import { createRouter, createWebHistory } from "vue-router";
import Home from '../components/Home.vue';

import ListarSocios from '../components/Socios/Listar.vue';
import CreateSocio from '../components/Socios/Crear.vue';
import UpdateSocio from '../components/Socios/Actualizar.vue';
import AbrirSocio from '../components/Socios/Abrir.vue';

import ListarAutores from '../components/Autores/Listar.vue';
import UpdateAutor from '../components/Autores/Actualizar.vue';
import CreateAutor from '../components/Autores/Crear.vue';
import AbrirAutor from '../components/Autores/Abrir.vue';

import ListarLibros from '../components/Libros/Listar.vue';
import CreateLibro from '../components/Libros/Crear.vue';

import ListarCategorias from '../components/Categorias/Listar.vue';
import UpdateCategoria from '../components/Categorias/Actualizar.vue';
import CreateCategoria from '../components/Categorias/Crear.vue';
import AbrirCategoria from '../components/Categorias/Abrir.vue';

import ListarGeneros from '../components/Generos/Listar.vue';
import UpdateGenero from '../components/Generos/Actualizar.vue';
import CreateGenero from '../components/Generos/Crear.vue';
import AbrirGenero from '../components/Generos/Abrir.vue';

import ListarEditoriales from '../components/Editoriales/Listar.vue';
import UpdateEditorial from '../components/Editoriales/Actualizar.vue';
import CreateEditorial from '../components/Editoriales/Crear.vue';
import AbrirEditorial from '../components/Editoriales/Abrir.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/socios',
            name: 'Socios',
            component: ListarSocios
        }
        ,
        {
            path: '/crearSocio',
            name: 'CrearSocio',
            component: CreateSocio
        }
        ,
        {
            path: '/updateSocio/:id',
            name: 'UpdateSocio',
            component: UpdateSocio
        }
        ,
        {
            path: '/abrirSocio/:id',
            name: 'AbrirSocio',
            component: AbrirSocio
        },
        {
            path: '/autores',
            name: 'Autores',
            component: ListarAutores
        },
        {
            path: '/updateAutor/:id',
            name: 'UpdateAutor',
            component: UpdateAutor
        }
        ,
        {
            path: '/crearAutor',
            name: 'CrearAutor',
            component: CreateAutor
        }
        ,
        {
            path: '/abrirAutor/:id',
            name: 'AbrirAutor',
            component: AbrirAutor
        },
        {
            path: '/libros',
            name: 'Libros',
            component: ListarLibros
        }
        ,
        {
            path: '/crearLibro',
            name: 'CrearLibro',
            component: CreateLibro
        },
        {
            path: '/categorias',
            name: 'Categorias',
            component: ListarCategorias
        },
        {
            path: '/updateCategoria/:id',
            name: 'UpdateCategoria',
            component: UpdateCategoria
        }
        ,
        {
            path: '/crearCategoria',
            name: 'CrearCategoria',
            component: CreateCategoria
        }
        ,
        {
            path: '/abrirCategoria/:id',
            name: 'AbrirCategoria',
            component: AbrirCategoria
        },
        {
            path: '/generos',
            name: 'Generos',
            component: ListarGeneros
        },
        {
            path: '/updateGenero/:id',
            name: 'UpdateGenero',
            component: UpdateGenero
        }
        ,
        {
            path: '/crearGenero',
            name: 'CrearGenero',
            component: CreateGenero
        }
        ,
        {
            path: '/abrirGenero/:id',
            name: 'AbrirGenero',
            component: AbrirGenero
        },
        {
            path: '/editoriales',
            name: 'Editoriales',
            component: ListarEditoriales
        },
        {
            path: '/updateEditorial/:id',
            name: 'UpdateEditorial',
            component: UpdateEditorial
        }
        ,
        {
            path: '/crearEditorial',
            name: 'CrearEditorial',
            component: CreateEditorial
        }
        ,
        {
            path: '/abrirEditorial/:id',
            name: 'AbrirEditorial',
            component: AbrirEditorial
        }
    ]
})

export default router;