// https://nuxt.com/docs/api/configuration/nuxt-config
import vuetify, { transformAssetUrls } from 'vite-plugin-vuetify';

export default defineNuxtConfig({
  devtools: {
    enabled: false,
  },
  ssr: false,
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
  build: {
    transpile: ['vuetify'],
  },
  modules: [
    '@pinia/nuxt',
    (_options, nuxt) => {
      nuxt.hooks.hook('vite:extendConfig', (config) => {
        // @ts-expect-error
        config.plugins.push(vuetify({ autoImport: true }))
      })
    },
  ],
  vite: {
    vue: {
      template: {
        transformAssetUrls,
      },
    },
  },
})