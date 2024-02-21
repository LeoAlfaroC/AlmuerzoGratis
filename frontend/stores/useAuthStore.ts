import {defineStore} from "pinia";
import {useApi} from "~/composables/useApi";

type User = {
  id: number;
  name: string;
  email: string;
}

type Credentials = {
  email: string;
  password: string;
}

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const isLoggedIn = computed(() => !!user.value)

  async function logout() {
    await useApi("/logout", {method: "POST"});
    user.value = null;
    navigateTo("/login");
  }

  async function fetchUser() {
    const {data, error} = await useApi("/api/user");
    user.value = data.value as User;
  }

  async function login(credentials: Credentials) {
    await useApi("/sanctum/csrf-cookie");

    const login = await useApi("/login", {
      method: "POST",
      body: credentials,
    });

    await fetchUser();

    return login;
  }

  return {user, login, isLoggedIn, fetchUser, logout}
})