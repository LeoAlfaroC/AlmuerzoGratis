<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Recipes
        $ensalada = 1;
        $hamburguesas = 2;
        $pastel = 3;
        $pollo = 4;
        $papas = 5;
        $salteado = 6;

        // Ingredients
        $tomato = 1;
        $lemon = 2;
        $potato = 3;
        $rice = 4;
        $ketchup = 5;
        $lettuce = 6;
        $onion = 7;
        $cheese = 8;
        $meat = 9;
        $chicken = 10;


        DB::table('ingredient_recipe')
            ->insert([
                [
                    'recipe_id' => $ensalada,
                    'ingredient_id' => $chicken,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $ensalada,
                    'ingredient_id' => $lemon,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $ensalada,
                    'ingredient_id' => $lettuce,
                    'quantity' => 2,
                ],
                [
                    'recipe_id' => $ensalada,
                    'ingredient_id' => $tomato,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $ensalada,
                    'ingredient_id' => $onion,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $ensalada,
                    'ingredient_id' => $cheese,
                    'quantity' => 1,
                ],
            ]);

        DB::table('ingredient_recipe')
            ->insert([
                [
                    'recipe_id' => $hamburguesas,
                    'ingredient_id' => $meat,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $hamburguesas,
                    'ingredient_id' => $cheese,
                    'quantity' => 4,
                ],
                [
                    'recipe_id' => $hamburguesas,
                    'ingredient_id' => $lettuce,
                    'quantity' => 8,
                ],
                [
                    'recipe_id' => $hamburguesas,
                    'ingredient_id' => $tomato,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $hamburguesas,
                    'ingredient_id' => $onion,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $hamburguesas,
                    'ingredient_id' => $ketchup,
                    'quantity' => 1,
                ],
            ]);

        DB::table('ingredient_recipe')
            ->insert([
                [
                    'recipe_id' => $pastel,
                    'ingredient_id' => $potato,
                    'quantity' => 4,
                ],
                [
                    'recipe_id' => $pastel,
                    'ingredient_id' => $cheese,
                    'quantity' => 2,
                ],
                [
                    'recipe_id' => $pastel,
                    'ingredient_id' => $onion,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $pastel,
                    'ingredient_id' => $tomato,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $pastel,
                    'ingredient_id' => $meat,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $pastel,
                    'ingredient_id' => $ketchup,
                    'quantity' => 1,
                ],
            ]);

        DB::table('ingredient_recipe')
            ->insert([
                [
                    'recipe_id' => $pollo,
                    'ingredient_id' => $chicken,
                    'quantity' => 2,
                ],
                [
                    'recipe_id' => $pollo,
                    'ingredient_id' => $lemon,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $pollo,
                    'ingredient_id' => $rice,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $pollo,
                    'ingredient_id' => $onion,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $pollo,
                    'ingredient_id' => $lettuce,
                    'quantity' => 2,
                ],
                [
                    'recipe_id' => $pollo,
                    'ingredient_id' => $cheese,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $pollo,
                    'ingredient_id' => $tomato,
                    'quantity' => 1,
                ],
            ]);

        DB::table('ingredient_recipe')
            ->insert([
                [
                    'recipe_id' => $papas,
                    'ingredient_id' => $potato,
                    'quantity' => 4,
                ],
                [
                    'recipe_id' => $papas,
                    'ingredient_id' => $meat,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $papas,
                    'ingredient_id' => $onion,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $papas,
                    'ingredient_id' => $tomato,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $papas,
                    'ingredient_id' => $cheese,
                    'quantity' => 2,
                ],
                [
                    'recipe_id' => $papas,
                    'ingredient_id' => $ketchup,
                    'quantity' => 1,
                ],
            ]);

        DB::table('ingredient_recipe')
            ->insert([
                [
                    'recipe_id' => $salteado,
                    'ingredient_id' => $meat,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $salteado,
                    'ingredient_id' => $potato,
                    'quantity' => 3,
                ],
                [
                    'recipe_id' => $salteado,
                    'ingredient_id' => $onion,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $salteado,
                    'ingredient_id' => $tomato,
                    'quantity' => 1,
                ],
                [
                    'recipe_id' => $salteado,
                    'ingredient_id' => $ketchup,
                    'quantity' => 1,
                ],
            ]);
    }
}
