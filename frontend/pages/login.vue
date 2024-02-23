<script lang="ts" setup>
const errorMessage = ref();
const form = ref({
  email: "", //"test@example.com",
  password: "", //"password",
});

const auth = useAuthStore();

async function handleLogin() {
  if (auth.isLoggedIn) {
    return navigateTo("/");
  }

  const {error} = await auth.login(form.value);

  if (!error.value) {
    const {$echo, $attachListeners} = useNuxtApp();
    $attachListeners($echo, auth.user?.id);

    return navigateTo("/");
  } else {
    errorMessage.value = error.message;
  }
}
</script>

<template>
  <v-row>
    <v-col>
      <v-form @submit.prevent="handleLogin">
        {{ errorMessage }}
        <v-text-field
            v-model="form.email"
            :counter="10"
            label="Email"
            required
            hide-details
        ></v-text-field>
        <v-text-field
            v-model="form.password"
            :counter="10"
            label="Contraseña"
            required
            hide-details
            type="password"

        ></v-text-field>
        <v-btn type="submit">Login</v-btn>
      </v-form>
    </v-col>
  </v-row>
</template>

<style scoped></style>
