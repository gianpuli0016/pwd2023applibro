<template>
  <div class="prestamo-form">
    <h2>Crear nuevo prestamo</h2>

    <form @submit.prevent="createPrestamo" style="width: 100%;">
      <div>
        <label>Socio</label>
        <select v-model="Prestamo.id_socio" class="select-dropdown">
          <option
            v-for="socio in Socios"
            :key="socio.id"
            :value="socio.id"
          >{{ socio.nombre_apellido }}</option>
        </select>
        <p v-if="errors.socio" class="error">{{ errors.socio }}</p>
      </div>

      <div>
        <label>Libro</label>
        <select v-model="Prestamo.id_libro" class="select-dropdown">
          <option v-for="libro in Libros" :key="libro.id" :value="libro.id">{{ libro.titulo }}</option>
        </select>
        <p v-if="errors.libro" class="error">{{ errors.libro }}</p>
      </div>

      <div>
        <label>Fecha Hasta</label>
        <input v-model="Prestamo.fecha_hasta" type="date" />
        <p v-if="errors.fecha_hasta" class="error">{{ errors.fecha_hasta }}</p>
      </div>

      <button class="btn-guardar" type="submit">Guardar</button>
    </form>
  </div>
</template>

<script lang="ts">
import axios from "axios";

export default {
  data() {
    return {
      Socios: [],
      Libros: [],
      Prestamo: {
        id: "",
        id_libro: "",
        id_socio: "",
        fecha_desde: new Date().toISOString().substring(0, 10),
        fecha_hasta: "",
        fecha_dev: ""
      },
      errors: {}
    };
  },

  mounted() {
    this.listarSocios();
    this.listarLibros();
  },

  methods: {
    async createPrestamo(Prestamo: any) {
      if (this.validateForm()) {
        const data = {
          id: Number(this.Prestamo.id),
          id_libro: this.Prestamo.id_libro,
          id_socio: this.Prestamo.id_socio,
          fecha_desde: new Date().toISOString().substring(0, 10),
          fecha_hasta: this.Prestamo.fecha_hasta
        };
        console.log(data);
        try {
          const response = await axios.post(
            "http://192.168.20.10/apiv1/prestamos/nuevo",
            data
          );
          console.log(response.data);
          // Si la creación es exitosa, redirige a la lista de préstamos
          if (response.status === 200) {
            this.$router.push("/prestamos");
          }
        } catch (error) {
          console.error("Error al crear el préstamo:", error);
        }
      }
    },
    validateForm() {
      this.errors = {};
      let isValid = true;

      if (!this.Prestamo.id_socio) {
        this.errors.id_socio = "Debe seleccionar un socio";
        isValid = false;
      }

      if (!this.Prestamo.id_libro) {
        // Cambiado el if para validar si no hay libro seleccionado
        this.errors.id_libro = "Debe seleccionar un libro.";
        isValid = false;
      }

      if (!this.Prestamo.fecha_hasta) {
        // Cambiado el if para validar si no hay fecha_hasta
        this.errors.fecha_hasta = "Debe ingresar fecha";
        isValid = false;
      }

      return isValid;
    },
    async listarLibros() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/libros");
        this.Libros = res.data;
      } catch (error) {
        console.error(error);
      }
    },
    async listarSocios() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/socios");
        this.Socios = res.data;
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<style>
/* Estilos para el formulario del socio */
.prestamo-form {
  max-width: 400px;
  margin: 0 auto;
  padding: 30px;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  text-align: center; /* Centrar el contenido del formulario */
}

.form-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
  text-align: left; /* Alinear etiquetas a la izquierda */
}

label {
  font-size: 16px;
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
}

input {
  width: 90%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

button.btn-guardar {
  background-color: #65c7ca;
  color: #ffffff;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

button.btn-guardar:hover {
  background-color: #4aa9ac;
}
</style>
