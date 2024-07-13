<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('food_type')->insert([
            'food_type' => 'Youruba',
        ]);
        DB::table('food_type')->insert([
            'food_type' => 'Igbo-Calabar',
        ]);
        DB::table('food_type')->insert([
            'food_type' => 'Intercontinental',
        ]);
    }
}
