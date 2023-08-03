<template>
  <div class="prestamo-details">
    <h2>Detalles del Prestamo</h2>

    <div class="form-group">
      <label for="socio">Socio:</label>
      <p>{{ Prestamo.socio }}</p>
    </div>
    <div class="form-group">
      <label for="libro">Libro:</label>
      <p>{{ Prestamo.libro }}</p>
    </div>
    <div class="form-group">
      <label for="fecha_desde">Fecha desde:</label>
      <p>{{ Prestamo.fecha_desde }}</p>
    </div>
    <div class="form-group">
      <label for="fecha_hasta">Fecha hasta:</label>
      <p>{{ Prestamo.fecha_hasta }}</p>
    </div>
    <div class="form-group">
      <label for="fecha_dev">Fecha devolucion:</label>
      <p>{{ Prestamo.fecha_dev }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";

export default {
  data() {
    return {
      Prestamo: {
        id: "",
        socio: "",
        libro: "",
        fecha_desde: "",
        fecha_hasta: "",
        fecha_dev: null
      }
    };
  },

  created() {
    this.buscar();
  },

  methods: {
    async buscar() {
      const res = await axios.get(
        "http://192.168.20.10/apiv1/prestamos/" + this.$route.params.id
      );
      this.Prestamo = res.data;
    }
  }
};
</script>

<style>
/* Estilos para los detalles del socio */
.prestamo-details {
  max-width: 400px;
  margin: 0 auto;
  padding: 30px;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  text-align: left;
  font-family: Arial, sans-serif;
}

h2 {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
  color: #333;
}

.form-group {
  margin-bottom: 15px;
}

label {
  font-size: 16px;
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
}

p {
  font-size: 16px;
}
</style>
