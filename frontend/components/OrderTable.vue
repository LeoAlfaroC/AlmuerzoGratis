<script lang="ts" setup>
import {useOrdersStore} from "~/stores/useOrdersStore";

const ordersStore = useOrdersStore();

const columns = [
  {
    key: 'recipe.name',
    label: 'Receta',
  },
  {
    key: 'status',
    label: 'Estado',
  },
];
</script>

<template>
  <h2>Órdenes recientes</h2>
  <UDivider />
  <UTable :rows="ordersStore.orders" :columns="columns"/>
</template>

<style scoped></style>
