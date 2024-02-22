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
</script>

<template>
  <h2>Compras recientes</h2>
  <UDivider />
  <UTable :rows="purchasesStore.purchases" :columns="columns"/>
</template>

<style scoped></style>
