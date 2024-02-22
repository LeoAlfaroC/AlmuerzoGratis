<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')
            ->updateOrInsert([
                ['id'=> 1, 'name' => 'Tomato'],
                ['id'=> 2, 'name' => 'Lemon'],
                ['id'=> 3, 'name' => 'Potato'],
                ['id'=> 4, 'name' => 'Rice'],
                ['id'=> 5, 'name' => 'Ketchup'],
                ['id'=> 6, 'name' => 'Lettuce'],
                ['id'=> 7, 'name' => 'Onion'],
                ['id'=> 8, 'name' => 'Cheese'],
                ['id'=> 9, 'name' => 'Meat'],
                ['id'=> 10, 'name' => 'Chicken'],
            ]);
    }
}
