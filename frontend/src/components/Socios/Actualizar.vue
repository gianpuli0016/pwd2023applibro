<template>
  <div class="socio-form">
    <h2>Editar socio</h2>

    <div class="form-group">
      <label for="nombre_apellido">Nombre y Apellido:</label>
      <input
        v-model="Socio.nombre_apellido"
        type="text"
        id="nombre_apellido"
        placeholder="Apellido y Nombre"
      />
    </div>

    <div class="form-group">
      <label for="telefono">Teléfono:</label>
      <input v-model="Socio.telefono" type="text" id="telefono" placeholder="Teléfono" />
    </div>

    <div class="form-group">
      <label for="direccion">Dirección:</label>
      <input v-model="Socio.direccion" type="text" id="direccion" placeholder="Dirección" />
    </div>

    <button class="btn-guardar" @click="ActualizarSocio(Socio)">Guardar</button>
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
    async ActualizarSocio(Socio) {
      console.log(Socio);
      const data = {
        id: Socio.id,
        nombre_apellido: Socio.nombre_apellido,
        telefono: Number(Socio.telefono),
        activo: Socio.activo,
        direccion: Socio.direccion,
        fecha_alta: Socio.fecha_alta
      };
      console.log(data);
      const res = await axios.put(
        "http://192.168.20.10/apiv1/socios/" + this.$route.params.id,
        data
      );
      console.log(res);
      this.$router.push("/socios");
    },
    async buscar() {
      const res = await axios.get(
        "http://192.168.20.10/apiv1/socios/" + this.$route.params.id
      );
      this.Socio = res.data;
    },
    // Método para cancelar la edición y cerrar el formulario de actualización
    cancelarEdicion() {
      this.socioIdSeleccionado = null; // Reiniciar el ID del socio seleccionado cuando se cancela la edición
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
