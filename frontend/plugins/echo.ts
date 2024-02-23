import Echo from "laravel-echo";
import Pusher from "pusher-js";
import {useOrdersStore} from "~/stores/useOrdersStore";
import {useStatusStore} from "~/stores/useStatusStore";
import {usePurchasesStore} from "~/stores/usePurchasesStore";
import {useRecipesStore} from "~/stores/useRecipesStore";
import {useInventoryStore} from "~/stores/useInventoryStore";

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig();
  const statusStore = useStatusStore();
  const ordersStore = useOrdersStore();
  const purchasesStore = usePurchasesStore();
  const recipesStore = useRecipesStore();
  const inventoryStore = useInventoryStore();

  const echo = new Echo({
    broadcaster: 'pusher',
    authEndpoint: config.public.api_url + '/broadcasting/auth',
    key: config.public.pusher_app_key,
    wsHost: config.public.pusher_host,
    wsPort: config.public.pusher_port,
    wssPort: config.public.pusher_port,
    forceTLS: config.public.pusher_use_wss === 'true',
    encrypted: config.public.pusher_use_wss === 'true',
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    cluster: '',
    Pusher: Pusher,
    authorizer: (channel: any, options: any) => {
      const config = useRuntimeConfig();
      const token = useCookie('XSRF-TOKEN');

      return {
        authorize: (socketId: string, callback: Function) => {
          const request = $fetch(config.public.api_url + '/broadcasting/auth', {
            async onRequest({request, options}) {
              options.method = 'post';
              options.body = {
                socket_id: socketId,
                channel_name: channel.name
              };
              options.headers = {
                'X-XSRF-TOKEN': token?.value as string,
                'Accept': 'application/json',
              };
              options.credentials = 'include';
            },
          })

          request.then((response) => callback(null, response));
        }
      };
    },
  });

  function attachListeners(echo: Echo, user_id: number | undefined) {
    ordersStore.fetchOrders();
    purchasesStore.fetchPurchases();
    recipesStore.fetchRecipes();
    inventoryStore.fetchInventory();

    echo.private('App.Models.User.' + user_id)
      .listen('SendingOrder', () => {
        console.log('SendingOrder');
        statusStore.status = 'Enviando orden';
      })
      .listen('OrdersListed', (e: any) => {
        console.log('OrdersListed', e);
        ordersStore.orders = e.orders;
      })
      .listen('PurchasesListed', (e: any) => {
        console.log('PurchasesListed', e);
        purchasesStore.purchases = e.purchases;
      })
      .error((error: any) => console.log(error));

    echo.private('new-events')
      .listen('PreparingOrder', (e: any) => {
        console.log('PreparingOrder', e);
        ordersStore.addOrUpdateOrder(e.order);
        statusStore.status = 'Preparando orden';
      })
      .listen('CheckingIngredients', (e: any) => {
        console.log('CheckingIngredients', e);
        ordersStore.addOrUpdateOrder(e.order);
        statusStore.status = 'Revisando disponibilidad de ingredientes';
      })
      .listen('BuyingIngredients', (e: any) => {
        console.log('BuyingIngredients', e);
        ordersStore.addOrUpdateOrder(e.order);
        statusStore.status = 'Comprando ingredientes faltantes';
      })
      .listen('IngredientPurchased', (e: any) => {
        console.log('IngredientPurchased', e);
        purchasesStore.addOrUpdatePurchase(e.purchase);
        statusStore.status = 'Ingrediente comprado';
      })
      .listen('OrderReady', (e: any) => {
        console.log('OrderReady', e);
        ordersStore.addOrUpdateOrder(e.order);
        statusStore.status = 'Orden lista!';
      })
      .listen('RecipesListed', (e: any) => {
        console.log('RecipesListed', e);
        recipesStore.updateRecipes(e.recipes);
      })
      .listen('InventoryListed', (e: any) => {
        console.log('InventoryListed', e);
        inventoryStore.updateInventory(e.inventory);
      });
  }

  return {
    provide: {
      echo,
      attachListeners,
    }
  };
})
