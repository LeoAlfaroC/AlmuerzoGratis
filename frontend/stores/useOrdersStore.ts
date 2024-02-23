import {defineStore} from "pinia";

export const useOrdersStore = defineStore('orders', () => {
  const orders = ref([]) as unknown as Array<any>;

  async function fetchOrders() {
    await useApi("/api/get-orders", {
      method: "POST",
    });
  }

  function addOrUpdateOrder(incomingOrder: Object) {
    const foundOrderIndex = orders.value.findIndex(order => order.id === incomingOrder.id);

    if (foundOrderIndex > -1) {
      orders.value.splice(foundOrderIndex, 1, incomingOrder);
    } else {
      orders.value.unshift(incomingOrder);
    }
  }

  return {orders, fetchOrders, addOrUpdateOrder};
});