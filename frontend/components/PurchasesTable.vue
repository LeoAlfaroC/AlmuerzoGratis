<script lang="ts" setup>

import {usePurchasesStore} from "~/stores/usePurchasesStore";

const purchasesStore = usePurchasesStore();
</script>

<template>
  <h2>Compras recientes</h2>

  <v-table>
    <thead>
    <tr>
      <th class="text-left">
        Name
      </th>
      <th class="text-left">
        Calories
      </th>
    </tr>
    </thead>
    <tbody>
    <tr
        v-for="purchase in purchasesStore.purchases"
        :key="purchase.name"
    >
      <td>{{ purchase.ingredient.name }}</td>
      <td>{{ purchase.quantity }}</td>
    </tr>
    </tbody>
  </v-table>
</template>

<style scoped></style>
