<template>
  <div class="autores-list">
    <h1 class="list-title">AUTORES</h1>
    <!-- Botón para crear un nuevo autor -->
    <button @click="redireccionarACrearAutor" class="btn-crear">Crear Autor</button>
    <table class="autores-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="autor in autores" :key="autor">
          <td>{{ autor.id }}</td>
          <td>{{ autor.nombre_apellido }}</td>
          <td>
            <div class="button-group">
              <button @click="RedicAactualizarAutor(autor.id)" class="btn-button">Actualizar</button>

              <!-- Botón para abrir el diálogo modal -->
              <button @click="mostrarDialogoBorrado(autor.id)" class="btn-button">Borrar</button>

              <!-- Diálogo modal -->
              <div v-if="mostrarModal" class="modal-overlay">
                <div class="modal-content">
                  <h5>Confirmar Borrado</h5>
                  <p>¿Estás seguro de borrar este autor?</p>
                  <div class="modal-buttons">
                    <button @click="cerrarDialogo">Cancelar</button>
                    <button @click="borrarAutor(autor.id)">Borrar</button>
                  </div>
                </div>
              </div>
            </div>
            <button @click="redicAbrirAutor(autor.id)" class="btn-button">Abrir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Mostrar el formulario de actualización solo si autorIdSeleccionado tiene un valor -->
    <Actualizar v-if="autorIdSeleccionado" :autorId="autorIdSeleccionado" />
  </div>
</template>

<script lang="ts">
import Boton from "../Boton.vue";
import UpdateAutor from "./Actualizar.vue";
import axios from "axios";

export default {
  components: {
    UpdateAutor,
    Boton
  },
  props: {},
  data() {
    return {
      autores: [],
      autorIdSeleccionado: null, // Variable para almacenar el ID del socio a editar
      mostrarModal: false
    };
  },

  created() {
    this.listarAutores();
  },

  methods: {
    redireccionarACrearAutor() {
      this.$router.push({ name: "CrearAutor" }); // Redireccionar al componente Crear
    },

    RedicAactualizarAutor(autorIdSeleccionado: string) {
      this.$router.push({
        name: "UpdateAutor",
        params: { id: autorIdSeleccionado }
      }); // Redireccionar al componente Actualizar
    },

    async listarAutores() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/autores");
        this.autores = res.data; // Asignar los datos de los socios a la variable socios
      } catch (error) {
        console.error(error);
      }
    },

    borrarAutor(autorIdSeleccionado: string) {
      const url = "http://192.168.20.10/apiv1/autores/:id";
      try {
        const res = axios.delete(url.replace(":id", autorIdSeleccionado));
        this.autores = this.autores.filter(
          autor => autor.id !== autorIdSeleccionado
        );
        this.mostrarModal = false;
      } catch (error) {
        console.error(error);
      }
    },

    mostrarDialogoBorrado(autor) {
      this.autor = autor;
      this.mostrarModal = true;
    },
    cerrarDialogo() {
      this.mostrarModal = false;
    },

    redicAbrirAutor(autorIdSeleccionado: string) {
      this.$router.push({
        name: "AbrirAutor",
        params: { id: autorIdSeleccionado }
      }); // Redireccionar al componente Abrir
    }
  }
};
</script>

<style>
/* Estilos para el botón de "Crear" */
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

.button-group {
  display: flex;
}

.btn-crear:hover {
  background-color: #4aa9ac;
}

/* Estilos para la lista*/
.autores-list {
  max-width: 800px;
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

.autores-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.autores-table th,
.autores-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.autores-table th {
  font-weight: bold;
}

.autores-table tbody tr:hover {
  background-color: #f0f0f0;
}

.autores-table button {
  margin-right: 5px;
  background-color: #65c7ca;
  color: #ffffff;
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.autores-table button:hover {
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
