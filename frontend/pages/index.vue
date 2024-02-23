<script lang="ts" setup>
import {useOrdersStore} from "~/stores/useOrdersStore";
import OrderTable from "~/components/OrderTable.vue";

definePageMeta({
  middleware: ['auth']
})

const {user} = useAuthStore();
const statusStore = useStatusStore();
const ordersStore = useOrdersStore();

const {execute} = await useApi('/api/process-order', {method: 'POST', immediate: false});
const status = ref('');

async function handleClick() {
  await execute();
}

</script>

<template>
  <div class="mx-auto w-1/3 md:w-1/3 sm:w-1/2">
  <button
      class="rounded-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"
      @click="handleClick"
  >
    Generar nuevo pedido
  </button>
  </div>
  <br>
  {{ statusStore.status }}

  <div class="grid grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
    <div>
      <OrderTable />
    </div>

    <div>
      <PurchasesTable />
    </div>
  </div>
</template>

<style scoped></style>
