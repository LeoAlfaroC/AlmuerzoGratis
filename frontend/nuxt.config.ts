// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: {enabled: true},
  runtimeConfig: {
    public: {
      api_url: process.env.API_URL,
      app_url: process.env.APP_URL,
      // Websockets
      pusher_app_key: process.env.PUSHER_APP_KEY,
      pusher_host: process.env.PUSHER_HOST,
      pusher_port: process.env.PUSHER_PORT,
      pusher_use_wss: process.env.USE_WSS,
    }
  },
  modules: [
    '@pinia/nuxt',
  ],
})
