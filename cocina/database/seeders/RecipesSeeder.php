<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('recipes')
            ->updateOrInsert([
                ['id'=> 1, 'name' => 'Ensalada de Pollo con Aderezo de Limón'],
                ['id'=> 2, 'name' => 'Hamburguesas de Queso Envueltas en Lechuga'],
                ['id'=> 3, 'name' => 'Pastel de Papas con Queso'],
                ['id'=> 4, 'name' => 'Pollo con Limón y Hierbas con Arroz'],
                ['id'=> 5, 'name' => 'Papas Rellenas de Carne'],
                ['id'=> 6, 'name' => 'Salteado de Carne y Papas'],
            ]);
    }
}
