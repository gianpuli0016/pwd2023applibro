<template>
  <div class="libro-form">
    <h2>Crear nuevo libro</h2>

    <form @submit.prevent="createLibro" style="width: 100%;">
      <div>
        <label for="titulo">Titulo</label>
        <input v-model="Libro.titulo" type="text" placeholder="Titulo" />
        <p v-if="errors.titulo" class="error">{{ errors.titulo }}</p>
      </div>

      <div>
        <label>Autor</label>
        <select v-model="Libro.autor" multiple class="select-dropdown">
          <option
            v-for="autor in Autores"
            :key="autor.id"
            :value="autor.id"
          >{{ autor.nombre_apellido }}</option>
        </select>
        <p v-if="errors.autor" class="error">{{ errors.autor }}</p>
      </div>

      <div>
        <label>Género</label>
        <select v-model="Libro.id_genero" class="select-dropdown">
          <option disabled value>Género</option>
          <option
            v-for="genero in Generos"
            :key="genero.id"
            :value="genero.id"
          >{{ genero.descripcion }}</option>
        </select>
        <p v-if="errors.id_genero" class="error">{{ errors.id_genero }}</p>
      </div>

      <div>
        <label>Categoría</label>
        <select v-model="Libro.id_categoria" class="select-dropdown">
          <option disabled value>Categoría</option>
          <option
            v-for="categoria in Categorias"
            :key="categoria.id"
            :value="categoria.id"
          >{{ categoria.descripcion }}</option>
        </select>
        <p v-if="errors.id_categoria" class="error">{{ errors.id_categoria }}</p>
      </div>

      <div>
        <label>Cantidad de paginas</label>
        <input
          v-model="Libro.cant_paginas"
          type="number"
          placeholder="Cantidad de paginas"
          :min="1"
          :max="10000"
        />
        <p v-if="errors.cant_paginas" class="error">{{ errors.cant_paginas }}</p>
      </div>

      <div>
        <label>Año</label>
        <input v-model="Libro.anio" type="number" placeholder="Año" :max="2023" />
        <p v-if="errors.anio" class="error">{{ errors.anio }}</p>
      </div>

      <div>
        <label>Editorial</label>
        <select v-model="Libro.id_editorial" class="select-dropdown">
          <option disabled value>Editorial</option>
          <option
            v-for="editorial in Editoriales"
            :key="editorial.id"
            :value="editorial.id"
          >{{ editorial.nombre }}</option>
        </select>
        <p v-if="errors.id_editorial" class="error">{{ errors.id_editorial }}</p>
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

  mounted() {
    this.listarAutores();
    this.listarCategorias();
    this.listarGeneros();
    this.listarEditoriales();
  },

  methods: {
    async createLibro() {
      if (this.validateForm()) {
        const data = {
          id: Number(this.Libro.id),
          titulo: this.Libro.titulo,
          autor: this.Libro.autor.map(autor => autor),
          id_genero: this.Libro.id_genero,
          id_categoria: this.Libro.id_categoria,
          cant_paginas: this.Libro.cant_paginas,
          anio: this.Libro.anio,
          id_editorial: this.Libro.id_editorial
        };
        try {
          const res = await axios.post(
            "http://192.168.20.10/apiv1/libros/nuevo",
            data
          );

          this.$router.push("/libros");
        } catch (error) {
          console.error(error);
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

      if (this.Libro.autor.length === 0) {
        this.errors.autor = "Debe seleccionar al menos un autor.";
        isValid = false;
      }

      if (!this.Libro.id_genero) {
        this.errors.id_genero = "Debe seleccionar un género.";
        isValid = false;
      }

      if (!this.Libro.id_categoria) {
        this.errors.id_categoria = "Debe seleccionar una categoría.";
        isValid = false;
      }

      if (!this.Libro.cant_paginas) {
        this.errors.cant_paginas = "Debe ingresar la cantidad de páginas.";
        isValid = false;
      }

      if (!this.Libro.anio) {
        this.errors.anio = "Debe ingresar el año.";
        isValid = false;
      }

      if (!this.Libro.id_editorial) {
        this.errors.id_editorial = "Debe seleccionar una editorial.";
        isValid = false;
      }

      return isValid;
    },
    async listarAutores() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/autores");
        this.Autores = res.data;
      } catch (error) {
        console.error(error);
      }
    },
    async listarCategorias() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/categorias");
        this.Categorias = res.data;
      } catch (error) {
        console.error(error);
      }
    },
    async listarGeneros() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/generos");
        this.Generos = res.data;
      } catch (error) {
        console.error(error);
      }
    },
    async listarEditoriales() {
      try {
        const res = await axios.get("http://192.168.20.10/apiv1/editoriales");
        this.Editoriales = res.data;
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