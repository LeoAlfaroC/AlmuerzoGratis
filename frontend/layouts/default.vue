<script lang="ts" setup>
const auth = useAuthStore();
</script>

<template>
  <v-layout class="rounded rounded-md">
    <v-app-bar title="Almuerzo Gratis"></v-app-bar>

    <v-navigation-drawer v-if="auth.isLoggedIn">
      <v-list>
        <v-list-item title="Hacer pedidos" @click="navigateTo('/')"></v-list-item>
        <v-list-item title="Recetas disponibles" @click="navigateTo('recipes')"></v-list-item>
        <v-list-item title="Invetaro actual" @click="navigateTo('inventory')"></v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-main class="d-flex align-center justify-center" style="min-height: 300px;">
      <v-container>
        <NuxtPage/>
      </v-container>
    </v-main>
  </v-layout>
</template>

<style scoped></style>
