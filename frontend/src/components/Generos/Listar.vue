<template>
  <div class="generos-list">
    <h1 class="list-title">GENEROS</h1>
    <!-- Botón para crear un nuevo genero -->
    <button @click="redireccionarACrearGenero" class="btn-crear">Crear Genero</button>
    <table class="generos-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Descripcion</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="genero in generos" :key="genero">
          <td>{{ genero.id }}</td>
          <td>{{ genero.descripcion }}</td>
          <td>
            <div class="button-group">
              <button @click="RedicAactualizarGenero(genero.id)" class="btn-button">Actualizar</button>

              <!-- Botón para abrir el diálogo modal -->
              <button @click="mostrarDialogoBorrado(genero.id)" class="btn-button">Borrar</button>

              <!-- Diálogo modal -->
              <div v-if="mostrarModal" class="modal-overlay">
                <div class="modal-content">
                  <h5>Confirmar Borrado</h5>
                  <p>¿Estás seguro de borrar este genero?</p>
                  <div class="modal-buttons">
                    <button @click="cerrarDialogo">Cancelar</button>
                    <button @click="borrarGenero(genero.id)">Borrar</button>
                  </div>
                </div>
              </div>
            </div>
            <button @click="redicAbrirGenero(genero.id)" class="btn-button">Abrir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Mostrar el formulario de actualización solo si generoIdSeleccionado tiene un valor -->
    <Actualizar v-if="generoIdSeleccionado" :generoId="generoIdSeleccionado" />
  </div>
</template>

<script lang="ts">
import Boton from "../Boton.vue";
import UpdateGenero from "./Actualizar.vue";
import axios from "axios";

export default {
  components: {
    UpdateGenero,
    Boton
  },
  props: {},
  data() {
    return {
      generos: [],
      generoIdSeleccionado: null, // Variable para almacenar el ID del socio a editar
      mostrarModal: false
    };
  },

  created() {
    this.listarGeneroes();
  },

  methods: {
    redireccionarACrearGenero() {
      this.$router.push({ name: "CrearGenero" }); // Redireccionar al componente Crear
    },

    RedicAactualizarGenero(generoIdSeleccionado: string) {
      this.$router.push({
        name: "UpdateGenero",
        params: { id: generoIdSeleccionado }
      }); // Redireccionar al componente Actualizar
    },

    async listarGeneroes() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/generos");
        this.generos = res.data; // Asignar los datos de los socios a la variable socios
      } catch (error) {
        console.error(error);
      }
    },

    borrarGenero(generoIdSeleccionado: string) {
      const url = "http://192.168.20.10/apiv1/generos/:id";
      try {
        const res = axios.delete(url.replace(":id", generoIdSeleccionado));
        this.generos = this.generos.filter(
          genero => genero.id !== generoIdSeleccionado
        );
        this.mostrarModal = false;
      } catch (error) {
        console.error(error);
      }
    },

    mostrarDialogoBorrado(genero) {
      this.genero = genero;
      this.mostrarModal = true;
    },
    cerrarDialogo() {
      this.mostrarModal = false;
    },

    redicAbrirGenero(generoIdSeleccionado: string) {
      this.$router.push({
        name: "AbrirGenero",
        params: { id: generoIdSeleccionado }
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
.generos-list {
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

.generos-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.generos-table th,
.generos-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.generos-table th {
  font-weight: bold;
}

.generos-table tbody tr:hover {
  background-color: #f0f0f0;
}

.generos-table button {
  margin-right: 5px;
  background-color: #65c7ca;
  color: #ffffff;
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.generos-table button:hover {
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
