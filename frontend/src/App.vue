<template>
  <menu-navigation></menu-navigation>
  <router-view></router-view>
</template>

<script setup lang="ts">
import { defineComponent } from "vue";
import { useRoute, useRouter } from "vue-router";
import MenuNavigation from "./components/MenuNavigation.vue";
</script>

<style scoped></style>
