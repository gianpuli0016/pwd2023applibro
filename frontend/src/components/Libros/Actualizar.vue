<template>
  <div class="libro-form">
    <h2>Editar Libro</h2>

    <form @submit.prevent="saveLibro" style="width: 100%;">
      <div>
        <label for="titulo">Titulo</label>
        <input v-model="Libro.titulo" type="text" placeholder="Titulo" />
        <p v-if="errors.titulo" class="error">{{ errors.titulo }}</p>
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
      Autores: [],
      Categorias: [],
      Generos: [],
      Editoriales: [],
      Libro: {
        id: "",
        titulo: "",
        autor: [],
        id_genero: "",
        id_categoria: "",
        cant_paginas: "",
        anio: "",
        estado: "",
        id_editorial: ""
      },
      errors: {}
    };
  },

  created() {
    this.buscar();
  },

  methods: {
    async saveLibro() {
      if (this.validateForm()) {
        const data = {
          id: this.Libro.id,
          titulo: this.Libro.titulo
        };

        console.log(data);

        try {
          const res = await axios.put(
            "http://192.168.20.10/apiv1/libros/actualizar/" +
              this.$route.params.id,
            data
          );
          this.$router.push({ name: "Libros" });
        } catch (error) {
          console.log(error);
        }
      }
    },
    validateForm() {
      this.errors = {};
      let isValid = true;

      if (!this.Libro.titulo) {
        this.errors.titulo = "El título es obligatorio.";
        isValid = false;
      }

      return isValid;
    },
    async buscar() {
      try {
        const res = await axios.get(
          "http://192.168.20.10/apiv1/libros/" + this.$route.params.id
        );
        this.Libro = res.data;

        console.log(this.Libro);
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<style scoped>
.libro-form {
  width: 400px;
}
input,
select {
  margin-bottom: 10px;
}
.select-dropdown {
  width: 92%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: white;
}
</style>