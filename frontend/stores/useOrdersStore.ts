import {defineStore} from "pinia";

export const useOrdersStore = defineStore('orders', () => {
  const orders = ref([]);

  async function fetchOrders() {
    await useApi("/api/get-orders", {
      method: "POST",
    });
  }

  return {orders, fetchOrders};
});