import Echo from "laravel-echo";
import Pusher from "pusher-js";

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig();

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
              options.method = 'post'
              options.body = {
                socket_id: socketId,
                channel_name: channel.name
              }
              options.headers = {
                'X-XSRF-TOKEN': token?.value as string,
                'Accept': 'application/json',
              },
                options.credentials = 'include'
            },
          })

          request.then((response) => callback(null, response));
        }
      };
    },
  });

  return {
    provide: {
      echo,
    }
  };
})
