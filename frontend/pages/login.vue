<script lang="ts" setup>
  const form = ref({
    email: "test@example.com",
    password: "password",
  });

  const auth = useAuthStore();

  async function handleLogin() {
    if (auth.isLoggedIn) {
      return navigateTo("/");
    }

    const { error } = await auth.login(form.value);

    if (!error.value) {
      return navigateTo("/");
    }
  }
</script>

<template>
  <form @submit.prevent="handleLogin">
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
