import {defineStore} from "pinia";

export const useRecipesStore = defineStore('recipes', () => {
  const recipes = ref([]) as unknown as Array<any>;

  async function fetchRecipes() {
    await useApi("/api/get-recipes", {
      method: "POST",
    });
  }

  function updateRecipes(incomingRecipes: Array<Object>) {
    recipes.value = [...incomingRecipes];
  }

  return {recipes, fetchRecipes, updateRecipes};
});