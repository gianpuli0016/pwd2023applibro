<template>
  <div class="prestamo-form">
    <h2>Editar prestamo</h2>

    <div class="form-group">
      <label for="socio">Socio:</label>
      <input v-model="Prestamo.socio" type="text" id="socio" placeholder="Socio" />
    </div>

    <div class="form-group">
      <label for="libro">Libro:</label>
      <input v-model="Prestamo.nombre_apellido" type="text" id="libro" placeholder="Libro" />
    </div>

    <div class="form-group">
      <label for="fecha_hastsa">Fecha hasta:</label>
      <input
        v-model="Prestamo.nombre_apellido"
        type="text"
        id="fecha_hastsa"
        placeholder="Fecha hasta"
      />
    </div>

    <div class="form-group">
      <label for="fecha_dev">Fecha devolucion:</label>
      <input
        v-model="Prestamo.nombre_apellido"
        type="text"
        id="fecha_dev"
        placeholder="Fecha devolucion"
      />
    </div>

    <button class="btn-guardar" @click="ActualizarPrestamo(Prestamo)">Guardar</button>
  </div>
</template>
  
<script lang="ts">
import axios from "axios";

export default {
  data() {
    return {
      Prestamo: {
        id: "",
        nombre_apellido: ""
      }
    };
  },

  created() {
    this.buscar();
  },

  methods: {
    async ActualizarPrestamo(Prestamo: any) {
      const data = {
        id: Number(Prestamo.id),
        socio: Prestamo.socio,
        libro: Prestamo.libro,
        fecha_hasta: Prestamo.fecha_hasta,
        fecha_desde: Prestamo.fecha_desde
      };

      const res = await axios.put(
        "http://192.168.20.10/apiv1/prestamos/" + this.$route.params.id,
        data
      );
      console.log(res.data);
      this.$router.push("/prestamos");
    },
    async buscar() {
      const res = await axios.get(
        "http://192.168.20.10/apiv1/prestamos/" + this.$route.params.id
      );
      this.Prestamo = res.data;
      console.log(this.Prestamo);
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
