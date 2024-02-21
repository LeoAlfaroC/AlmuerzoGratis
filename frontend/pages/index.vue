<script lang="ts" setup>

definePageMeta({
  middleware: ['auth']
})
const {user} = useAuthStore();

const {execute} = await useApi('/api/process-order', {method: 'POST', immediate: false});

async function handleClick() {
  await execute();
}

</script>

<template>
  <button @click="handleClick">
    Generar nuevo pedido
  </button>
</template>

<style scoped></style>
