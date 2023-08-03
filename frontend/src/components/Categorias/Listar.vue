<template>
  <div class="categorias-list">
    <h1 class="list-title">CATEGORIAS</h1>
    <!-- Botón para crear un nuevo categoria -->
    <button @click="redireccionarACrearCategoria" class="btn-crear">Crear Categoria</button>
    <table class="categorias-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Descripcion</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="categoria in categorias" :key="categoria">
          <td>{{ categoria.id }}</td>
          <td>{{ categoria.descripcion }}</td>
          <td>
            <div class="button-group">
              <button @click="RedicAactualizarCategoria(categoria.id)" class="btn-button">Actualizar</button>

              <!-- Botón para abrir el diálogo modal -->
              <button @click="mostrarDialogoBorrado(categoria.id)" class="btn-button">Borrar</button>

              <!-- Diálogo modal -->
              <div v-if="mostrarModal" class="modal-overlay">
                <div class="modal-content">
                  <h5>Confirmar Borrado</h5>
                  <p>¿Estás seguro de borrar esta categoria?</p>
                  <div class="modal-buttons">
                    <button @click="cerrarDialogo">Cancelar</button>
                    <button @click="borrarCategoria(categoria.id)">Borrar</button>
                  </div>
                </div>
              </div>
            </div>
            <button @click="redicAbrirCategoria(categoria.id)" class="btn-button">Abrir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Mostrar el formulario de actualización solo si categoriaIdSeleccionado tiene un valor -->
    <Actualizar v-if="categoriaIdSeleccionado" :categoriaId="categoriaIdSeleccionado" />
  </div>
</template>

<script lang="ts">
import Boton from "../Boton.vue";
import UpdateCategoria from "./Actualizar.vue";
import axios from "axios";

export default {
  components: {
    UpdateCategoria,
    Boton
  },
  props: {},
  data() {
    return {
      categorias: [],
      categoriaIdSeleccionado: null, // Variable para almacenar el ID del socio a editar
      mostrarModal: false
    };
  },

  created() {
    this.listarCategoriaes();
  },

  methods: {
    redireccionarACrearCategoria() {
      this.$router.push({ name: "CrearCategoria" }); // Redireccionar al componente Crear
    },

    RedicAactualizarCategoria(categoriaIdSeleccionado: string) {
      this.$router.push({
        name: "UpdateCategoria",
        params: { id: categoriaIdSeleccionado }
      }); // Redireccionar al componente Actualizar
    },

    async listarCategoriaes() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/categorias");
        this.categorias = res.data; // Asignar los datos de los socios a la variable socios
      } catch (error) {
        console.error(error);
      }
    },

    borrarCategoria(categoriaIdSeleccionado: string) {
      const url = "http://192.168.20.10/apiv1/categorias/:id";
      try {
        const res = axios.delete(url.replace(":id", categoriaIdSeleccionado));
        this.categorias = this.categorias.filter(
          categoria => categoria.id !== categoriaIdSeleccionado
        );
        this.mostrarModal = false;
      } catch (error) {
        console.error(error);
      }
    },

    mostrarDialogoBorrado(categoria) {
      this.categoria = categoria;
      this.mostrarModal = true;
    },
    cerrarDialogo() {
      this.mostrarModal = false;
    },

    redicAbrirCategoria(categoriaIdSeleccionado: string) {
      this.$router.push({
        name: "AbrirCategoria",
        params: { id: categoriaIdSeleccionado }
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
.categorias-list {
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

.categorias-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.categorias-table th,
.categorias-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.categorias-table th {
  font-weight: bold;
}

.categorias-table tbody tr:hover {
  background-color: #f0f0f0;
}

.categorias-table button {
  margin-right: 5px;
  background-color: #65c7ca;
  color: #ffffff;
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.categorias-table button:hover {
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
