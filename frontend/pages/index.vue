<script lang="ts" setup>
import {useOrdersStore} from "~/stores/useOrdersStore";
import OrderTable from "~/components/OrderTable.vue";

definePageMeta({
  middleware: ['auth']
})

const {user} = useAuthStore();
const statusStore = useStatusStore();

const {execute} = await useApi('/api/process-order', {method: 'POST', immediate: false});
const status = ref('');

async function handleClick() {
  await execute();
}

</script>

<template>
  <v-row>
    <v-col class="text-center">
      <v-btn
          @click="handleClick"
      >
        Generar nuevo pedido
      </v-btn>
    </v-col>
  </v-row>
  <v-row>
    <v-col class="text-center">
      {{ statusStore.status }}
    </v-col>
  </v-row>
  <v-row>
    <v-col>
      <OrderTable/>
    </v-col>

    <v-col>
      <PurchasesTable/>
    </v-col>
  </v-row>
</template>

<style scoped></style>
