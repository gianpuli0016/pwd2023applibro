<template>
  <div class="editoriales-list">
    <h1 class="list-title">EDITORIALES</h1>
    <!-- Botón para crear un nuevo editorial -->
    <button @click="redireccionarACrearEditorial" class="btn-crear">Crear Editorial</button>
    <table class="editoriales-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="editorial in editoriales" :key="editorial">
          <td>{{ editorial.id }}</td>
          <td>{{ editorial.nombre }}</td>
          <td>
            <div class="button-group">
              <button @click="RedicAactualizarEditorial(editorial.id)" class="btn-button">Actualizar</button>

              <!-- Botón para abrir el diálogo modal -->
              <button @click="mostrarDialogoBorrado(editorial.id)" class="btn-button">Borrar</button>

              <!-- Diálogo modal -->
              <div v-if="mostrarModal" class="modal-overlay">
                <div class="modal-content">
                  <h5>Confirmar Borrado</h5>
                  <p>¿Estás seguro de borrar este editorial?</p>
                  <div class="modal-buttons">
                    <button @click="cerrarDialogo">Cancelar</button>
                    <button @click="borrarEditorial(editorial.id)">Borrar</button>
                  </div>
                </div>
              </div>
            </div>
            <button @click="redicAbrirEditorial(editorial.id)" class="btn-button">Abrir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Mostrar el formulario de actualización solo si editorialIdSeleccionado tiene un valor -->
    <Actualizar v-if="editorialIdSeleccionado" :editorialId="editorialIdSeleccionado" />
  </div>
</template>

<script lang="ts">
import Boton from "../Boton.vue";
import UpdateEditorial from "./Actualizar.vue";
import axios from "axios";

export default {
  components: {
    UpdateEditorial,
    Boton
  },
  props: {},
  data() {
    return {
      editoriales: [],
      editorialIdSeleccionado: null, // Variable para almacenar el ID del socio a editar
      mostrarModal: false
    };
  },

  created() {
    this.listarEditoriales();
  },

  methods: {
    redireccionarACrearEditorial() {
      this.$router.push({ name: "CrearEditorial" }); // Redireccionar al componente Crear
    },

    RedicAactualizarEditorial(editorialIdSeleccionado: string) {
      this.$router.push({
        name: "UpdateEditorial",
        params: { id: editorialIdSeleccionado }
      }); // Redireccionar al componente Actualizar
    },

    async listarEditoriales() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/editoriales");
        this.editoriales = res.data; // Asignar los datos de los socios a la variable socios
      } catch (error) {
        console.error(error);
      }
    },

    borrarEditorial(editorialIdSeleccionado: string) {
      const url = "http://192.168.20.10/apiv1/editoriales/:id";
      try {
        const res = axios.delete(url.replace(":id", editorialIdSeleccionado));
        this.editoriales = this.editoriales.filter(
          editorial => editorial.id !== editorialIdSeleccionado
        );
        this.mostrarModal = false;
      } catch (error) {
        console.error(error);
      }
    },

    mostrarDialogoBorrado(editorial) {
      this.editorial = editorial;
      this.mostrarModal = true;
    },
    cerrarDialogo() {
      this.mostrarModal = false;
    },

    redicAbrirEditorial(editorialIdSeleccionado: string) {
      this.$router.push({
        name: "AbrirEditorial",
        params: { id: editorialIdSeleccionado }
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
.editoriales-list {
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

.editoriales-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.editoriales-table th,
.editoriales-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.editoriales-table th {
  font-weight: bold;
}

.editoriales-table tbody tr:hover {
  background-color: #f0f0f0;
}

.editoriales-table button {
  margin-right: 5px;
  background-color: #65c7ca;
  color: #ffffff;
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.editoriales-table button:hover {
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
