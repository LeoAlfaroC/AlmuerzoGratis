<script lang="ts" setup>

definePageMeta({
  middleware: ['auth']
})

const {execute} = await useApi('/api/process-order', {method: 'POST'});

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
