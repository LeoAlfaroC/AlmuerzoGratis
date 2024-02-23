<script lang="ts" setup>
import {useOrdersStore} from "~/stores/useOrdersStore";

const ordersStore = useOrdersStore();
</script>

<template>
  <h2>Órdenes recientes</h2>

  <v-table>
    <thead>
    <tr>
      <th class="text-left">
        Receta
      </th>
      <th class="text-left">
        Estado
      </th>
    </tr>
    </thead>
    <tbody>
    <tr
        v-for="order in ordersStore.orders"
        :key="order.name"
    >
      <td>{{ order.recipe.name }}</td>
      <td>{{ order.status }}</td>
    </tr>
    </tbody>
  </v-table>
</template>

<style scoped></style>
