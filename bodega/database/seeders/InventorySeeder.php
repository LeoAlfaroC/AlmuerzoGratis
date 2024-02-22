<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventory')
            ->updateOrInsert([
                ['ingredient_id'=> 1, 'quantity' => 5],
                ['ingredient_id'=> 2, 'quantity' => 5],
                ['ingredient_id'=> 3, 'quantity' => 5],
                ['ingredient_id'=> 4, 'quantity' => 5],
                ['ingredient_id'=> 5, 'quantity' => 5],
                ['ingredient_id'=> 6, 'quantity' => 5],
                ['ingredient_id'=> 7, 'quantity' => 5],
                ['ingredient_id'=> 8, 'quantity' => 5],
                ['ingredient_id'=> 9, 'quantity' => 5],
                ['ingredient_id'=> 10, 'quantity' => 5],
            ]);
    }
}
