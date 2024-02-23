import {defineStore} from "pinia";

export const useInventoryStore = defineStore('inventory', () => {
  async function fetchInventory() {
    await useApi("/api/get-inventory", {
      method: "POST",
    });
  }

  const inventory = ref([]) as unknown as Array<any>;

  function updateInventory(incomingInventory: Array<Object>) {
    inventory.value = [...incomingInventory];
  }

  return {inventory, fetchInventory, updateInventory};
});