import {defineStore} from "pinia";

export const useStatusStore = defineStore('status', () => {
  const status = ref('');
  return {status};
});