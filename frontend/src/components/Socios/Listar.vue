<template>
  <div class="socios-list">
    <h1 class="list-title">SOCIOS</h1>
    <!-- Botón para crear un nuevo socio -->
    <button @click="redireccionarACrearSocio" class="btn-crear">Crear Socio</button>
    <table class="socios-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Fecha Alta</th>
          <th>Dirección</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="socio in socios" :key="socio">
          <td>{{ socio.id }}</td>
          <td>{{ socio.nombre_apellido }}</td>
          <td>{{ socio.fecha_alta }}</td>
          <td>{{ socio.direccion }}</td>
          <td>{{ socio.telefono }}</td>
          <td>
            <div class="button-group">
              <button @click="RedicAactualizarSocio(socio.id)" class="btn-button">Actualizar</button>
              <div>
                <!-- Botón para abrir el diálogo modal -->
                <button @click="mostrarDialogoBorrado(socio.id)" class="btn-button">Borrar</button>

                <!-- Diálogo modal -->
                <div v-if="mostrarModal" class="modal-overlay">
                  <div class="modal-content">
                    <h5>Confirmar Borrado</h5>
                    <p>¿Estás seguro de borrar este socio?</p>
                    <div class="modal-buttons">
                      <button @click="cerrarDialogo">Cancelar</button>
                      <button @click="borrarSocio(socio.id)">Borrar</button>
                    </div>
                  </div>
                </div>
              </div>
              <button @click="redicAbrirSocio(socio.id)" class="btn-button">Abrir</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Mostrar el formulario de actualización solo si socioIdSeleccionado tiene un valor -->
    <Actualizar v-if="socioIdSeleccionado" :socioId="socioIdSeleccionado" />
  </div>
</template>

<script lang="ts">
import Boton from "../Boton.vue";
import UpdateSocio from "./Actualizar.vue";
import axios from "axios";

export default {
  components: {
    UpdateSocio,
    Boton
  },
  props: {},
  data() {
    return {
      socios: [],
      socioIdSeleccionado: null, // Variable para almacenar el ID del socio a editar
      mostrarModal: false
    };
  },

  created() {
    this.listarSocios();
  },

  methods: {
    redireccionarACrearSocio() {
      this.$router.push({ name: "CrearSocio" }); // Redireccionar al componente Crear
    },

    RedicAactualizarSocio(socioIdSeleccionado: string) {
      this.$router.push({
        name: "UpdateSocio",
        params: { id: socioIdSeleccionado }
      }); // Redireccionar al componente Actualizar
    },

    async listarSocios() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/socios");
        this.socios = res.data; // Asignar los datos de los socios a la variable socios
      } catch (error) {
        console.error(error);
      }
    },

    borrarSocio(socioIdSeleccionado: string) {
      const url = "http://192.168.20.10/apiv1/socios/:id";
      try {
        const res = axios.delete(url.replace(":id", socioIdSeleccionado));
        this.socios = this.socios.filter(
          socio => socio.id !== socioIdSeleccionado
        );
        this.mostrarModal = false;
      } catch (error) {
        console.error(error);
      }
    },

    mostrarDialogoBorrado(socio) {
      this.socio = socio;
      this.mostrarModal = true;
    },
    cerrarDialogo() {
      this.mostrarModal = false;
    },

    redicAbrirSocio(socioIdSeleccionado: string) {
      this.$router.push({
        name: "AbrirSocio",
        params: { id: socioIdSeleccionado }
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

/* Estilos para la lista de socios */
.socios-list {
  display: inline-block;
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

.socios-table {
  width: 100%;
  border-collapse: collapse;
}

.socios-table th,
.socios-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.socios-table th {
  font-weight: bold;
}

.socios-table tbody tr:hover {
  background-color: #f0f0f0;
}

.socios-table button {
  margin-right: 5px;
  background-color: #65c7ca;
  color: #ffffff;
  padding: 8px 12px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
}

.socios-table button:hover {
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
