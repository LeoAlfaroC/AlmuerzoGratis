import {defineStore} from "pinia";

export const usePurchasesStore = defineStore('purchases', () => {
  const purchases = ref([]) as unknown as Array<any>;

  async function fetchPurchases() {
    await useApi("/api/get-purchases", {
      method: "POST",
    });
  }

  function addOrUpdatePurchase(incomingPurchase: Object)
  {
    const foundPurchaseIndex = purchases.value.findIndex(purchase => purchase.id === incomingPurchase.id);

    if (foundPurchaseIndex > -1) {
      purchases.value.splice(foundPurchaseIndex, 1, incomingPurchase);
    } else {
      purchases.value.unshift(incomingPurchase);
    }
  }

  return {purchases, fetchPurchases, addOrUpdatePurchase};
});