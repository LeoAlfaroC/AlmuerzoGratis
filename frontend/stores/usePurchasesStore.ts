import {defineStore} from "pinia";

export const usePurchasesStore = defineStore('purchases', () => {
  const purchases = ref([]);

  async function fetchPurchases() {
    await useApi("/api/get-purchases", {
      method: "POST",
    });
  }

  return {purchases, fetchPurchases};
});