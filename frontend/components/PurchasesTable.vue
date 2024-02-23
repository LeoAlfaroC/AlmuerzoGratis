<script lang="ts" setup>

import {usePurchasesStore} from "~/stores/usePurchasesStore";

const purchasesStore = usePurchasesStore();

const columns = [
  {
    key: 'ingredient.name',
    label: 'Ingrediente',
  },
  {
    key: 'quantity',
    label: 'Cantidad',
  },
];

const selectedColumns = ref([...columns])
</script>

<template>
  <h2>Compras recientes</h2>
  <UDivider />
  <div class="flex px-3 py-3.5 border-b border-gray-200 dark:border-gray-700">
    <USelectMenu v-model="selectedColumns" :options="columns" multiple placeholder="Columnas" />
  </div>
  <UDivider />
  <UTable :rows="purchasesStore.purchases" :columns="selectedColumns"/>
</template>

<style scoped></style>
