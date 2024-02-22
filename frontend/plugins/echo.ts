import Echo from "laravel-echo";
import Pusher from "pusher-js";
import {useOrdersStore} from "~/stores/useOrdersStore";
import {useStatusStore} from "~/stores/useStatusStore";
import {usePurchasesStore} from "~/stores/usePurchasesStore";

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig();
  const statusStore = useStatusStore();
  const ordersStore = useOrdersStore();
  const purchasesStore = usePurchasesStore();

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

    echo.private('App.Models.User.' + user_id)
      .listen('SendingOrder', () => {
        console.log('Received!');
        statusStore.status = 'Enviando orden';
      })
      .listen('OrdersListed', (e: any) => {
        ordersStore.orders = e.orders;
      })
      .listen('PurchasesListed', (e: any) => {
        purchasesStore.purchases = e.purchases;
      })
      .error((error: any) => console.log(error));

    echo.private('orders')
      .listen('PreparingOrder', (e: any) => {
        console.log(e);
        statusStore.status = 'Preparando orden';
      })
      .listen('CheckingIngredients', (e: any) => {
        console.log(e);
        statusStore.status = 'Revisando disponibilidad de ingredientes';
      })
      .listen('BuyingIngredients', (e: any) => {
        console.log(e);
        statusStore.status = 'Comprando ingredientes faltantes';
      })
      .listen('OrderReady', (e: any) => {
        console.log(e);
        statusStore.status = 'Orden lista!';
      });
  }

  return {
    provide: {
      echo,
      attachListeners,
    }
  };
})
