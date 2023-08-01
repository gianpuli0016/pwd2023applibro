<template>
  <div class="socio-form">
    <h2>Crear nuevo socio</h2>

    <input
      v-model="Socio.nombre_apellido"
      label
      for="nombre y apellido"
      type="text"
      placeholder="Apellido y Nombre"
    />

    <input v-model="Socio.telefono" type="text" label="telefono" placeholder="Teléfono" />

    <input v-model="Socio.direccion" type="text" label="direccion" placeholder="Dirección" />

    <button class="btn-guardar" @click="createSocio(Socio)">Guardar</button>
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
        telefono: "",
        fecha_alta: new Date().toISOString().substring(0, 10),
        activo: 1
      }
    };
  },

  methods: {
    async createSocio(Socio) {
      console.log(Socio);
      const data = {
        id: Number(Socio.id),
        nombre_apellido: Socio.nombre_apellido,
        direccion: Socio.direccion,
        telefono: Number(Socio.telefono),
        fecha_alta: new Date().toISOString().substring(0, 10),
        activo: 1
      };
      console.log(data);
      const res = await axios.post(
        "http://192.168.20.10/apiv1/socios/nuevo",
        data
      );
      console.log(res);
      this.$router.push("/socios");
    }
  }
};
</script>

<style>
/* Estilos para el formulario del socio */
.socio-form {
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
