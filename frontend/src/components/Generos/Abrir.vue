<template>
  <div class="genero-details">
    <h2>Detalles de la Genero</h2>

    <div class="form-group">
      <label for="descripcion">Descripcion:</label>
      <p>{{ Genero.descripcion }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";

export default {
  data() {
    return {
      Genero: {
        id: "",
        descripcion: ""
      }
    };
  },

  created() {
    this.buscar();
  },

  methods: {
    async buscar() {
      const res = await axios.get(
        "http://192.168.20.10/apiv1/generos/" + this.$route.params.id
      );
      this.Genero = res.data;
    }
  }
};
</script>

<style>
/* Estilos para los detalles del socio */
.genero-details {
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
