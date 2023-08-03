<template>
  <div class="libros-list">
    <h1 class="list-title">LIBROS</h1>
    <!-- Botón para crear un nuevo libro -->
    <button @click="redireccionarACrearLibro" class="btn-crear">Crear Libro</button>
    <table class="libros-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Titulo</th>
          <th>Autor</th>
          <th>Genero</th>
          <th>Categoria</th>
          <th>Paginas</th>
          <th>Años</th>
          <th>Estado</th>
          <th>Editorial</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="libro in libros" :key="libro">
          <td>{{ libro.id }}</td>
          <td>{{ libro.titulo }}</td>
          <td>
            <span v-for="(autor, index) in libro.autor" :key="index">
              <div>{{ autor['nombre_apellido'] }}</div>
            </span>
          </td>
          <td>{{ libro.genero['descripcion'] }}</td>
          <td>{{ libro.categoria['descripcion'] }}</td>
          <td>{{ libro.cant_paginas }}</td>
          <td>{{ libro.anio }}</td>
          <td>{{ libro.estado }}</td>
          <td>{{ libro.editorial['nombre'] }}</td>
          <td>
            <div class="button-group">
              <button @click="RedicActualizarLibro(libro.id)" class="btn-button">Actualizar</button>
              <div>
                <!-- Botón para abrir el diálogo modal -->
                <button @click="mostrarDialogoBorrado(libro.id)" class="btn-button">Borrar</button>

                <!-- Diálogo modal -->
                <div v-if="mostrarModal" class="modal-overlay">
                  <div class="modal-content">
                    <h5>Confirmar Borrado</h5>
                    <p>¿Estás seguro de borrar este libro?</p>
                    <div class="modal-buttons">
                      <button @click="cerrarDialogo">Cancelar</button>
                      <button @click="borrarLibro(libro.id)">Borrar</button>
                    </div>
                  </div>
                </div>
              </div>
              <button @click="redicAbrirLibro(libro.id)" class="btn-button">Abrir</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Mostrar el formulario de actualización solo si libroIdSeleccionado tiene un valor -->
    <Actualizar v-if="libroIdSeleccionado" :libroId="libroIdSeleccionado" />
  </div>
</template>

<script lang="ts">
import Boton from "../Boton.vue";
//import UpdateLibro from "./Actualizar.vue";
import axios from "axios";
import UpdateLibro from "./Actualizar.vue";

export default {
  components: {
    Boton,
    UpdateLibro
  },
  props: {},
  data() {
    return {
      libros: [],
      libroIdSeleccionado: null, // Variable para almacenar el ID del libro a editar
      mostrarModal: false
    };
  },

  created() {
    this.listarLibros();
  },

  methods: {
    redireccionarACrearLibro() {
      this.$router.push({ name: "CrearLibro" }); // Redireccionar al componente Crear
    },

    RedicActualizarLibro(libroIdSeleccionado: string) {
      this.$router.push({
        name: "UpdateLibro",
        params: { id: libroIdSeleccionado }
      }); // Redireccionar al componente Actualizar
    },

    async listarLibros() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/libros");

        console.log(res);
        this.libros = res.data; // Asignar los datos de los libros a la variable libros
      } catch (error) {
        console.error(error);
      }
    },

    borrarLibro(libroIdSeleccionado: string) {
      const url = "http://192.168.20.10/apiv1/libros/:id";
      try {
        const res = axios.delete(url.replace(":id", libroIdSeleccionado));
        this.libros = this.libros.filter(
          libro => libro.id !== libroIdSeleccionado
        );
        this.mostrarModal = false;
      } catch (error) {
        console.error(error);
      }
    },

    mostrarDialogoBorrado(libro) {
      this.libro = libro;
      this.mostrarModal = true;
    },
    cerrarDialogo() {
      this.mostrarModal = false;
    },

    redicAbrirLibro(libroIdSeleccionado: string) {
      this.$router.push({
        name: "AbrirLibro",
        params: { id: libroIdSeleccionado }
      }); // Redireccionar al componente Abrir
    }
  }
};
</script>

<style>
/* Estilos para el botón de "Crear Socio" */
.btn-crear {
  background-color: #65c7ca;
  color: #ffffff;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 20px;
  transition: background-color 0.3s ease-in-out;
}

.button-group {
  display: flex;
}

.btn-button {
  background-color: #65c7ca;
  color: #ffffff;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 5px;
  transition: background-color 0.3s ease-in-out;
}

.btn-crear:hover {
  background-color: #4aa9ac;
}

/* Estilos para la lista de libros */
.libros-list {
  display: inline-block;
  max-width: 1200px;
  margin: 0 auto;
  padding: 30px;
  font-family: Arial, sans-serif;
}

.list-title {
  font-size: 40px;
  font-weight: bold;
  margin-bottom: 20px;
  color: #333;
  text-align: center;
}

.libros-table {
  width: 100%;
  border-collapse: collapse;
}

.libros-table th,
.libros-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.libros-table th {
  font-weight: bold;
}

.libros-table tbody tr:hover {
  background-color: #f0f0f0;
}

.libros-table button {
  margin-right: 5px;
  background-color: #65c7ca;
  color: #ffffff;
  padding: 8px 12px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
}

.libros-table button:hover {
  background-color: #4aa9ac;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}

.modal-buttons {
  display: flex;
  justify-content: flex-end;
  margin-top: 10px;
}

.modal-buttons button {
  margin-left: 10px;
}
</style>