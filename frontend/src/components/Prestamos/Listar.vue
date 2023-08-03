<template>
  <div class="prestamos-list">
    <h1 class="list-title">PRESTAMOS</h1>
    <!-- Botón para crear un nuevo Prestamo -->
    <button @click="redireccionarACrearPrestamo" class="btn-crear">Crear Prestamo</button>
    <table class="prestamos-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Socio</th>
          <th>Libro</th>
          <th>Fecha desde</th>
          <th>Fecha hasta</th>
          <th>Fecha devolucion</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="prestamo in prestamos" :key="prestamo">
          <td>{{ prestamo.id }}</td>
          <td>{{ prestamo.socio['nombre_apellido'] }}</td>
          <td>{{ prestamo.libro['titulo'] }}</td>
          <td>{{ prestamo.fecha_desde }}</td>
          <td>{{ prestamo.fecha_hasta }}</td>
          <td>{{ prestamo.fecha_dev }}</td>
          <td>
            <div class="button-group">
              <button @click="RedicAactualizarPrestamo(Prestamo.id)" class="btn-button">Actualizar</button>

              <!-- Botón para abrir el diálogo modal -->
              <button @click="mostrarDialogoBorrado(Prestamo.id)" class="btn-button">Borrar</button>

              <!-- Diálogo modal -->
              <div v-if="mostrarModal" class="modal-overlay">
                <div class="modal-content">
                  <h5>Confirmar Borrado</h5>
                  <p>¿Estás seguro de borrar este Prestamo?</p>
                  <div class="modal-buttons">
                    <button @click="cerrarDialogo">Cancelar</button>
                    <button @click="borrarPrestamo(Prestamo.id)">Borrar</button>
                  </div>
                </div>
              </div>
            </div>
            <button @click="redicAbrirPrestamo(Prestamo.id)" class="btn-button">Abrir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Mostrar el formulario de actualización solo si PrestamoIdSeleccionado tiene un valor -->
    <Actualizar v-if="prestamoIdSeleccionado" :prestamoId="prestamoIdSeleccionado" />
  </div>
</template>

<script lang="ts">
import Boton from "../Boton.vue";
import UpdatePrestamo from "./Actualizar.vue";
import axios from "axios";

export default {
  components: {
    UpdatePrestamo,
    Boton
  },
  props: {},
  data() {
    return {
      prestamos: [],
      prestamoIdSeleccionado: null, // Variable para almacenar el ID del socio a editar
      mostrarModal: false
    };
  },

  created() {
    this.listarPrestamoes();
  },

  methods: {
    redireccionarACrearPrestamo() {
      this.$router.push({ name: "CrearPrestamo" }); // Redireccionar al componente Crear
    },

    RedicAactualizarPrestamo(prestamoIdSeleccionado: string) {
      this.$router.push({
        name: "UpdatePrestamo",
        params: { id: prestamoIdSeleccionado }
      }); // Redireccionar al componente Actualizar
    },

    async listarPrestamoes() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/prestamos");
        console.log(res.data);
        this.prestamos = res.data; // Asignar los datos de los socios a la variable socios
      } catch (error) {
        console.error(error);
      }
    },

    borrarPrestamo(prestamoIdSeleccionado: string) {
      const url = "http://192.168.20.10/apiv1/prestamos/:id";
      try {
        const res = axios.delete(url.replace(":id", prestamoIdSeleccionado));
        this.prestamos = this.prestamos.filter(
          prestamo => prestamo.id !== prestamoIdSeleccionado
        );
        this.mostrarModal = false;
      } catch (error) {
        console.error(error);
      }
    },

    mostrarDialogoBorrado(prestamo) {
      this.prestamo = prestamo;
      this.mostrarModal = true;
    },
    cerrarDialogo() {
      this.mostrarModal = false;
    },

    redicAbrirPrestamo(prestamoIdSeleccionado: string) {
      this.$router.push({
        name: "AbrirPrestamo",
        params: { id: prestamoIdSeleccionado }
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
.prestamos-list {
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

.prestamos-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.prestamos-table th,
.prestamos-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.prestamos-table th {
  font-weight: bold;
}

.prestamos-table tbody tr:hover {
  background-color: #f0f0f0;
}

.prestamos-table button {
  margin-right: 5px;
  background-color: #65c7ca;
  color: #ffffff;
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.prestamos-table button:hover {
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
