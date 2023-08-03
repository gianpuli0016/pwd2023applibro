<template>
  <div class="autor-form">
    <h2>Crear nuevo autor</h2>

    <input
      v-model="Autor.nombre_apellido"
      label
      for="nombre y apellido"
      type="text"
      placeholder="Apellido y Nombre"
    />
    <button class="btn-guardar" @click="createAutor(Autor)">Guardar</button>
  </div>
</template>

<script lang="ts">
import axios from "axios";

export default {
  data() {
    return {
      Autor: {
        id: "",
        nombre_apellido: ""
      }
    };
  },

  methods: {
    async createAutor(Autor: any) {
      const data = {
        id: Number(Autor.id),
        nombre_apellido: Autor.nombre_apellido
      };

      const res = await axios.post(
        "http://192.168.20.10/apiv1/autores/nuevo",
        data
      );

      this.$router.push("/autores");
    }
  }
};
</script>

<style>
/* Estilos para el formulario del socio */
.autor-form {
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
