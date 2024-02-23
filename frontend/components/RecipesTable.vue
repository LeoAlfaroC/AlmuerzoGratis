<script lang="ts" setup>
import {useRecipesStore} from "~/stores/useRecipesStore";

const recipesStore = useRecipesStore();
</script>

<template>
  <h2>Recetas disponibles</h2>

  <br>

  <template v-for="recipe in recipesStore.recipes"
            :key="recipe.id">
    <h3>{{ recipe.name }}</h3>

    <v-table>
      <thead>
      <tr>
        <th class="text-left">
          Ingrediente
        </th>
        <th class="text-left">
          Cantidad
        </th>
      </tr>
      </thead>
      <tbody>
      <tr
          v-for="ingredient in recipe.ingredients"
          :key="ingredient.id"
      >
        <td>{{ ingredient.name }}</td>
        <td>{{ ingredient.pivot.quantity }}</td>
      </tr>
      </tbody>
    </v-table>
  </template>
</template>

<style scoped></style>
