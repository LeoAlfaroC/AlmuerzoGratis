<script lang="ts" setup>
  const form = ref({
    email: "test@example.com",
    password: "password",
  });
  const errorMessage = ref();

  const auth = useAuthStore();

  async function handleLogin() {
    if (auth.isLoggedIn) {
      return navigateTo("/");
    }

    const { error } = await auth.login(form.value);

    if (!error.value) {
      const {$echo} = useNuxtApp();
      $echo.private('App.Models.User.1')
          .listen('OrderDispatched', () => {
            console.log('Received!');
          })
          .error((error: any) => console.log(error));

      return navigateTo("/");
    } else {
      errorMessage.value = error.message;
    }
  }
</script>

<template>
  <form @submit.prevent="handleLogin">
    {{ errorMessage }}
    <label>
      Email
      <input v-model="form.email" type="email" />
    </label>
    <label>
      Password
      <input v-model="form.password" type="password" />
    </label>

    <button>Login</button>
  </form>
</template>

<style scoped></style>
