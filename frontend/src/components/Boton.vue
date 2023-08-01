<template>
  <button @click="onClick" :class="customClass">{{ label }}</button>
</template>
  
<script lang="ts">
export default {
  props: {
    label: {
      type: String,
      required: true
    },
    customClass: {
      type: String,
      default: ""
    }
  },
  methods: {
    onClick() {
      this.$emit("click");
    }
  }
};
</script>
  
  <style>
/* Estilos opcionales para el botón */
button {
  /* Estilos predeterminados para el botón */
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  background-color: #007bff;
  color: #fff;
  cursor: pointer;
}

/* Estilo personalizado si se proporciona una clase personalizada */
.custom-btn {
  /* Agrega tus estilos personalizados aquí */
}
</style>
  