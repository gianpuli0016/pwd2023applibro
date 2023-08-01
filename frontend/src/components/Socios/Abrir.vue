<template>
  <div class="socio-details">
    <h2>Detalles del Socio</h2>

    <div class="form-group">
      <label for="nombre_apellido">Nombre y Apellido:</label>
      <p>{{ Socio.nombre_apellido }}</p>
    </div>

    <div class="form-group">
      <label for="telefono">Teléfono:</label>
      <p>{{ Socio.telefono }}</p>
    </div>

    <div class="form-group">
      <label for="direccion">Dirección:</label>
      <p>{{ Socio.direccion }}</p>
    </div>

    <div class="form-group">
      <label for="fecha_alta">Fecha de Alta:</label>
      <p>{{ Socio.fecha_alta }}</p>
    </div>

    <div class="form-group">
      <label for="activo">Activo:</label>
      <p>{{ Socio.activo === 1 ? "Sí" : "No" }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";

export default {
  data() {
    return {
      Socio: {
        id: "",
        nombre_apellido: "",
        direccion: "",
        telefono: Number(),
        fecha_alta: new Date().toISOString().substring(0, 10),
        activo: 1
      }
    };
  },

  created() {
    this.buscar();
  },

  methods: {
    async buscar() {
      const res = await axios.get(
        "http://192.168.20.10/apiv1/socios/" + this.$route.params.id
      );
      this.Socio = res.data;
    }
  }
};
</script>

<style>
/* Estilos para los detalles del socio */
.socio-details {
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
