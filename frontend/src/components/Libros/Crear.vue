<template>
  <div class="libro-form">
    <h2>Crear nuevo libro</h2>

    <input v-model="Libro.titulo" label for="titulo" type="text" placeholder="Titulo" />
    <input v-model="Libro.autor" label for="autor" type="text" placeholder="Autor" />
    <input v-model="Libro.id_genero" type="text" label="genero" placeholder="Genero" />

    <input v-model="Libro.id_categoria" type="text" label="categoria" placeholder="Categoria" />
    <input
      v-model="Libro.cant_paginas"
      type="text"
      label="cantidad de paginas"
      placeholder="Cantidad de paginas"
    />
    <input v-model="Libro.anio" type="text" label="año" placeholder="Año" />
    <input v-model="Libro.estado" type="text" label="estado" placeholder="Estado" />
    <input v-model="Libro.id_editorial" type="text" label="editorial" placeholder="Editorial" />

    <button class="btn-guardar" @click="createLibro(Libro)">Guardar</button>
  </div>
</template>
  
<script lang="ts">
import axios from "axios";

export default {
  data() {
    return {
      Libro: {
        id: "",
        titulo: "",
        autor: "",
        id_genero: "",
        id_categoria: "",
        cant_paginas: "",
        anio: "",
        estado: "",
        id_editorial: ""
      }
    };
  },

  methods: {
    async createLibro(Libro: any) {
      const data = {
        id: Number(Libro.id),
        titulo: Libro.titulo,
        autor: [Libro.autor],
        id_genero: Libro.id_genero,
        id_categoria: Libro.id_categoria,
        cant_paginas: Libro.cant_paginas,
        anio: Libro.anio,
        estado: Libro.estado,
        id_editorial: Libro.id_editorial
      };
      console.log(data);
      const res = await axios.post(
        "http://192.168.20.10/apiv1/libros/nuevo",
        data
      );
      console.log(res.data);
      this.$router.push("/libros");
    }
  }
};
</script>

