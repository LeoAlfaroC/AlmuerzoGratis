import Echo from "laravel-echo";
import Pusher from "pusher-js";

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig();

  const echo = new Echo({
    broadcaster: 'pusher',
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
  });

  return {
    provide: {
      echo,
    }
  };
})
