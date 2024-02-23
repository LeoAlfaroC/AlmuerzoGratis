<script lang="ts" setup>
import {useInventoryStore} from "~/stores/useInventoryStore";

const inventoryStore = useInventoryStore();
</script>

<template>
  <h2>Inventario</h2>

  <v-table>
    <thead>
    <tr>
      <th class="text-left">
        Ingrediente
      </th>
      <th class="text-left">
        Cantidad disponible
      </th>
    </tr>
    </thead>
    <tbody>
    <tr
        v-for="inventory in inventoryStore.inventory"
        :key="inventory.id"
    >
      <td>{{ inventory.ingredient.name }}</td>
      <td>{{ inventory.quantity }}</td>
    </tr>
    </tbody>
  </v-table>
</template>

<style scoped></style>
