<template>
  <div class="genero-form">
    <h2>Editar genero</h2>

    <div class="form-group">
      <label for="descripcion">Descripcion:</label>
      <input v-model="Genero.descripcion" type="text" id="descripcion" placeholder="Descripcion" />
    </div>

    <button class="btn-guardar" @click="ActualizarGenero(Genero)">Guardar</button>
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
    async ActualizarGenero(Genero) {
      const data = {
        id: Genero.id,
        descripcion: Genero.descripcion
      };

      const res = await axios.put(
        "http://192.168.20.10/apiv1/generos/" + this.$route.params.id,
        data
      );
      console.log(res.data);
      this.$router.push("/generos");
    },
    async buscar() {
      const res = await axios.get(
        "http://192.168.20.10/apiv1/generos/" + this.$route.params.id
      );
      this.Genero = res.data;
      console.log(this.Genero);
    }
  }
};
</script>
  

<style>
/* Estilos para el formulario del socio */
.genero-form {
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
