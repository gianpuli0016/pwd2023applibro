<template>
  <nav class="menu-navigation">
    <div class="menu-title">APP DE LIBROS</div>
    <div class="menu-links">
      <router-link to="/">Home</router-link>
      <router-link to="/socios">Socios</router-link>
      <router-link to="/autores">Autores</router-link>
      <router-link to="/libros">Libros</router-link>
      <router-link to="/categorias">Categorias</router-link>
      <router-link to="/generos">Generos</router-link>
      <router-link to="/editoriales">Editoriales</router-link>
    </div>
  </nav>
</template>

<script setup>
// Importamos el componente router-link de Vue Router
import { RouterLink } from "vue-router";
</script>

<style>
/* Estilos para el menú de navegación */
.menu-navigation {
  display: flex;
  background-color: #65c7ca;
  justify-content: space-between;
  align-items: center; /* Centrar verticalmente los elementos dentro del menú */
  padding: 10px;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Agregar una sombra sutil */
}

/* Estilos para el título del menú */
.menu-title {
  font-size: 28px;
  font-weight: bold; /* Hacer el título en negrita */
  color: #ffffff; /* Cambiar el color del texto a blanco */
  font-family: "Pacifico", cursive; /* Fuente 'Pacifico' para el título */
  margin-left: 20px; /* Agregar un margen izquierdo para separar del borde */
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4); /* Agregar un sombreado al texto */
}

/* Estilos para los enlaces del menú */
.menu-links {
  margin-right: 20px;
  display: flex;
}

/* Estilos para los enlaces individuales del menú */
.menu-links a {
  color: #ffffff;
  text-decoration: none; /* Quitar subrayado de los enlaces */
  margin-right: 15px; /* Espaciado entre los enlaces */
  font-size: 18px;
  transition: 0.2s ease-in-out; /* Agregar una transición suave en hover */
  border-bottom: 2px solid transparent; /* Agregar una línea inferior transparente */
}

/* Estilos para resaltar el enlace activo (opcional) */
.menu-links a.active {
  border-bottom-color: #ffffff; /* Mostrar una línea inferior blanca para el enlace activo */
}

/* Estilos para resaltar el enlace al pasar el mouse */
.menu-links a:hover {
  transform: scale(1.1); /* Hacer que el enlace se agrande al pasar el mouse */
  color: #ffefaa; /* Cambiar el color del enlace al pasar el mouse */
}
</style>
