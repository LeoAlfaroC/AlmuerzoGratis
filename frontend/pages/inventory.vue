<script lang="ts" setup>
definePageMeta({
  middleware: ['auth']
})
</script>

<template>
  <v-row>
    <v-col>
      <InventoryTable/>
    </v-col>
  </v-row>
</template>

<style scoped></style>
